<?php
	/**
	 * TNET functions and definitions
	 *
	 * @package TNET
	 * @since TNET 1.0
	 */

	if( !function_exists('tnet_setup') ):

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 */

		function tnet_setup()
		{
			require(get_template_directory() . '/inc/functions/posts.php');

			/**
			 * Make theme available for translation
			 * Translations can be filed in the /languages/ directory
			 */
			load_theme_textdomain('tnet', get_template_directory() . '/languages');

			/** Add default posts and comments RSS feed links to head */
			add_theme_support('automatic-feed-links');
			add_theme_support('post-thumbnails'); // Add Thumbnail support for posts

			// Register Nav Menu locations
			register_nav_menu( 'common', 'Common Menu' );
			register_nav_menu( 'comic', 'Comic Menu' );
			register_nav_menu( 'game', 'Game Menu' );
			register_nav_menu( 'error', 'Error Menu' );
		}
	endif;
	add_action( 'after_setup_theme', 'tnet_setup' );



	//REGION Enqueueing
	function tnet_scripts()
	{
		wp_enqueue_style('style', get_stylesheet_uri());

		if( is_singular() && comments_open() && get_option('thread_comments') )
		{
			wp_enqueue_script('comment-reply');
		}

		wp_enqueue_script('nav-menu', get_template_directory_uri() . '/js/nav-menu.js', array('jquery'), false, false);
		wp_enqueue_script('social-buttons', get_template_directory_uri() . '/js/social-buttons.js', array('jquery'), false, false);
		wp_enqueue_script('refresh-styles', get_template_directory_uri() . '/js/refresh-styles.js', array('jquery'), false, false);
		wp_enqueue_script('image-header', get_template_directory_uri() . '/js/image-header.js', array('jquery'), false, false);

		if( tnet_is_comic_page() )
			wp_enqueue_script('comic-page', get_template_directory_uri() . '/js/comic-page.js', array('jquery'), false, false);

		if( tnet_is_blog_or_child() )
			wp_enqueue_script('blog-page', get_template_directory_uri() . '/js/blog-page.js', array('jquery'), false, false);

		if( is_single() )
			wp_enqueue_script('blog-page', get_template_directory_uri() . '/js/comment-form.js', array('jquery'), false, false);

		if( is_front_page() )
			wp_enqueue_script('front-page', get_template_directory_uri() . '/js/front-page.js', array('jquery'), false, false);

		if( tnet_is_page('portfolio') )
		{
			wp_enqueue_script('portfolio-page', get_template_directory_uri() . '/js/portfolio-page.js', array('jquery'), false, false);
			wp_localize_script('portfolio-page', 'ajaxAdmin', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
		}

	}
	add_action( 'wp_enqueue_scripts', 'tnet_scripts' );



	function tnet_enqueue_admin_styles()
	{
		wp_enqueue_style('admin-style', get_template_directory_uri().'/style-admin.css');
	}
	add_action('admin_enqueue_scripts', 'tnet_enqueue_admin_styles');
	add_action('login_enqueue_scripts', 'tnet_enqueue_admin_styles');



	//REGION Extracted functions
	require(get_template_directory() . '/inc/functions/options.php');
	require(get_template_directory() . '/inc/functions/utils.php');	
	require(get_template_directory() . '/inc/functions/feed.php');
	require(get_template_directory() . '/inc/functions/widgets.php');
	require(get_template_directory() . '/inc/functions/cookie-banner.php');
	require(get_template_directory() . '/inc/functions/ajax-targets.php');

	require(get_template_directory() . '/inc/functions/loca.php');
	add_action('init', 'tnet_register_strings');



	//REGION Patches
	//Prevent Wordpress from converting characters, eg. '"'
	add_filter( 'run_wptexturize', '__return_false' );

	//Include private pages in page parent dropdown
	//source: https://www.mightyminnow.com/2014/09/include-privatedraft-pages-in-parent-dropdowns/
	function my_slug_show_all_parents( $args )
	{
		$args['post_status'] = array( 'publish', 'pending', 'draft', 'private' );
		return $args;
	}
	add_filter( 'page_attributes_dropdown_pages_args', 'my_slug_show_all_parents' );
	add_filter( 'quick_edit_dropdown_pages_args', 'my_slug_show_all_parents' );

	// Enable adding of classes for nav menu items with wp_nav_menu
	function add_additional_class_on_li($classes, $item, $args)
	{
		if(isset($args->add_li_class))
		{
			$classes[] = $args->add_li_class;
		}
		return $classes;
	}
	add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

//? > Closing bracket omitted because it fucks up the RSS feed