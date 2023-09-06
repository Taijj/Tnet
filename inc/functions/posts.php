<?php
	
	// Echo post date
	if( !function_exists('tnet_echo_post_date') )
	{
		function tnet_echo_post_date()
		{
			printf('<time class="entry-date" datetime="%1$s" pubdate>%2$s - %3$s</time>' ,
					esc_attr( get_the_date('c') ),
					esc_attr( get_the_date() ),
					esc_attr( get_the_time() ));
		}	
	}		 
	
	// Echo posts paginator
	if ( !function_exists('tnet_echo_posts_paginator') )
	{	
		function tnet_echo_posts_paginator()
		{			
			if(is_home())
			{	
				tnet_echo_blog_navigation(
					get_next_posts_page_link(),
					get_previous_posts_page_link(),
					tnet_has_next_posts_page(),
					tnet_has_previous_posts_page(),
					tnet_pl(BLOG_POSTS_OLDER),
					tnet_pl(BLOG_POSTS_NEWER)
					);
			}
			else if(is_single())
			{
				tnet_echo_blog_navigation(
					tnet_get_next_post_url(),
					tnet_get_previous_post_url(),
					tnet_has_next_post(),
					tnet_has_previous_post(),
					tnet_pl(BLOG_POST_OLDER),
					tnet_pl(BLOG_POST_NEWER)
					);
			}
		}
		
		function tnet_has_next_posts_page() { return get_next_posts_link(); }
		function tnet_has_previous_posts_page() { return get_previous_posts_link(); }
		
		function tnet_has_next_post()
		{
			$post = get_adjacent_post(false, '', true);			
			return $post != '' && $post != null;
		}
		function tnet_has_previous_post()
		{
			$post = get_adjacent_post(false, '', false);
			return $post != '' && $post != null;
		}
		
		function tnet_get_next_post_url()
		{
			$post = get_adjacent_post(false, '', true);
			return get_permalink($post);
		}
		
		function tnet_get_previous_post_url()
		{
			$post = get_adjacent_post(false, '', false);
			return get_permalink($post);
		}
	}
	
	
	
	// Echo Comments paginator
	if ( !function_exists('tnet_echo_comment_paginator') )
	{	
		function tnet_echo_comment_paginator()
		{
			tnet_echo_blog_navigation(
				tnet_get_adjacent_comment_page_url(1),
				tnet_get_adjacent_comment_page_url(-1),
				tnet_get_adjacent_comment_page_url(1) != null,
				tnet_get_adjacent_comment_page_url(-1) != null,
				tnet_pl(BLOG_COMMENTS_OLDER),
				tnet_pl(BLOG_COMMENTS_NEWER)
				);			
		}		
		
		function tnet_get_adjacent_comment_page_url($delta)
		{		
	        $page = get_query_var('cpage');	
	        if( !$page) $page = 1;
	
	        $next_page = intval($page) + $delta;
			$max_page = tnet_get_comment_page_count();	    	
			
	        if($next_page > $max_page || $next_page < 1)
	            return null;
			else
				return esc_url( get_comments_pagenum_link($next_page, $max_page));
		}		
		
		function tnet_get_comment_page_count()
		{
			// Get all top-level comments of this post
			$args = array(
				'parent' => '0',
				'post_id' => get_the_ID(),
				'count' => true);
			$top_level_comment_count = get_comments($args);
			
			// Get comments per page option
			$comments_per_page = get_option('comments_per_page');
			
			// return page count
			return esc_html( ceil($top_level_comment_count/$comments_per_page) );
		}
	}
	
	
	
	// Pagination helper
	function tnet_echo_blog_navigation($next_url, $previous_url, $has_next, $has_previous, $next_tooltip, $previous_tooltip)
	{
		if( !$has_next && !$has_previous )
			return;
		
		echo '<nav role="navigation" class="blog-navigation">';
			
			$nav_link_html ='';
			$nav_link_html .= '<a href="{0}" class="{1}" id="{2}" title="{3}">';
			$nav_link_html .= '	<div></div>';
			$nav_link_html .= '</a>';				
		
			if( $has_previous )
			{
				$nav_link_previous = str_replace('{0}', esc_url($previous_url), $nav_link_html);
				$nav_link_previous = str_replace('{1}', 'blog-nav-link-previous', $nav_link_previous);
				$nav_link_previous = str_replace('{2}', 'blog-nav-previous', $nav_link_previous);
				$nav_link_previous = str_replace('{3}', esc_attr($previous_tooltip), $nav_link_previous);
				echo $nav_link_previous;
			}		
			if( $has_next )
			{
				$nav_link_next = str_replace('{0}', esc_url($next_url), $nav_link_html);
				$nav_link_next = str_replace('{1}', 'blog-nav-link-next', $nav_link_next);
				$nav_link_next = str_replace('{2}', 'blog-nav-next', $nav_link_next);
				$nav_link_next = str_replace('{3}', esc_attr($next_tooltip), $nav_link_next);
				echo $nav_link_next;
			}	
			
		echo '</nav>';	
	}
	
	
	
	// Echo commment
	if ( !function_exists('tnet_echo_comment') ) :
	
		function tnet_echo_comment($comment)
		{
			$GLOBALS['comment'] = $comment;
			
			// Autho link
			$author_url = esc_url( get_comment_author_url( $comment ) );
			$author_name = esc_html( get_comment_author( $comment ) );
			
			if(strlen($author_name) > 28)
				$author_name = substr($author_name, 0, 25). '...';

			$author_link = '';			
			if( empty($author_url) || $author_url == 'http://')
				$author_link = $author_name;
			else
				$author_link = '<a href="' .$author_url. '" rel="external nofollow">' .$author_name. '</a>';
 
			// Time
			$comment_time = sprintf('<time class="comment-date" datetime="%1$s" pubdate>%2$s - %3$s</time>' ,
									esc_attr( get_comment_date('c') ),
									esc_attr( get_comment_date( tnet_pl(BLOG_DATE_FORMAT) )),
									esc_attr( get_comment_time() ));
			
			// Edit link
			$edit_link = '';
			if(	current_user_can( 'edit_comment', $comment->comment_ID) )
				$edit_link = ' | <a id="edit-comment-link" href="' .esc_url(get_edit_comment_link()). '">' .tnet_pl(BLOG_EDIT_COMMENT). '</a>';
			?>			
			
			<div <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">			
				<article id="comment-<?php comment_ID(); ?>" class="comment-article">

					<div class="comment-header" id="comment-header-mobile">
						<?php echo '<p>'.$author_link.'<br/>'.$comment_time.$edit_link.'</p>'; ?>
					</div>
					
					<div class="comment-avatar"><?php echo get_avatar($comment, 45); ?> </div>
					
					<div class="comment-content">
					
						<div class="comment-header" id="comment-header-desktop"><?php echo '<p>'.$author_link.' | '.$comment_time.$edit_link.'</p>'; ?></div>						
						<div class="comment-avatar-hook"><img src="<?php echo get_template_directory_uri()?>/img/CommentBubbleHook.png" /></div>
					
						<?php							
							if( $comment->comment_approved == '0')
							{
								echo '<p class="comment-text">' .tnet_pl(BLOG_COMMENT_MODERATION). '</p>';
							}								
							else
							{
								echo '<p class="comment-text">' .esc_html(get_comment_text()). '</p>';
								
								$post_id = get_the_ID();
								$comment_id = $comment->ID;

								//Hack: comment_reply_link only works in specific way. So some parameters have to be set manual for the reply link to work.
								$max_depth = get_option('thread_comments_depth');
								$default = array(									
									'depth'      => $comment->comment_parent == '0' ? 1 : 2,
									'max_depth'  => $max_depth );
								comment_reply_link($default,$comment_id,$post_id);
							}
						?>					
					</div>
				</article>
<?php		// </div> is missing here because wordpress is adding it automatically in the function that calls this
		}
	endif;
?>