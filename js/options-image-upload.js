

jQuery(document).ready(function($) {

	var index;
	var lastButtonType;
	var up;
	var left;
	var en;	
	
	$(".social_image_upload_button").click(function()
	{
		index = $(this).attr("index");
		up = $(this).attr("up");
		lastButtonType = "social";
		
		tb_show('Upload Social Button Image', 'media-upload.php?referer=tnet_menu_page&type=image&TB_iframe=true&post_id=0', false);
        return false;		
	});
	
	$(".main_header_image_upload_button").click(function()
	{
		index = $(this).attr("index");		
		lastButtonType = "mainImage";
		
		tb_show('Upload Main Image', 'media-upload.php?referer=tnet_menu_page&type=image&TB_iframe=true&post_id=0', false);
        return false;		
	});
	
	$(".blog_emotion_image_upload_button").click(function()
	{
		index = $(this).attr("index");		
		lastButtonType = "blogEmotion";
		
		tb_show('Upload Blog Emotion Image', 'media-upload.php?referer=tnet_menu_page&type=image&TB_iframe=true&post_id=0', false);
        return false;		
	});
	
	$(".cast_image_upload_button").click(function()
	{
		index = $(this).attr("index");
		left = $(this).attr("left");
		en = $(this).attr("en");
		lastButtonType = "cast";		
		
		tb_show('Upload Cast Image', 'media-upload.php?referer=tnet_cast_page&type=image&TB_iframe=true&post_id=0', false);
        return false;		
	});	
	
	$(".episode_upload_button").click(function()
	{
		index = $(this).attr("index");
		en = $(this).attr("en");
		lastButtonType = "episode";
		
		tb_show('Upload Episode', 'media-upload.php?referer=tnet_episodes_page&type=image&TB_iframe=true&post_id=0', false);
        return false;		
	});

	$(".thumbnial_upload_button").click(function()
	{
		index = $(this).attr("index");		
		lastButtonType = "thumbnail";
		
		tb_show('Upload Thumbnail Image', 'media-upload.php?referer=tnet_cast_page&type=image&TB_iframe=true&post_id=0', false);
        return false;		
	});	
	
	window.send_to_editor = function(html)
	{	
		// The image url returned by the media uploader
		var image_url = $('img', html).attr('src');
		var lang = en == "true" ? "en" : "de";
		var direction = left == "true" ? "left" : "right";
		var buttonState = up == "true" ? "up" : "down";
		
		switch(lastButtonType)
		{
			case "social":			
				
				$('#social_button_'+buttonState+'_url'+index).val(image_url);
				$('#'+buttonState+'_image'+index).attr("src", image_url);				
				
				break;
				
			case "mainImage":
			
				$('#main_image_url'+index).val(image_url);				
				$('#main_image'+index).css('background-image', 'url(' + image_url + ')' );
			
			break;
			
			case "blogEmotion":
			
				$('#blog_emotion_url'+index).val(image_url);				
				$('#blog_emotion_image'+index).css('background-image', 'url(' + image_url + ')' );
			
			break;
			
			case "cast":			
			
				$('#cast_'+direction+'_url_'+lang+index).val(image_url);					
				$('#cast_'+direction+'_image_'+lang+index).css('background-image', 'url(' + image_url + ')' );	
			
				break;

			case "episode":
			
				$('#episode_'+lang+'_url'+index).val(image_url);
				$('#episode_'+lang+index).css('background-image', 'url(' + image_url + ')' );				
			
				break;
				
			case "thumbnail":
		
				$('#thumbnail_url'+index).val(image_url);					
				$('#episode_thumbnail'+index).css('background-image', 'url(' + image_url + ')' );
			
				break;
		}
		
		tb_remove();
	}	
});