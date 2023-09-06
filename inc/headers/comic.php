<?php
	$cast_options = get_option('tnet_header_cast');
	$cast_width = $cast_options['width'];
	$cast_height = $cast_options['height'];

	$left_cast_index = rand(0, count( $cast_options['left_urls'][tnet_get_language()] )-1);
	$right_cast_index = rand(0, count( $cast_options['right_urls'][tnet_get_language()] )-1);
?>

<div id="comic-header-visuals">
	<div class="cast-image" id="left-cast-image"
		style="width: <?php esc_html_e($cast_width); ?>px; height: <?php echo esc_html_e($cast_height); ?>px;
		background-image: url(<?php echo esc_url($cast_options['left_urls'][tnet_get_language()][$left_cast_index]); ?>);"></div>
	<div id="comic-header-center-section" class="nearest-neighbor">
		<div class="header-up-image" id="comic-header-up-image"></div>
		<div class="header-down-image" id="comic-header-down-image"></div>
	</div>
	<div class="cast-image" id="right-cast-image"
		style="width: <?php esc_html_e($cast_width); ?>px; height: <?php esc_html_e($cast_height); ?>px;
		background-image: url(<?php echo esc_url($cast_options['right_urls'][tnet_get_language()][$right_cast_index]); ?>);"></div>
</div>