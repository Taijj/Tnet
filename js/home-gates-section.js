jQuery(document).ready(function($) {

    truncateHomeSection();
    transferScrolling();



    function truncateHomeSection()
    {
        var gatesSection = $('.home-gates-section');
        var welcomeSection = $('.home-welcome-section');

        window.addEventListener('orientationchange', onScreenSizeChange, false);
        window.addEventListener('resize', onScreenSizeChange, false);

        $('.page-wrapper').addClass("hidden");
        window.onload = onWindowLoaded;

        function onWindowLoaded()
        {
            $('.page-wrapper').removeClass("hidden");
            onScreenSizeChange();
        }

        function onScreenSizeChange()
        {
            if(window.innerWidth <= 750)
            {
                gatesSection.css("max-height", "100%");
                gatesSection.css("overflow", "hidden");
            }
            else
            {
                gatesSection.css("max-height", welcomeSection.height()+25);
                gatesSection.css("overflow", "hidden");
                gatesSection.css("overflow-y", "auto");
            }

            if(window.innerWidth <= 750)
            {
                return;
            }
        }
    }

    function transferScrolling()
    {
        $('.page-wrapper').on('mousewheel', function(e)
        {
            var dir = e.originalEvent.deltaY/100;
            var delta = 30*dir;

            if( doScrolling(delta) )
            {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        });

        var lastTouch;
        $('.page-wrapper').on('touchstart', function(event)
        {
            lastTouch = event.originalEvent.touches[0].pageY;
        });

        $('.page-wrapper').on('touchmove', function(event)
        {
            var delta = lastTouch - event.originalEvent.touches[0].pageY;

            if( doScrolling(delta) )
            {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        });

        function doScrolling(delta)
        {
            var gatesSection = $('.home-gates-section');
            var displayedHeight = gatesSection.height();
            var fullHeight = gatesSection[0].scrollHeight;
            var maxScroll = fullHeight-displayedHeight;

            if(delta < 0 && gatesSection.scrollTop() <= 5)
            {
                return false;
            }
            if(delta > 0 && gatesSection.scrollTop() >= maxScroll-5)
            {
                return false;
            }

            gatesSection.scrollTop(gatesSection.scrollTop() + delta);
            return true;
        }
    }
 });