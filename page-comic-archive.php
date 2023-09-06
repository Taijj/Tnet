<?php
	// This is needed for Wordpress to detect custom templates
	/* Template Name: Comic-Archive */
?>

<!DOCTYPE html>

	<?php require(get_template_directory() . '/inc/common/meta.php'); ?>

	<body <?php body_class(); ?>>

		<?php require(get_template_directory() . '/inc/headers/header.php'); ?>

		<div class="page-wrapper" id="comic-archive-page-wrapper">
			<div class="page-content" role="main">

				<?php include(get_template_directory() . '/inc/common/nav-menu.php'); ?>

				<div id="comic-archive-content">

					<h1><?php tnet_e('COMIC_ARCHIVE_HEADLINE'); ?></h1>
					<hr/>
					<p><?php tnet_e('COMIC_ARCHIVE_SUBTITLE'); ?></p>
					<br/>

					<?php
						$options = get_option('tnet_episodes');

						$entry_html = '';
						$entry_html .='<div class="comic-archive-entry-container">';
						$entry_html .='	<a class="comic-archive-link" href="{0}">';
						$entry_html .='		<div class="comic-archive-entry">';
						$entry_html .='			<img class="comic-archive-thumbnail nearest-neighbor" src="{1}" title="{2}" />';
						$entry_html .='			<p class="comic-archive-number">{3}</p><p class="comic-archive-title">{4}</p>';
						$entry_html .='		</div>';
						$entry_html .='	</a>';
						$entry_html .='</div>';

						for ($i = 0; $i < (int)$options['count']; $i++)
						{
							$alt = '...';
							if($options['types'][$i] == 'image')
							{
								$alt = esc_attr( $options['alts'][tnet_get_language()][$i] );
							}

							$title = esc_html( $options['titles'][tnet_get_language()][$i] );
							$title_length = strlen($title);
							$threshold = 17;
							if($title_length > $threshold)
							{
								$title = substr($title, 0, $threshold) . '...';
							}

							$current = str_replace('{0}', tnet_get_comic_url() . '?episode=' . ($i+1), $entry_html);
							$current = str_replace('{1}', esc_url( $options['thumbnails'][$i] ), $current);
							$current = str_replace('{2}', $alt, $current);
							$current = str_replace('{3}', esc_html( str_pad($i+1, 3, "0", STR_PAD_LEFT) ), $current);
							$current = str_replace('{4}', $title, $current);

							echo $current;
						}
					?>
				</div>

			</div>
		</div>

		<?php require(get_template_directory() . '/inc/common/footer.php'); ?>
	</body>
</html>
