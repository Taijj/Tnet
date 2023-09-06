
 jQuery(document).ready(function($)
 {
	var headerLink = $('.header-images-link');
	var upImage = $('.header-up-image');
	var downImage = $('.header-down-image');

	function SetUp()
	{
		upImage.removeClass('hidden');
		downImage.addClass('hidden');
	}

	function SetDown()
	{
		upImage.addClass('hidden');
		downImage.removeClass('hidden');
	}

	SetUp();
	headerLink.on('mouseenter', function () { SetDown(); });
	headerLink.on('mouseleave', function () { SetUp(); });
	headerLink.on('touchend', function () { SetDown(); });
 });
