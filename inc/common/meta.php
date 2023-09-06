<?php
/**
 * Extracted meta information that should included in an header.
 *
 * @since TNET 1.0
 */
 ?>
 <head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php
			global $page, $paged;

			wp_title('|', true, 'right');

			// Add the blog description for the home/front page.
			$site_description = get_bloginfo('description', 'display');
			if( $site_description && (is_home() || is_front_page()) )
				echo " | $site_description";

			// Add a page number if necessary:
			if($paged >= 2 || $page >= 2)
				echo ' | ' . sprintf( esc_html(pll__('META_PAGE %s', 'tnet')), max($paged, $page) );
		?>
	</title>
	<meta name="keywords" content="The Plurt, The Box Theory, Comic, Webcomic, Videogames, Games, Pixelart, Pixel Art, Taijj"/>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
</head>