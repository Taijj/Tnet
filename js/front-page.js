jQuery(document).ready(function($) {

    var gatesSection = $('.home-gates-section');
    var welcomeSection = $('.home-welcome-section');
    var pageWrapper = $('.page-wrapper');

    window.addEventListener('orientationchange', onScreenSizeChange, false);
    window.addEventListener('resize', onScreenSizeChange, false);
    window.addEventListener('load', onWindowLoaded, false);

    pageWrapper.addClass("hidden");

    function onWindowLoaded()
    {
        pageWrapper.removeClass("hidden");
        onScreenSizeChange();
    }

    function onScreenSizeChange()
    {
        if(window.innerWidth <= 780)
        {
            gatesSection.css("max-height", "100%");
            gatesSection.css("overflow", "hidden");
            stopIntersectingScrolling();
        }
        else
        {
            gatesSection.css("max-height", welcomeSection.height()+25);
            gatesSection.css("overflow", "hidden");
            gatesSection.css("overflow-y", "auto");
            startInterceptingScrolling();
        }
    }

    function startInterceptingScrolling()
    {
        //Prevents adding of listener multiple times
        pageWrapper.off('mousewheel').on('mousewheel', function(e)
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

        function doScrolling(delta)
        {
            var displayedHeight = gatesSection.height();
            var fullHeight = gatesSection[0].scrollHeight;
            var maxScroll = fullHeight-displayedHeight;

            if(delta < 0 && gatesSection.scrollTop() <= 5)
            {
                gatesSection.scrollTop(0);
                return false;
            }
            if(delta > 0 && gatesSection.scrollTop() >= maxScroll-5)
            {
                gatesSection.scrollTop(maxScroll);
                return false;
            }

            gatesSection.scrollTop(gatesSection.scrollTop() + delta);
            return true;
        }
    }

    function stopIntersectingScrolling()
    {
        pageWrapper.off('mousewheel');
        gatesSection.scrollTop(0);
    }
 });