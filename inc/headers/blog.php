<?php
	$options = get_option('tnet_blog_emotions');
	$width = $options['width'];
	$height = $options['height'];
	$index = rand(0, count($options['urls'])-1);
?>

<div id="blog-header-visuals">
	<div id="blog-emotion-image" class="nearest-neighbor"
		style="width: <?php esc_html_e($width); ?>px; height: <?php esc_html_e($height); ?>px;
			background-image: url(<?php echo esc_url( $options['urls'][$index] ); ?>);">
	</div>
	<div id="blog-header-bubble" class="nearest-neighbor">
		<div class="header-up-image" id="blog-header-up-image"></div>
		<div class="header-down-image" id="blog-header-down-image"></div>
	</div>
</div>