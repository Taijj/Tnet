<?php
	$options = get_option('tnet_main_images');
	$width = $options['width'];
	$height = $options['height'];
	$index = rand(0, count($options['urls'])-1);
?>

<div id="main-header-visuals">
	<div class="header-up-image nearest-neighbor" id="main-header-up-image"></div>
	<div class="header-down-image nearest-neighbor" id="main-header-down-image"></div>
	<div id="main-header-bonus">
		<div class="nearest-neighbor" style="width: <?php esc_html_e($width); ?>px; height: <?php echo esc_html_e($height); ?>px;
			background-image: url(<?php echo esc_url($options['urls'][$index]); ?>);">
		</div>
	</div>
</div>