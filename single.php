<!DOCTYPE html>

	<?php include(get_template_directory() . '/inc/common/meta.php'); ?>

	<body <?php body_class(); ?>>

		<?php require(get_template_directory() . '/inc/headers/header.php'); ?>

		<div class="page-wrapper" id="single-wrapper">
			<div class="page-content" role="main">

			<?php include(get_template_directory() . '/inc/common/nav-menu.php'); ?>

				<div class="blog-content">
					<?php

						tnet_echo_posts_paginator();

						while ( have_posts() )
						{
							the_post();

							include(get_template_directory() . '/inc/posts/single-content.php');
						}
					?>

					<div class="back-to-top"><p><a href="#top" ><?php tnet_e(SINGLE_TO_TOP); ?></a></p></div>

				</div>

			</div>
		</div>

		<?php require(get_template_directory() . '/inc/common/footer.php') ?>
	</body>
</html>

