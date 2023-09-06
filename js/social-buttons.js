
 jQuery(document).ready(function($)
 {
	$('.social-button').each(function()
	{		
		var socialLink = $(this);
		var upImage = socialLink.children('.social-up-image');
		var downImage = socialLink.children('.social-down-image');
		
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
		socialLink.on('mouseenter', function () { SetDown(); });
		socialLink.on('mouseleave', function () { SetUp(); });
		socialLink.on('touchend', function () { SetDown(); });		
	});
 });