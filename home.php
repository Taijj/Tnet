<!DOCTYPE html>

	<?php include(get_template_directory() . '/inc/common/meta.php'); ?>

	<body <?php body_class(); ?>>

		<?php require(get_template_directory() . '/inc/headers/header.php'); ?>

		<div class="page-wrapper" id="blog-wrapper">
			<div class="blog-container" role="main">

				<?php require(get_template_directory() . '/inc/common/nav-menu.php'); ?>

				<div class="blog-content">
					<?php
						tnet_echo_posts_paginator();

						while ( have_posts() )
						{
							the_post();
							include(get_template_directory() . '/inc/posts/home-content.php');
						}

						tnet_echo_posts_paginator();
					?>
				</div>

			</div>
		</div>

		<?php require(get_template_directory() . '/inc/common/footer.php') ?>
	</body>
</html>