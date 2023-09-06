

 jQuery(document).ready(function($)
 {
	
	// Hide all comment sections
	$('.post-comments-container').each(function()
	{
		$(this).addClass('hidden');
	});	
	
	// Add toggle event listener
	$('.post-comments-toggle-button').on('click', onToggleComments);
	$('.comments-close-button').on('click', onCloseComments);
	
	// Check if a comment section was opened in the past and reopen if so
	var lastOpenedCommentsPostId = window.sessionStorage.getItem('last-opened-comments-post-id');	
	if(lastOpenedCommentsPostId != null)
		openComments(lastOpenedCommentsPostId);		
	
	function onToggleComments(e)
	{
		e.preventDefault();
		
		// Clear previously stored id 
		sessionStorage.removeItem("last-opened-comments-post-id");
		
		// Get elements
		var commentsSection = $(this).parent().siblings('.post-comments-container');
		var article = $(this).parents('article:first');
		
		// Toggle display
		if( commentsSection.hasClass('hidden') )
		{
			window.sessionStorage.setItem('last-opened-comments-post-id', article.attr('id') );		
			commentsSection.removeClass('hidden');
		}	
		else
		{
			commentsSection.addClass('hidden');
		}			
	}
	
	function onCloseComments()
	{
		// Clear previously stored id 
		sessionStorage.removeItem("last-opened-comments-post-id");
		
		// Toggle display
		var commentsSection = $(this).parents('.post-comments-container:first');
		commentsSection.addClass('hidden');
	}
	
	function openComments(postId)
	{
		// Reopen last opened comments section
		var lastCommentSection = $('#'+postId).find('.post-comments-container');
		
		lastCommentSection.removeClass('hidden');		
	}
});
 
 