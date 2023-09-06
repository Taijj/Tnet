<?php
	// This is needed for Wordpress to detect custom templates
	/* Template Name: Comic */
?>

<!DOCTYPE html>

	<?php require(get_template_directory() . '/inc/common/meta.php'); ?>

	<body <?php body_class(); ?>>

		<?php require(get_template_directory() . '/inc/headers/header.php'); ?>

		<div class="page-wrapper">
			<div class="page-content" role="main">

				<?php require(get_template_directory() . '/inc/common/nav-menu.php'); ?>

				<div id="comic-loader" class="nearest-neighbor"></div>
				<div id="comic-page-content" class="content-area">

					<?php
						$options = get_option('tnet_episodes');
						$episode_index = 0;
						$episode_count = $options['count'];

						$params = $_GET;
						if( isset($params['episode']) ) $episode_index = tnet_fit_into_range( $params['episode'], 1, $episode_count )-1;

						$episode_title = $options['titles'][tnet_get_language()][$episode_index];
						$episode_index_html = str_pad($episode_index+1, 3, "0", STR_PAD_LEFT);

						$backwards_enabled = $episode_index > 0;
						$forwards_enabled = $episode_index < $options['count']-1;
					?>

					<div id="episode-container">
						<div id="episode" class="box-shadow">
							<?php
								if( $options['count'] != 0 )
								{
									if($options['types'][$episode_index] == 'image')
									{
										$episode_image_html = '<img id="episode-content" src="'. esc_url( $options['urls'][tnet_get_language()][$episode_index]). '" title="'. esc_attr( $options['alts'][tnet_get_language()][$episode_index]) .'" />';
										$next_episode_link = tnet_get_next_episode($episode_index, $episode_count, 2);

										if($episode_index < $episode_count-1)
										{
											echo '<a id="episode-image-link" href="'.$next_episode_link.'">';
											echo $episode_image_html;
											echo '</a>';
										}
										else
										{
											echo $episode_image_html;
										}
									}
									else
									{
										echo '<iframe id="episode-content" width="1024" height="370" src="' . esc_url($options['urls'][tnet_get_language()][$episode_index]) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
									}
								}
								else
								{
									tnet_e(COMIC_NO_EPISODES);
								}
							?>
						</div>
					</div>

					<div id="episode-footer">

						<div class="comic-nav nearest-neighbor"
							data-episode-index="<?php esc_attr_e($episode_index); ?>"
							data-episode-count="<?php esc_attr_e($episode_count); ?>">
							<div class="comic-nav-button box-shadow" id="comic-nav-first-disabled"></div>
							<a class="comic-nav-button box-shadow" id="comic-nav-first-enabled"
								href="<?php echo tnet_get_next_episode($episode_index, $episode_count, -9999); ?>"
								title="<?php tnet_attr_e('COMIC_NAV_FIRST'); ?>"></a>

							<div class="comic-nav-button box-shadow" id="comic-nav-previous-disabled"></div>
							<a class="comic-nav-button box-shadow" id="comic-nav-previous-enabled"
								href="<?php echo tnet_get_next_episode($episode_index, $episode_count, 0); ?>"
								title="<?php tnet_attr_e('COMIC_NAV_PREVIOUS'); ?>"></a>

							<div class="comic-nav-button box-shadow" id="comic-nav-next-disabled">
								<div class="flipped"></div>
							</div>
							<a class="comic-nav-button box-shadow" id="comic-nav-next-enabled"
								href="<?php echo tnet_get_next_episode($episode_index, $episode_count, +2); ?>"
								title="<?php tnet_attr_e('COMIC_NAV_NEXT'); ?>">
								<div class="flipped"></div>
							</a>

							<div class="comic-nav-button box-shadow" id="comic-nav-last-disabled">
								<div class="flipped"></div>
							</div>
							<a class="comic-nav-button box-shadow" id="comic-nav-last-enabled"
								href="<?php echo tnet_get_next_episode($episode_index, $episode_count, 9999); ?>"
								title="<?php tnet_attr_e('COMIC_NAV_LAST'); ?>">
								<div class="flipped"></div>
							</a>
						</div>

						<div id="episode-meta">
							<h2 id="episode-count"> <?php esc_html_e($episode_index_html); ?></h2>
							<h2 id="episode-colon">:</h2>
							<h3 id="episode-title" data-title="<?php esc_attr_e($episode_title); ?>"></h3>
						</div>

					</div>
				</div>
			</div>
		</div>

		<?php require(get_template_directory() . '/inc/common/footer.php'); ?>
	</body>

</html>