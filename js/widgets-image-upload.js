

jQuery(document).ready(function ($)
{ 
   $(document).on('click', '.upload-progress-bar-image-button', function (e)
   {
		e.preventDefault();
		var $button = $(this); 
		  
		// Create the media frame.
		var file_frame = wp.media.frames.file_frame = wp.media(
		{
			title: 'Select progress bar image',         
			button: { text: 'Use' },
			multiple: false  // Multiple files allowed
		});
	 
		// When an image is selected, run a callback.
		file_frame.on('select', function () 
		{
			// We set multiple to false so only get one image from the uploader 
			var attachment = file_frame.state().get('selection').first().toJSON();
	 
			$button.siblings('input').val(attachment.url);
			$button.siblings('img').attr('src', attachment.url);
		});
	 
		// Finally, open the modal
		file_frame.open();
   });

   
   
   $(document).on('click', '.upload-gallery-images-button', function (e)
   {
		e.preventDefault();
		var $button = $(this);
		
		// If media frame already exists open it
		if(tnetGalleryFrame)
		{
			tnetGalleryFrame.open();
			return;
		}
		
		// Create the media frame.
		var tnetGalleryFrame = wp.media.frames.file_frame = wp.media(
		{
			title: 'Select images',
			button: { text: 'Use' },
			multiple: true  // Multiple files allowed
		});
		
		tnetGalleryFrame.on('select', function()
		{
			var attachements = tnetGalleryFrame.state().get('selection').map
			( 
                function(attachment)
				{
                    attachment.toJSON();
                    return attachment;
				}
			);			

			var imagesContainer = $('#gallery-widget-images');
			var inputFieldFormat = imagesContainer.data('input-field-format');
			var imageFormat = imagesContainer.data('image-format');
			var imagesHtml = '';
			
			// Clear html already inside the image container
			imagesContainer.empty();
			
			// Loop over attachements and assemble new html
			for(var i = 0; i < attachements.length; i++)
			{
				// Get media attachment details from the frame state				
				var html = inputFieldFormat.replace('%1$s', i);
				html = html.replace('%2$s', attachements[i].attributes.url);
				
				html += imageFormat.replace('%1$s', attachements[i].attributes.url);
				
				imagesHtml += html;
			}
			
			// Put new Html in
			imagesContainer.html(imagesHtml);
		});

		// Finally, open the modal on click
		tnetGalleryFrame.open();		
   });
});