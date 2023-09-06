// Handpicked from Wordpress page editing, very rigid!
var sets =
[
    { hash: "#private", en:"1947", de:"1949" },
    { hash: "#privA", en:"6902", de:"6926" },
    { hash: "#privB", en:"6904", de:"6927" },
    { hash: "#privC", en:"6899", de:"6928" },
    { hash: "#privD", en:"6819", de:"6929" },
    { hash: "#privE", en:"6897", de:"6930" },
    { hash: "#professional", en:"6800", de:"6802" },
    { hash: "#profA", en:"6907", de:"6937" },
    { hash: "#profB", en:"6915", de:"6938" },
    { hash: "#profC", en:"6909", de:"6939" },
    { hash: "#profD", en:"6913", de:"6940" },
    { hash: "#profE", en:"6911", de:"6941" }
];

var unlockCookieKey = "tnet-professional-portfolio-unlocked";



jQuery(document).ready(function($) {

    var contentContainer = $('#portfolio-content');

    //REGION: Tabs
    var privateTabButton = $('#private-tab-button');
    var professTabButton = $('#professional-tab-button');
    var tabBackButton = $('#tab-back-button');
    var bottomBackButtonContainer = $('#bottom-back-button-container');

    privateTabButton.click(function()
    {
        setContentTo(sets[0].hash);
    });

    professTabButton.click(function()
    {
        setContentTo(sets[6].hash);
    });

    function updateTabs()
    {
        var privateTabButton = $('#private-tab-button');
        var professTabButton = $('#professional-tab-button');
        privateTabButton.removeClass('current-tab');
        professTabButton.removeClass('current-tab');

        if(isPublic())
        {
            privateTabButton.addClass('current-tab');
        }
        else
        {
            professTabButton.addClass('current-tab');
        }
    }



    //REGION: Back Buttons
    tabBackButton.click(goBack);
    $('#bottom-back-button').click(goBack);
    window.addEventListener('orientationchange', updateBackButtons, false);
    window.addEventListener('resize', updateBackButtons, false);
    function goBack()
    {
        if(isPublic())
        {
            setContentTo(sets[0].hash);
        }
        else
        {
            setContentTo(sets[6].hash);
        }
    }

    function updateBackButtons()
    {
        var currentSetIndex = getCurrentSetIndex();
        var isProjectPage = currentSetIndex != 0 && currentSetIndex != 6;
        var windowIsLargeEnough = $(window).width() >= 460;

        if(isProjectPage)
        {
            bottomBackButtonContainer.removeClass("hidden");
            if(windowIsLargeEnough)
            {
                tabBackButton.removeClass("hidden");
            }
            else
            {
                tabBackButton.addClass("hidden");
            }
        }
        else
        {
            tabBackButton.addClass("hidden");
            bottomBackButtonContainer.addClass("hidden");
        }
    }



    //REGION: Projects
    function addProjectListeners()
    {
        $('.portfolio-project-container').click(onProjectBannerClick);
    }

    function onProjectBannerClick()
    {
        var hash = $(this).data('hash');
        setContentTo('#' + hash);
    }



    //REGION: Password
    var unlockSection = $('#portfolio-unlock-section');
    $('#portfolio-unlock-form').submit(onUnlockFormSubmit);
    $('.submit-button').click(onUnlockFormSubmit);

    function onUnlockFormSubmit(e)
    {
        e.preventDefault();

        var input = $('#portfolio-unlock').val();
        var data = { action: "tnet_verify_portfolio_password", input: input };
        useAjax(data, function(response)
        {
            if(response == "true")
            {
                unlock();
            }
            else
            {
                $('#portfolio-invalid-input').removeClass('hidden');
            }
        });
    }

    function unlock()
    {
        onUnlocked(window.location.hash);
        setCookie(unlockCookieKey, true);
    }

    function showUnlockForm()
    {
        contentContainer.html('');
        unlockSection.removeClass('hidden');
    }

    function isUnlocked()
    {
        var cookieValue = getCookie(unlockCookieKey);
        if(isPublic() || cookieValue === "true")
        {
            return true;
        }
        else
        {
            showUnlockForm();
        }
    }



    //REGION: Content
    showInitialContent();
    window.addEventListener('popstate', showInitialContent);

    function showInitialContent()
    {
        var currentHash = window.location.hash;
        if(currentHash == "")
        {
            currentHash = sets[0].hash;
        }
        setContentTo(currentHash);
    }

    function setContentTo(newHash)
    {
        window.location.hash = newHash;
        cleanup();

        if(isUnlocked())
        {
            onUnlocked(newHash);
        }
        else
        {
            showUnlockForm();
            updateLanguageButtons();
            updateTabs();
            updateBackButtons();
        }
    }

    function onUnlocked(hash)
    {
        var set = sets.find(s => { return s.hash == hash })
        var currentLanguage = $('#data-provider').data('lang');

        unlockSection.addClass('hidden');
        loadContent(set[currentLanguage]);
    }

    function loadContent(id)
    {
        var data = { action: "tnet_load_post_content", pageId: id };
        useAjax(data, onContentLoaded);
    }

    function onContentLoaded(response)
    {
        var data = JSON.parse(response);

        contentContainer.html(data[0]);
        addMissingStyles(data[1]);
        addMissingScripts();
        addProjectListeners();
        updateTabs();
        updateLanguageButtons();
        updateBackButtons();
        scrollToTop();
    }

    function addMissingStyles(css)
    {
        if(css == '')
        {
            return;
        }

        var siteOriginId = "#siteorigin-panels-layouts-head";
        tryRemove(siteOriginId);
        var styles = '<style type="text/css" media="all" id="'+siteOriginId+'">'+css+'</style>';
        $('head').append(styles);
    }

    function addMissingScripts()
    {
        // Need a timeout here, gallery-widget might not be there, yet
        setTimeout(function()
        {
            if( $(".gallery-widget").length ) //<- this means: does "gallery-widget" exist
            {
                if( $("#gallery-widget-js").length ) //<- this means: the gallery widget javascript is already there
                {
                    return;
                }
                $("head").append('<script type="text/javascript" src="https://taijj.net/wp-content/themes/tnet/js/gallery-widget.js?ver=5.5" id="gallery-widget-js"></script>');
            }
        }, 1000);
    }

    function updateLanguageButtons()
    {
        $('.language-switcher .lang-item a').each(updateUrl);
        $('.header-language-section .lang-item a').each(updateUrl);

        function updateUrl()
        {
            var item = $(this);
            var url = item.attr('href');

            var hashIndex = url.indexOf('#');
            if(hashIndex >= 0)
            {
                url = url.substr(0, hashIndex);
            }
            item.attr('href', url+window.location.hash);
        }
    }



    // REGION: Cookies
    function setCookie(key, value)
    {
        var expirationDays = 14;
        var date = new Date();
        date.setDate(date.getDate()+expirationDays);
        var expiration = "; expires=" + date.toGMTString();

        var escapedValue = escape(value);
        var path = "; path=/";
        document.cookie = key + "=" + escapedValue + expiration + path;
    }

    function getCookie(key)
    {
        var cookies = document.cookie.split(";");
        for(var i = 0; i < cookies.length; i++)
        {
            var currentKey = cookies[i].substr(0, cookies[i].indexOf("="));
            var currentValue = cookies[i].substr(cookies[i].indexOf("=") + 1);
            currentKey = currentKey.replace(/^\s+|\s+$/g, "");
            if(currentKey == key)
            {
                return unescape(currentValue);
            }
        }
    }



    // REGION: Utils
    function isPublic()
    {
        return getCurrentSetIndex() < 6;
    }

    function getCurrentSetIndex()
    {
        for(var i = 0; i < sets.length; i++)
        {
            if(sets[i].hash == window.location.hash)
            {
                return i;
            }
        }
    }

    function tryRemove(id)
    {
        var element = document.getElementById(id);
        if(element !== null)
        {
            element.parentNode.removeChild(element);
        }
    }

    function cleanup()
    {
        var modal = $('#gallery-widget-modal');
        if( modal.length != 0 )
        {
            $(body).removeClass('no-scroll');
            modal.addClass("hidden");
        }

        tryRemove('gallery-widget-js');
    }

    function scrollToTop()
    {
        var html = $('html');
        var target = $('#scroll-target');

        var needsScroll = html.scrollTop() > target.offset().top;
        if(needsScroll)
        {
            html.scrollTop(target.offset().top);
        }
    }

    function useAjax(data, onSuccess)
    {
        $.ajax({
            type: "post",
            url: ajaxAdmin.ajaxurl, // defined in functions.php wp_localize_script()
            cache: false,
            data: data,
            success: onSuccess
        });
    }
});