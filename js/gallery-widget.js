var scrollPosition;
var page;
var body;

var modal;
var imageSection;
var image;
var imageLayouter;
var loader;

var focus;



//REGION: Main
jQuery(document).ready(function ($)
{
	initModal();
	initScrolling();

	$('.gallery-widget-image').click(function()
	{
		focus = $(this);
		showModal();
	});



	//REGION: Modal Init
	function initModal()
	{
		if( $('#gallery-widget-modal').length == 0 )
		{
			loadModal();
		}
		else
		{
			onModalLoaded();
		}
	}

	function loadModal()
	{
		$.ajax({
			type: "post",
			url: ajaxAdmin.ajaxurl, // defined in widgets.php wp_localize_script()
			cache: false,
			data: {	action: "tnet_load_gallery_modal" },
			success: function(response)
			{
				$( body ).append(response);
				onModalLoaded();
			}
		});
	}

	function onModalLoaded()
	{
		modal = $('#gallery-widget-modal');
		imageSection = $('#gallery-widget-modal-image-section');
		image = $('#gallery-widget-modal-image');
		loader = $('#gallery-widget-modal-image-loader');
		imageLayouter = $('#gallery-widget-modal-image-layouter');

		image.click(next);
		modal.click(close);
		$('#gallery-widget-modal-next').click(next);
		$('#gallery-widget-modal-previous').click(prev);
		$('#gallery-widget-modal-close').click(close);

		image.on('load', hideLoader);
	}



	//REGION: Navigation
	function next(e)
	{
		consume(e);

		var next = focus.next();
		if(next.length == 0)
		{
			next = focus.siblings().first();
		}
		focus = next;

		showModal();
	}

	function prev(e)
	{
		consume(e);

		var prev = focus.prev();
		if(prev.length == 0)
		{
			prev = focus.siblings().last();
		}
		focus = prev;

		showModal();
	}

	function close(e)
	{
		consume(e);
		hideModal();
	}

	function consume(e)
	{
		e.preventDefault();
		e.stopPropagation();
	}



	//REGION Modal Runtime
	function showModal()
	{
		if(modal.hasClass('hidden'))
		{
			scrollPosition = page.scrollTop();
			modal.removeClass('hidden');
		}

		image.attr('src', focus.data('src'));
		showLoader()
		disableScrolling();
	}

	function hideModal()
	{
		if(!modal.hasClass('hidden'))
		{
			modal.addClass('hidden');
		}
		enableScrolling();
	}


	//REGION: Loader
	var timeOut;

	function showLoader()
	{
		clearTimeout(timeOut);
		timeOut = setTimeout(function ()
		{
			imageLayouter.addClass('hidden');
			loader.removeClass('hidden');
		}, 1000);
	}

	function hideLoader()
	{
		clearTimeout(timeOut);
		if(imageLayouter.hasClass('hidden'))
		{
			imageLayouter.removeClass('hidden');
			loader.addClass('hidden');
		}
	}



	//REGION: Scrolling
	function initScrolling()
	{
		page = $(window);
		body = $('body');
	}

	function enableScrolling()
	{
		body.removeClass('no-scroll');
		page.scrollTop(scrollPosition);
	}

	function disableScrolling()
	{
		body.addClass('no-scroll');
	}
});