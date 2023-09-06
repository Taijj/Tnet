 jQuery(document).ready(function($)
 {
	// Flag for comic nav jumping
	var navIsInDesktop = true;

	// Loader
	$('#comic-page-content').addClass('hidden');	
	checkIfWindowLoaded();	
	function checkIfWindowLoaded()
	{
		if(document.readyState === "complete")
			onWindowLoadedCompletely();
		else
			poll();
	}
	function poll() { setTimeout(checkIfWindowLoaded, 1000); }	
		
	function onWindowLoadedCompletely()
	{
		$('#comic-page-content').removeClass('hidden');
		$('#comic-loader').addClass('hidden');

		// Title text
		$(window).on('orientationchange resize', truncateMeta);
		truncateMeta();

		// Scroll to episode
		if($(window).height() < 730 && $(window).width() > 512) $('html, body').animate( { scrollTop: $("#comic-page-content").offset().top }, 500 );

	}

	// Title truncate
	function truncateMeta()
	{
		var episodeTitle = $('#episode-title').data('title');

		if(episodeTitle.length > 25 && $(window).width() < 1024)
			episodeTitle = episodeTitle.substr(0, 25) + "..."

		if(episodeTitle.length > 12 && $(window).width() < 780)
			episodeTitle = episodeTitle.substr(0, 12) + "..."

		$('#episode-title').html(episodeTitle);
	}



	//Nav
	var episodeIndex = $('.comic-nav').data('episode-index');
	var episodeCount = $('.comic-nav').data('episode-count');

	$('#comic-nav-first-disabled').css('display', episodeIndex != 0 ? 'none' : 'inherit');
	$('*[id*=comic-nav-first-enabled]').each(function() { $(this).css('display', episodeIndex == 0 ? 'none' : 'inherit'); });

	$('#comic-nav-previous-disabled').css('display', episodeIndex != 0 ? 'none' : 'inherit');
	$('*[id*=comic-nav-previous-enabled]').each(function() { $(this).css('display', episodeIndex == 0 ? 'none' : 'inherit'); });

	$('#comic-nav-last-disabled').css('display', episodeIndex != episodeCount-1 ? 'none' : 'inherit');
	$('*[id*=comic-nav-last-enabled]').each(function() { $(this).css('display', episodeIndex == episodeCount-1 ? 'none' : 'inherit'); });

	$('#comic-nav-next-disabled').css('display', episodeIndex != episodeCount-1 ? 'none' : 'inherit');
	$('*[id*=comic-nav-next-enabled]').each(function() { $(this).css('display', episodeIndex == episodeCount-1 ? 'none' : 'inherit'); });

	// Fix Jump to first Episode bug, when switching languages
	$('.lang-item a').each( function()
	{
		$(this).on('click', function(event)
		{
			event.preventDefault();

			var href = $(this).attr('href');
			var episode = GetParameterFromURL('episode');

			if(episode != null)
				href = href + '?episode=' + episode;

			window.location.href = href;
		});
	});

	function GetParameterFromURL(parameter)
	{
		var pageURL = decodeURIComponent(window.location.search.substring(1));
		var pageParameters = pageURL.split('&');
		var currentParameter;

		for(var i = 0; i < pageParameters.length; i++)
		{
			currentParameter = pageParameters[i].split('=');

			if(currentParameter[0] === parameter)
				return currentParameter[1] === undefined ? null : currentParameter[1];
		}

		return null;
    }
});

