
 jQuery(document).ready(function($)
 {
	headerLink = $('#comic-header-link');
	upImage = $('#header-up-image');
	downImage = $('#header-down-image');
	
	var upUrl = headerLink.data('up-url');
	var downUrl = headerLink.data('down-url');
	
	upImage.css('background-image', 'url(' + upUrl + ')');
	downImage.css('background-image', 'url(' + downUrl + ')');
	
	function SetUp()
	{
		upImage.css('display', 'inline-block');
		downImage.css('display', 'none');
	}
	
	function SetDown()	
	{ 
		upImage.css('display', 'none');
		downImage.css('display', 'inline-block');
	}	
	
	SetUp();
	headerLink.on('mouseenter', function () { SetDown(); });
	headerLink.on('mouseleave', function () { SetUp(); });
	headerLink.on('touchend', function () { SetDown(); });
 });
 