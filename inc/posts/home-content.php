


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="post-header">
		<h2 class="post-title"><?php the_title(); ?></h2>
		<div class="post-date"><?php tnet_echo_post_date(); ?></div>
		<hr class="post-hr">
	</header>

	<div class="post-content">

	<div class="post-excerpt-container">

			<?php if(has_post_thumbnail()) : ?>
				<div class="post-excerpt-image">
					<?php echo get_the_post_thumbnail(); ?>
				</div>
			<?php endif; ?>
			<div class="post-excerpt-content">
				<?php
					the_excerpt();
					echo '<p><a href="' .get_permalink(). '">' .esc_html(pll__('BLOG_MORE', 'tnet')). '</a></p>';
				?>
			</div>
		</div>
	</div>

</article>