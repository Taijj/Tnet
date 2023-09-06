
 jQuery(document).ready(function($) {

	var isOpen = false;
	var menu = $('.nav-menu-mobile');
	var button = $('.mobile-menu-button');  //<- Located in header.php!

	setupInteraction();
	setupScreenSizeChange();
	addAdditionalClasses();

	function setupInteraction()
	{
		menu.addClass('hidden');
		button.on('click', function ()
		{
			if(isOpen)
			{
				Close();
			}
			else
			{
				Open();
			}
		});

		function Open()
		{
			isOpen = true;
			menu.removeClass('hidden');

		}

		function Close()
		{
			isOpen = false;
			menu.addClass('hidden');
		}
	}

	function setupScreenSizeChange()
	{
		window.addEventListener('orientationchange', OnScreenSizeChange, false);
		window.addEventListener('resize', OnScreenSizeChange, false);

		function OnScreenSizeChange()
		{
			if( window.innerWidth < 850 && isOpen) menu.removeClass('hidden');
			else menu.addClass('hidden');
		}
	}

	function addAdditionalClasses()
	{
		$('.menu-image').addClass("nearest-neighbor");
		$('.lang-item').addClass("nearest-neighbor");
	}
 });