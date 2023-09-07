<?php
	// This is needed for Wordpress to detect custom templates
	/* Template Name: Portfolio */
?>

<!DOCTYPE html>

	<?php require(get_template_directory() . '/inc/common/meta.php'); ?>

	<body <?php body_class(); ?>>

		<?php require(get_template_directory() . '/inc/headers/header.php'); ?>

		<div class="page-wrapper" id="portfolio-page-wrapper">
			<div class="page-content" role="main">

				<?php include(get_template_directory() . '/inc/common/nav-menu.php'); ?>

				<div class="page-content-wrapper">

					<span id="data-provider" data-lang="<?php echo tnet_get_language(); ?>"></span>

					<div>
						<h1 class="centered-text"><?php tnet_e(PORTFOLIO_TITLE); ?></h1>
						<hr/>
						<p class="centered-text"><?php tnet_e(PORTFOLIO_SUBTITLE); ?><p>                        
                    </div>

                    <span id="scroll-target"></span>
                    <div class="tab-view">                        
						<div class="tab-button" id="private-tab-button"><?php tnet_e(PORTFOLIO_PRIVATE_TAB); ?></div>
						<div class="tab-button" id="professional-tab-button"><?php tnet_e(PORTFOLIO_PROFESSIONAL_TAB); ?></div>
						<div class="tab-button" id="tab-back-button"><?php tnet_e(PORTFOLIO_BACK_TAB); ?></div>
					</div>

					<div id="portfolio-content">
					</div>

					<div class="hidden" id="portfolio-unlock-section">
						<h2 class="portfolio-project-title centered-text"><?php tnet_e(PORTFOLIO_UNLOCK_PROJECT_TITLE); ?></h2>
						<div id="portfolio-unlock-container">
							<h2 class="centered-text"><?php tnet_e(PORTFOLIO_UNLOCK_TITLE); ?></h2>
							<p><?php tnet_e(PORTFOLIO_UNLOCK_DESCRIPTION); ?></p>
							<form id="portfolio-unlock-form">
								<label for="portfolio-unlock"><?php tnet_e(PORTFOLIO_UNLOCK_LABEL); ?></label>
								<input class="box-shadow" type="password" id="portfolio-unlock" placeholder="<?php tnet_e(PORTFOLIO_UNLOCK_PLACEHOLDER); ?>">
								<div class="submit-button box-shadow"><p><?php tnet_e(PORTFOLIO_UNLOCK_SUBMIT); ?></p></div>
							</form>
							<p class ="hidden" id="portfolio-invalid-input"><?php tnet_e(PORTFOLIO_UNLOCK_INVALID); ?><p>
						</div>
					</div>
					<div id="bottom-back-button-container">
						<div class="box-shadow" id="bottom-back-button"><?php tnet_e(PORTFOLIO_BOTTOM_BACK); ?></div>
					</div>
				</div>
			</div>
		</div>

		<?php require(get_template_directory() . '/inc/common/footer.php'); ?>
	</body>
</html>