<!DOCTYPE html>

	<?php include(get_template_directory() . '/inc/common/meta.php'); ?>

	<body <?php body_class(); ?>>

		<?php require(get_template_directory() . '/inc/headers/header.php'); ?>

		<div class="page-wrapper" id="blog-wrapper">
			<div class="page-content" id="error-page-container" role="main">

				<?php require(get_template_directory() . '/inc/common/nav-menu.php'); ?>

				<div class="page-content-wrapper">
					<div class="error-page-cells">
						<div>
							<h3>Well, that didn't work!</h3>
							<p>The page you tried to reach doesn't exist.</p>
						</div>
						<div class="error-page-divider">
						</div>
						<div>
							<h3>Das hat nicht geklappt!</h3>
							<p>Die Seite, die Du aufrufen wolltest existiert nicht.</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php require(get_template_directory() . '/inc/common/footer.php') ?>
	</body>
</html>