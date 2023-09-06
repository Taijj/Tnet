<!DOCTYPE html>

	<?php require(get_template_directory() . '/inc/common/meta.php'); ?>

	<body <?php body_class(); ?>>

		<?php require(get_template_directory() . '/inc/headers/header.php'); ?>

		<div class="page-wrapper">
			<div class="page-content" role="main">

				<?php include(get_template_directory() . '/inc/common/nav-menu.php'); ?>

				<div class="page-content-wrapper">

					<?php while(have_posts()) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php the_content(); ?>
						</article>
					<?php endwhile; ?>
				</div>

			</div>
		</div>

		<?php require(get_template_directory() . '/inc/common/footer.php'); ?>
	</body>
</html>