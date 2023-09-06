 
 
 
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="post-header">			
		<h2 class="post-title"><?php the_title(); ?></h2>
		<div class="post-date"><?php tnet_echo_post_date(); ?></div>
		<hr class="post-hr">
	</header>  
 
	<div class="post-content"> <?php the_content(); ?> </div>
	
	<div class="post-footer">
		
		<?php //Id = comments for auto jump to comments section. ?>
		<hr class="post-hr" id="comments"> 
		
		<?php
		
			$comments_blocked = !comments_open() && !pings_open();
			$comments_count = get_comments_number();
		
			// Info text if no comments or blocked
			if( $comments_blocked )
				echo '<p class="post-no-comments">'.esc_html(pll__('BLOG_SINGLE_COMMENTS_BLOCKED', 'tnet')).'</a></p>';			
			
			// Comment list
		?>		
		
		<div class="single-post-comments-container">		
			<?php				
				// Comment Form
				$comment_form_fields =  array(
										'author' =>	'<p class="comment-form-author"><label class="comment-form-data-label" for="author">' .esc_html(pll__('BLOG_COMMENT_FORM_AUTHOR', 'tnet' )). '</label>' .
													'<input id="author" class="comment-form-data-field" name="author" type="text" value="' .esc_attr( $commenter['comment_author'] ).
													'" size="30" aria-required="true" required="required" /></p>',
										'url' =>	'<p class="comment-form-url"><label class="comment-form-data-label" for="url">' .esc_html(pll__('BLOG_COMMENT_FORM_WEBSITE', 'tnet' )). '</label>' .
													'<input id="url" class="comment-form-data-field" name="url" type="text" value="' .esc_attr( $commenter['comment_url'] ).
													'" size="30"/></p>');
													
				$comment_text_area_html = '<textarea id="comment-textarea" name="comment" maxlength="500"
											placeholder="' .esc_html(pll__('BLOG_COMMENT_FORM_PLACEHOLDER', 'tnet')) .'"
											aria-required="true" required="required"></textarea>';
				
				$logged_in_as_html = 	'<p id="comment-notes">' .esc_html(pll__('BLOG_COMMENT_FORM_LOGGED_IN_AS', 'tnet')). ' <a class="comment-notes-link" href="' .admin_url('profile.php'). '">' .esc_html($user_identity). '</a>'.
										'<a class="comment-notes-link" id="comment-notes-logout" href="' .wp_logout_url( apply_filters('the_permalink', get_permalink()) ). '">' .esc_html(pll__('BLOG_COMMENT_FORM_LOGOUT', 'tnet')). '</a></p>';
				
				$comments_args = array( 'fields' => 			apply_filters( 'comment_form_default_fields', $comment_form_fields ),
										'comment_field' => 		$comment_text_area_html,
										'logged_in_as' => 		$logged_in_as_html,
										'comment_notes_before' => '',
										'comment_notes_after' => '', 
										'id_form' => 			'comment-form',
										'id_submit' => 			'comment-form-submit-button',
										'title_reply' => 		esc_html(pll__('BLOG_COMMENT_FORM_HEAD', 'tnet')),
										'title_reply_to' =>		esc_html(pll__('BLOG_COMMENT_REPLY_HEAD %s', 'tnet')),
										'title_reply_before' =>	'<h3 id="comment-form-header">',
										'title_reply_after' =>	'</h3>',
										'cancel_reply_link' => esc_html(pll__('BLOG_COMMENT_REPLY_CANCEL', 'tnet')),
										'label_submit' => esc_html(pll__('BLOG_COMMENT_SUBMIT', 'tnet')));
				comment_form($comments_args);				
			?>
			
			<hr class="post-hr"> 
			
			<div class="commentlist">
				<?php					
					tnet_echo_comment_paginator();
				
					$comments = get_comments( array('post_id' => get_the_ID()) );				
					wp_list_comments( array('style' => 'div', 'callback' => 'tnet_echo_comment'), $comments);
					
					tnet_echo_comment_paginator();
				?>
			</div>
		</div>
	</div>
	
</article>