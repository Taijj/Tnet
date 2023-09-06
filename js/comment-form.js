jQuery(document).ready(function($)
{	
	// Text area expansion
	var textArea = $('#comment-textarea');
    var hiddenDiv = $(document.createElement('div'));
    var content = null;
	
	hiddenDiv.attr('id', 'comment-textarea-helper');

	$('#respond').append(hiddenDiv);

	textArea.on('keyup change', function ()
	{
		content = $(this).val();

		content = content.replace(/\n/g, '<br/>');
		hiddenDiv.html(content + '<br/>');

		$(this).css('height', hiddenDiv.outerHeight());
	});
});