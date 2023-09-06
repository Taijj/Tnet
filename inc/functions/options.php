<?php
	/* ------------------------------------------------------------------------ *
	* Menu page initialization
	* ------------------------------------------------------------------------ */
	function initialize_tnet_menu_page()
	{	 		
		global $tnet_social_page_id, $tnet_cast_page_id, $tnet_episode_page_id, $tnet_blog_page_id, $tnet_main_page_id;

		$tnet_social_page_id = add_menu_page(
			tnet_pl(ADMIN_TITLE),	// The value used to populate the browser's title bar when the menu page is active
			tnet_pl(ADMIN_MENU),    // The text of the menu in the administrator's sidebar
			'administrator', 		// What roles are able to access the menu
			'tnet_menu_page',   	// The ID used to bind submenu items to this menu 
			'render_tnet_menu' 		// The callback function used to render this menu
		);
		
		$tnet_main_page_id = add_submenu_page(
			'tnet_menu_page',			// parent menu id
			tnet_pl(ADMIN_MAIN_TITLE),	// page title
			tnet_pl(ADMIN_MAIN_MENU),	// sidebar title
			'administrator',			// Capabilities
			'tnet_main_page',			// This menu's id
			'render_tnet_menu'			// Render function
		);
		
		$tnet_blog_page_id = add_submenu_page(
			'tnet_menu_page',		// parent menu id
			tnet_pl(ADMIN_BLOG_TITLE),		// page title
			tnet_pl(ADMIN_BLOG_MENU),		// sidebar title
			'administrator',		// Capabilities
			'tnet_blog_page',		// This menu's id
			'render_tnet_menu'		// Render function
		);
		
		$tnet_cast_page_id = add_submenu_page(
			'tnet_menu_page',		// parent menu id
			tnet_pl(ADMIN_CAST_TITLE),		// page title
			tnet_pl(ADMIN_CAST_MENU),		// sidebar title
			'administrator',		// Capabilities
			'tnet_cast_page',		// This menu's id
			'render_tnet_menu'		// Render function
		);
		
		$tnet_episode_page_id = add_submenu_page(
			'tnet_menu_page',		// parent menu id
			tnet_pl(ADMIN_EPISODES_TITLE),	// page title
			tnet_pl(ADMIN_EPISODES_MENU),	// sidebar title
			'administrator',		// Capabilities
			'tnet_episodes_page',	// This menu's id
			'render_tnet_menu'		// Render function
		);		
	}
	add_action('admin_menu', 'initialize_tnet_menu_page');
	
	
	
	/* ------------------------------------------------------------------------ *
	 * Setting Registration
	 * ------------------------------------------------------------------------ */	  
	function initialize_tnet_settings()
	{	 
		// Check options
		tnet_get_option('tnet_general');
		tnet_get_option('tnet_main_images');
		tnet_get_option('tnet_blog_emotions');
		tnet_get_option('tnet_header_cast');
		tnet_get_option('tnet_episodes');
		
		// Do sections
		do_general_section();
		do_main_images_section();
		do_blog_section();
		do_cast_section();
		do_episodes_section();
		
		// Change Insert button text in upload dialogue
		global $pagenow;
 
		if ('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow )
		{
			add_filter( 'gettext', 'replace_thickbox_text', 1, 3);
		}
	}
	add_action('admin_init', 'initialize_tnet_settings');
	
	
	
	function replace_thickbox_text($translated_text, $text, $domain)
	{
		if ('Insert into Post' == $text)
		{
			$menu_page_referer = strpos(wp_get_referer(), 'tnet_menu_page');
			$main_page_referer = strpos(wp_get_referer(), 'tnet_main_page');
			$cast_page_referer = strpos(wp_get_referer(), 'tnet_cast_page');
			$blog_page_referer = strpos(wp_get_referer(), 'tnet_blog_page');
			$episodes_page_referer = strpos(wp_get_referer(), 'tnet_episodes_page');				
			
			if($menu_page_referer != '' || $cast_page_referer != '' || $episodes_page_referer != ''
				|| $blog_page_referer != '' || $main_page_referer != '')
			{
				return tnet_pl(ADMIN_MEDIA_LIBRARY_USE);
			}
		}
		
		return $translated_text;
	}
	
	
	
	function render_tnet_menu()
	{?>		
		<div class="wrap">
	 			
			<h2><?php tnet_e(ADMIN_OPTIONS); ?></h2>			
	 
			<?php //Make a call to the WordPress function for rendering errors when settings are saved. ?>
			<?php settings_errors(); ?>	
	 			
			<?php //Create the form that will be used to render our options. ?>
			<form method="post" action="options.php" method ="get">
			
				<?php
				global $tnet_social_page_id, $tnet_cast_page_id, $tnet_episode_page_id, $tnet_blog_page_id, $tnet_main_page_id;
				
				if(get_current_screen()-> id == $tnet_social_page_id)
				{
					settings_fields('tnet_general');
					do_settings_sections('tnet_menu_page');
				}
				if(get_current_screen()-> id == $tnet_main_page_id)
				{
					settings_fields('tnet_main_images');
					do_settings_sections('tnet_main_page');
				}				
				if(get_current_screen()-> id == $tnet_blog_page_id)
				{
					settings_fields('tnet_blog_emotions');
					do_settings_sections('tnet_blog_page');
				}				
				if(get_current_screen()-> id == $tnet_cast_page_id)
				{
					settings_fields('tnet_header_cast');
					do_settings_sections('tnet_cast_page');
				}
				if(get_current_screen()-> id == $tnet_episode_page_id)
				{
					settings_fields('tnet_episodes');
					do_settings_sections('tnet_episodes_page');
				}
				?>				
				
				<?php submit_button(); ?>				
			</form>
	 
		</div>
	<?php }
	
	
	
	/* ------------------------------------------------------------------------ *
	 * Social Buttons
	 * ------------------------------------------------------------------------ */	  
	function do_general_section()
	{	
		// Social section
		add_settings_section(
			'tnet_social_section',         		// ID used to identify this section and with which to register options
			tnet_pl(ADMIN_GENERAL),  // Title to be displayed on the administration page
			'render_tnet_social_description', 	// Callback used to render the description of the section
			'tnet_menu_page'     				// Page on which to add this section of options
		);		
		
		// Social count
		add_settings_field( 
			'tnet_social_buttons_count',			// ID used to identify the field throughout the theme
			tnet_pl(ADMIN_SOCIAL_BUTTON_COUNT),					// The label to the left of the option interface element
			'render_tnet_social_buttons_count',		// The name of the function responsible for rendering the option interface
			'tnet_menu_page',    					// The page on which this option will be displayed
			'tnet_social_section'	    			// The name of the section to which this field belongs				
		);	
			
		// Social size
		add_settings_field( 
			'tnet_social_buttons_size',				// ID used to identify the field throughout the theme
			tnet_pl(ADMIN_SOCIAL_BUTTON_IMAGE_SIZE),							// The label to the left of the option interface element
			'render_tnet_social_buttons_size',		// The name of the function responsible for rendering the option interface
			'tnet_menu_page',    					// The page on which this option will be displayed
			'tnet_social_section'	    			// The name of the section to which this field belongs				
		);	
				
		// Social buttons
		$options = get_option('tnet_general');
		
		for ($i = 0; $i < (int)$options['social_buttons']['count']; $i++)
		{			
			add_settings_field( 
				'tnet_social_buttons_count'.$i,				// ID used to identify the field throughout the theme
				tnet_pl(ADMIN_SOCIAL_BUTTON_LABEL).$i,		// The label to the left of the option interface element
				'render_tnet_social_buttons_fields',		// The name of the function responsible for rendering the option interface
				'tnet_menu_page',    						// The page on which this option will be displayed
				'tnet_social_section',     					// The name of the section to which this field belongs
				array($i)
			);
		}
		 
		// Register fields
		register_setting(
			'tnet_general',
			'tnet_general',
			'validate_tnet_general'
		);
	}
	
	
	
	function render_tnet_social_description()
	{
		echo '<p>' . tnet_pl(ADMIN_SOCIAL_BUTTON_DESCRIPTION) . '</p>';
	}	
	
	function render_tnet_social_buttons_count()
	{     
		$options = get_option('tnet_general');
		 
		echo '<input type="text" id="social_buttons_count" name="tnet_general[social_buttons][count]" value="' . $options['social_buttons']['count'] . '" />';
	}
	
	function render_tnet_social_buttons_size()
	{     
		$options = get_option('tnet_general');
		$html = ''; 
		
		$html.= '<input type="text" id="social_buttons_size" name="tnet_general[social_buttons][size]" value="' . $options['social_buttons']['size'] . '" />';
		$html.= '<label for="social_buttons_size">px</label>'; 
		
		echo $html;
	}
	
	function render_tnet_social_buttons_fields($args)
	{     
		$options = get_option('tnet_general');
		$index = $args[0];
		$html = '';
		
		// Label
		$html.= tnet_pl(ADMIN_SOCIAL_BUTTON_GRAPHICS);
		
		// Images
		$html.= '<img id="up_image'.$index.'" src="'.$options['social_buttons']['up_image_urls'][$index].'">';			
		$html.= '<img id="down_image'.$index.'" src="'.$options['social_buttons']['down_image_urls'][$index].'">';			
		
		// Hidden text fields
		$html.= '<input type="hidden" id="social_button_up_url'.$index.'" name="tnet_general[social_buttons][up_image_urls]['.$index.']" value="' . $options['social_buttons']['up_image_urls'][$index] . '" />';
		$html.= '<input type="hidden" id="social_button_down_url'.$index.'" name="tnet_general[social_buttons][down_image_urls]['.$index.']" value="' . $options['social_buttons']['down_image_urls'][$index] . '" />';
		
		// Buttons
		$html.= '<br/>';
		$html.= '<input up="true" index="'.$index.'" id="upload_social_button_up_image'.$index.'" type="button" class="social_image_upload_button" value="' . tnet_pl(ADMIN_SOCIAL_BUTTON_UP_IMAGE) . '" />';
		$html.= '<input up="false" index="'.$index.'" id="upload_social_button_up_image'.$index.'" type="button" class="social_image_upload_button" value="' . tnet_pl(ADMIN_SOCIAL_BUTTON_DOWN_IMAGE) . '" />';				
		
		// Urls en
		$html.= '<br/>';
		$html.= '<label for="social_button_link_en'.$index.'"> ' . tnet_pl(ADMIN_SOCIAL_BUTTON_URL_EN) . '</label>'; 
		$html.= '<input type="text" id="social_button_link_en'.$index.'" name="tnet_general[social_buttons][urls][en]['.$index.']" value="' . $options['social_buttons']['urls']['en'][$index] . '" />';
		
		// Urls de
		$html.= '<br/>';
		$html.= '<label for="social_button_link_de'.$index.'"> ' . tnet_pl(ADMIN_SOCIAL_BUTTON_URL_DE) . '</label>'; 
		$html.= '<input type="text" id="social_button_link_de'.$index.'" name="tnet_general[social_buttons][urls][de]['.$index.']" value="' . $options['social_buttons']['urls']['de'][$index] . '" />';
		
		// Descriptions
		$html.= '<br/>';
		$html.= tnet_pl(ADMIN_SOCIAL_BUTTON_DESCRIPTION_EN);
		$html.= '<input type="text" id="social_button_description_en'.$index.'" name="tnet_general[social_buttons][descriptions][en]['.$index.']" size="100" value="' . $options['social_buttons']['descriptions']['en'][$index] . '" />';
		$html.= '<br/>';
		$html.= tnet_pl(ADMIN_SOCIAL_BUTTON_DESCRIPTION_DE);
		$html.= '<input type="text" id="social_button_description_de'.$index.'" name="tnet_general[social_buttons][descriptions][de]['.$index.']" size="100" value="' . $options['social_buttons']['descriptions']['de'][$index] . '" />';
		
		echo $html;
	}
	
	
	
	function validate_tnet_general($input)
	{
		// Output
		$output = tnet_get_option('tnet_general');

		// Social numeric
		$count = $input['social_buttons']['count'];
		$size = $input['social_buttons']['size'];
		
		if( tnet_is_int($count) ) $output['social_buttons']['count'] = tnet_fit_into_range($count, 0, 10);		
		if( tnet_is_int($size) ) $output['social_buttons']['size'] = tnet_fit_into_range($size, 0, 500);
		
		// Social texts
		for ($i = 0; $i < $count; $i++)
		{
			$index = strval($i);
		
			$output['social_buttons']['up_image_urls'][$index] = tnet_check_image($input['social_buttons']['up_image_urls'][$index]);
			$output['social_buttons']['down_image_urls'][$index] = tnet_check_image($input['social_buttons']['down_image_urls'][$index]);
			$output['social_buttons']['urls']['en'][$index] = esc_url($input['social_buttons']['urls']['en'][$index]);
			$output['social_buttons']['urls']['de'][$index] = esc_url($input['social_buttons']['urls']['de'][$index]);
			$output['social_buttons']['descriptions']['en'][$index] = esc_html($input['social_buttons']['descriptions']['en'][$index]);
			$output['social_buttons']['descriptions']['de'][$index] = esc_html($input['social_buttons']['descriptions']['de'][$index]);
		}
		
		// Do the unclear wordpress filter vodoo!
		return apply_filters('validate_tnet_general', $output, $input);
	}
	
	
	
	/* ------------------------------------------------------------------------ *
	 * Main Images
	 * ------------------------------------------------------------------------ */
	function do_main_images_section()
	{	
		// Register section
		add_settings_section(
			'tnet_main_images_section',         	// ID used to identify this section and with which to register options
			tnet_pl(ADMIN_MAIN_IMAGES),				// Title to be displayed on the administration page
			'render_tnet_main_images_description', 	// Callback used to render the description of the section
			'tnet_main_page' 		    			// Page on which to add this section of options
		);
		
		// Add count input field
		add_settings_field(
			'tnet_main_images_count',
			tnet_pl(ADMIN_MAIN_IMAGES_COUNT),
			'render_tnet_main_images_count',
			'tnet_main_page',
			'tnet_main_images_section'
		);
		
		// Add width and height
		add_settings_field(
			'tnet_main_images_size',
			tnet_pl(ADMIN_MAIN_IMAGES_SIZE),
			'render_tnet_main_images_size',
			'tnet_main_page',
			'tnet_main_images_section'
		);
		
		// Add images
		$options = get_option('tnet_main_images');
		
		for ($i = 0; $i < (int)$options['count']; $i++)
		{			
			add_settings_field( 
				'tnet_main_image'.$i,					// ID used to identify the field throughout the theme
				'#'.$i,									// The label to the left of the option interface element
				'render_tnet_main_images',				// The name of the function responsible for rendering the option interfacetnet
				'tnet_main_page',    					// The page on which this option will be displayed
				'tnet_main_images_section',				// The name of the section to which this field belongs			
				array($i)
			);
		}
		
		// Register fields
		register_setting(
			'tnet_main_images',
			'tnet_main_images',
			'validate_tnet_main_images'
		);
	}	

	
	function render_tnet_main_images_description()
	{
		echo '<p>' . tnet_pl(ADMIN_MAIN_IMAGES_DESCRIPTION) . '</p>';
	}
	
	function render_tnet_main_images_count()
	{     
		$options = get_option('tnet_main_images');
		 
		echo '<input type="text" id="main_images_count" name="tnet_main_images[count]" value="' . $options['count'] . '" />';
	}
	
	function render_tnet_main_images_size()
	{
		$options = get_option('tnet_main_images');
		$html = '';
		
		$html .= tnet_pl(ADMIN_MAIN_IMAGES_WIDTH);
		$html .= '<input type="text" id="main_images_widht" name="tnet_main_images[width]" value="' . $options['width'] . '" />';
		
		$html .= tnet_pl(ADMIN_MAIN_IMAGES_HEIGHT);
		$html .= '<input type="text" id="main_images_height" name="tnet_main_images[height]" value="' . $options['height'] . '" />';
		
		echo $html;
	}
	
	function render_tnet_main_images($args)
	{
		$options = get_option('tnet_main_images');
		$index = $args[0];
		$html = '';
		
		// Images
		$html.= '<input type="hidden" id="main_image_url'.$index.'" name="tnet_main_images[urls]['.$index.']" value="' . $options['urls'][$index] . '" />';
		$html.= '<input index="'.$index.'" id="upload_main_image'.$index.'" type="button" class="main_header_image_upload_button" value="' . tnet_pl(ADMIN_MAIN_IMAGE_ASSIGN) . '" />';
		$html.= '<div id="main_image'.$index.'" style="width:100px; height:50px; background-image: url('.$options['urls'][$index].');
					background-size: contain; display: inline-block; background-repeat: no-repeat;"></div>';
		
		echo $html;
	}
	
	
	
	function validate_tnet_main_images($input)
	{
		// Output		
		$output = tnet_get_option('tnet_main_images');
		
		// Count
		$count = $input['count'];
		$width = $input['width'];
		$height = $input['height'];
		
		if( tnet_is_int($count) ) $output['count'] = tnet_fit_into_range($count, 0, 50);
		if( tnet_is_int($width) ) $output['width'] = tnet_fit_into_range($width, 0, 1000);
		if( tnet_is_int($height) ) $output['height'] = tnet_fit_into_range($height, 0, 1000);
		
		// Text inputs		
		for ($i = 0; $i < $count; $i++)
		{
			$index = strval($i);
		
			$output['urls'][$index] = tnet_check_image($input['urls'][$index]);			
		}
		
		// Do the unclear wordpress filter vodoo!
		return apply_filters('validate_tnet_main_images', $output, $input);		
	}
 
 
 
	/* ------------------------------------------------------------------------ *
	 * Blog Emotions
	 * ------------------------------------------------------------------------ */
	function do_blog_section()
	{	
		// Register section
		add_settings_section(
			'tnet_blog_emotions_section',         	// ID used to identify this section and with which to register options
			tnet_pl(ADMIN_BLOG_EMOTIONS),			// Title to be displayed on the administration page
			'render_tnet_blog_emotions_description',// Callback used to render the description of the section
			'tnet_blog_page'     					// Page on which to add this section of options
		);
		
		// Add count input field
		add_settings_field(
			'tnet_blog_emotions_count',
			tnet_pl(ADMIN_BLOG_EMITONS_COUNT),
			'render_tnet_blog_emotions_count',
			'tnet_blog_page',
			'tnet_blog_emotions_section'
		);
		
		// Add width and height
		add_settings_field(
			'tnet_blog_emotions_size',
			tnet_pl(ADMIN_BLOG_EMOTIONS_SIZE),
			'render_tnet_blog_emotions_size',
			'tnet_blog_page',
			'tnet_blog_emotions_section'
		);
		
		// Add images
		$options = get_option('tnet_blog_emotions');
		
		for ($i = 0; $i < (int)$options['count']; $i++)
		{			
			add_settings_field( 
				'tnet_blog_emotion_image'.$i,		// ID used to identify the field throughout the theme
				'#'.$i,								// The label to the left of the option interface element
				'render_tnet_blog_emotions_images',	// The name of the function responsible for rendering the option interfacetnet
				'tnet_blog_page',    				// The page on which this option will be displayed
				'tnet_blog_emotions_section',     	// The name of the section to which this field belongs			
				array($i)
			);
		}
		
		// Register fields
		register_setting(
			'tnet_blog_emotions',
			'tnet_blog_emotions',
			'validate_tnet_blog_emotions'
		);
	}	

	
	function render_tnet_blog_emotions_description()
	{
		echo '<p>' . tnet_pl(ADMIN_BLOG_EMOTIONS_DESCRIPTION) . '</p>';
	}
	
	function render_tnet_blog_emotions_count()
	{     
		$options = get_option('tnet_blog_emotions');
		 
		echo '<input type="text" id="blog_emotions_count" name="tnet_blog_emotions[count]" value="' . $options['count'] . '" />';
	}
	
	function render_tnet_blog_emotions_size()
	{
		$options = get_option('tnet_blog_emotions');
		$html = '';
		
		$html .= tnet_pl(ADMIN_BLOG_EMOTIONS_WIDTH);
		$html .= '<input type="text" id="blog_emotions_widht" name="tnet_blog_emotions[width]" value="' . $options['width'] . '" />';
		
		$html .= tnet_pl(ADMIN_BLOG_EMOTIONS_HEIGHT);
		$html .= '<input type="text" id="blog_emotions_height" name="tnet_blog_emotions[height]" value="' . $options['height'] . '" />';
		
		echo $html;
	}
	
	function render_tnet_blog_emotions_images($args)
	{
		$options = get_option('tnet_blog_emotions');
		$index = $args[0];
		$html = '';
		
		// Images
		$html.= '<input type="hidden" id="blog_emotion_url'.$index.'" name="tnet_blog_emotions[urls]['.$index.']" value="' . $options['urls'][$index] . '" />';
		$html.= '<input index="'.$index.'" id="upload_blog_emotion_image'.$index.'" type="button" class="blog_emotion_image_upload_button" value="' . tnet_pl(ADMIN_BLOG_EMOTIONS_ASSIGN) . '" />';
		$html.= '<div id="blog_emotion_image'.$index.'" style="width:100px; height:50px; background-image: url('.$options['urls'][$index].');
					background-size: contain; display: inline-block; background-repeat: no-repeat;"></div>';
		
		echo $html;
	}
	
	
	
	function validate_tnet_blog_emotions($input)
	{
		// Output		
		$output = tnet_get_option('tnet_blog_emotions');
		
		// Count
		$count = $input['count'];
		$width = $input['width'];
		$height = $input['height'];
		
		if( tnet_is_int($count) ) $output['count'] = tnet_fit_into_range($count, 0, 50);
		if( tnet_is_int($width) ) $output['width'] = tnet_fit_into_range($width, 0, 1000);
		if( tnet_is_int($height) ) $output['height'] = tnet_fit_into_range($height, 0, 1000);
		
		// Text inputs		
		for ($i = 0; $i < $count; $i++)
		{
			$index = strval($i);
		
			$output['urls'][$index] = tnet_check_image($input['urls'][$index]);			
		}
		
		// Do the unclear wordpress filter vodoo!
		return apply_filters('validate_tnet_blog_emotions', $output, $input);		
	}
 
 
	/* ------------------------------------------------------------------------ *
	 * Cast Images
	 * ------------------------------------------------------------------------ */
	function do_cast_section()
	{	
		// Register section
		add_settings_section(
			'tnet_cast_section',         	// ID used to identify this section and with which to register options
			tnet_pl(ADMIN_CAST),        	// Title to be displayed on the administration page
			'render_tnet_cast_description', // Callback used to render the description of the section
			'tnet_cast_page'     			// Page on which to add this section of options
		);
		
		// Add count input field
		add_settings_field(
			'tnet_cast_count',
			tnet_pl(ADMIN_CAST_COUNT),
			'render_tnet_cast_count',
			'tnet_cast_page',
			'tnet_cast_section'
		);
		
		// Add width and height
		add_settings_field(
			'tnet_cast_size',
			tnet_pl(ADMIN_CAST_SIZE),
			'render_tnet_cast_size',
			'tnet_cast_page',
			'tnet_cast_section'
		);
		
		// Add left and right images
		$options = get_option('tnet_header_cast');
		
		for ($i = 0; $i < (int)$options['count']; $i++)
		{			
			add_settings_field( 
				'tnet_cast_images'.$i,		// ID used to identify the field throughout the theme
				'#'.$i,						// The label to the left of the option interface element
				'render_tnet_cast_images',	// The name of the function responsible for rendering the option interface
				'tnet_cast_page',    		// The page on which this option will be displayed
				'tnet_cast_section',     	// The name of the section to which this field belongs			
				array($i)
			);
		}
		
		// Register fields
		register_setting(
			'tnet_header_cast',
			'tnet_header_cast',
			'validate_tnet_header_cast'
		);
	}	

	
	function render_tnet_cast_description()
	{
		echo '<p>' . tnet_pl(ADMIN_CAST_DESCRIPTION) . '</p>';
	}
	
	function render_tnet_cast_count()
	{     
		$options = get_option('tnet_header_cast');
		 
		echo '<input type="text" id="cast_count" name="tnet_header_cast[count]" value="' . $options['count'] . '" />';
	}
	
	function render_tnet_cast_size()
	{
		$options = get_option('tnet_header_cast');
		$html = '';
		
		$html .= tnet_pl(ADMIN_CAST_WIDTH);
		$html .= '<input type="text" id="cast_widht" name="tnet_header_cast[width]" value="' . $options['width'] . '" />';
		
		$html .= tnet_pl(ADMIN_CAST_HEIGHT);
		$html .= '<input type="text" id="cast_height" name="tnet_header_cast[height]" value="' . $options['height'] . '" />';
		
		echo $html;
	}
	
	function render_tnet_cast_images($args)
	{
		$options = get_option('tnet_header_cast');
		$index = $args[0];
		$html = '';
		
		$en = tnet_pl(ADMIN_CAST_EN);
		$de = tnet_pl(ADMIN_CAST_DE);
		
		// Left
		$html.= tnet_pl(ADMIN_CAST_LEFT);
		
		// en
		$html.= '<input type="hidden" id="cast_left_url_en'.$index.'" name="tnet_header_cast[left_urls][en]['.$index.']" value="' . $options['left_urls']['en'][$index] . '" />';
		$html.= '<input left="true" en="true" index="'.$index.'" id="upload_cast_left_image_en'.$index.'" type="button" class="cast_image_upload_button" value="' .$en. '" />';		
		$html.= '<div id="cast_left_image_en'.$index.'" style="width:100px; height:50px; background-image: url('.$options['left_urls']['en'][$index].');
					background-size: contain; display: inline-block; background-repeat: no-repeat;"></div>';
		
		// de
		$html.= '<input type="hidden" id="cast_left_url_de'.$index.'" name="tnet_header_cast[left_urls][de]['.$index.']" value="' . $options['left_urls']['de'][$index] . '" />';
		$html.= '<input left="true" en="false" index="'.$index.'" id="upload_cast_left_image_de'.$index.'" type="button" class="cast_image_upload_button" value="' .$de. '" />';		
		$html.= '<div id="cast_left_image_de'.$index.'" style="width:100px; height:50px; background-image: url('.$options['left_urls']['de'][$index].');
					background-size: contain; display: inline-block; background-repeat: no-repeat;"></div>';
		
		// Right 
		$html.= tnet_pl(ADMIN_CAST_RIGHT);
		
		// en
		$html.= '<input type="hidden" id="cast_right_url_en'.$index.'" name="tnet_header_cast[right_urls][en]['.$index.']" value="' . $options['right_urls']['en'][$index] . '" />';
		$html.= '<input left="false" en="true" index="'.$index.'" id="upload_cast_right_image'.$index.'" type="button" class="cast_image_upload_button" value="' .$en. '" />';
		$html.= '<div id="cast_right_image_en'.$index.'" style="width:100px; height:50px; background-image: url('.$options['right_urls']['en'][$index].');
					background-size: contain; display: inline-block; background-repeat: no-repeat;"></div>';
					
		// de
		$html.= '<input type="hidden" id="cast_right_url_de'.$index.'" name="tnet_header_cast[right_urls][de]['.$index.']" value="' . $options['right_urls']['de'][$index] . '" />';
		$html.= '<input left="false" en="false" index="'.$index.'" id="upload_cast_right_image'.$index.'" type="button" class="cast_image_upload_button" value="' .$de. '" />';
		$html.= '<div id="cast_right_image_de'.$index.'" style="width:100px; height:50px; background-image: url('.$options['right_urls']['de'][$index].');
					background-size: contain; display: inline-block; background-repeat: no-repeat;"></div>';
		
		echo $html;
	}
	
	
	
	function validate_tnet_header_cast($input)
	{
		// Output
		$output = tnet_get_option('tnet_header_cast');

		// Count
		$count = $input['count'];
		$width = $input['width'];
		$height = $input['height'];
		
		if( tnet_is_int($count) ) $output['count'] = tnet_fit_into_range($count, 0, 50);
		if( tnet_is_int($width) ) $output['width'] = tnet_fit_into_range($width, 0, 1000);
		if( tnet_is_int($height) ) $output['height'] = tnet_fit_into_range($height, 0, 1000);	
		
		// Text inputs		
		for ($i = 0; $i < $count; $i++)
		{
			$index = strval($i);
		
			$output['left_urls']['en'][$index] =  tnet_check_image($input['left_urls']['en'][$index]);
			$output['right_urls']['en'][$index] = tnet_check_image($input['right_urls']['en'][$index]);
			$output['left_urls']['de'][$index] = tnet_check_image($input['left_urls']['de'][$index]);
			$output['right_urls']['de'][$index] = tnet_check_image($input['right_urls']['de'][$index]);
		}
		
		// Do the unclear wordpress filter vodoo!
		return apply_filters('validate_tnet_header_cast', $output, $input);		
	}
 
 
 
	/* ------------------------------------------------------------------------ *
	 * Episodes
	 * ------------------------------------------------------------------------ */
	function do_episodes_section()
	{	
		// Register section
		add_settings_section(
			'tnet_episodes_section',         		// ID used to identify this section and with which to register options
			tnet_pl(ADMIN_EPISODES),        		// Title to be displayed on the administration page
			'render_tnet_episodes_description',   	// Callback used to render the description of the section
			'tnet_episodes_page'     				// Page on which to add this section of options
		);		
		
		// Add count input field
		add_settings_field(
			'tnet_episodes_count',
			tnet_pl(ADMIN_EPISODES_COUNT),
			'render_tnet_episodes_count',
			'tnet_episodes_page',
			'tnet_episodes_section'
		);
		
		// Add left and right images
		$options = get_option('tnet_episodes');
		
		for ($i = 0; $i < (int)$options['count']; $i++)
		{			
			add_settings_field(
				'tnet_episode'.$i,
				'#'.($i+1),
				'render_tnet_episodes',
				'tnet_episodes_page',
				'tnet_episodes_section',
				array($i)
				);
		}
		
		// Register fields
		register_setting(
			'tnet_episodes',
			'tnet_episodes',
			'validate_tnet_episodes'
		);
	}
 
 
 
	function render_tnet_episodes_description()
	{
		echo '<p>' . tnet_pl(ADMIN_EPISODES_DESCRIPTION) . '</p>';
	}
	
	function render_tnet_episodes_count()
	{     
		$options = get_option('tnet_episodes');
		 
		echo '<input type="text" id="episodes_count" name="tnet_episodes[count]" value="' . $options['count'] . '" />';
	}
	
	function render_tnet_episodes($args)
	{
		$options = get_option('tnet_episodes');
		$index = $args[0];
		$html = '';
		
		$episdoe_additional_style = 'background-size: contain; display: inline-block; background-repeat: no-repeat; margin: 2px 5px;';
		
		// Titles
		$html.= tnet_pl(ADMIN_EPISODES_TITLE_EN);
		$html.= '<input type="text" id="episode_title_en'.$index.'" name="tnet_episodes[titles][en]['.$index.']" value="' . $options['titles']['en'][$index] . '" />';
		$html.= tnet_pl(ADMIN_EPISODES_TITLE_DE);
		$html.= '<input type="text" id="episode_title_de'.$index.'" name="tnet_episodes[titles][de]['.$index.']" value="' . $options['titles']['de'][$index] . '" />';		
		$html.= '<br/>';
		
		// Episode content
		if($options['types'][$index] == "image")
		{
			// urls
			$html.= '<input type="hidden" id="episode_en_url'.$index.'" name="tnet_episodes[urls][en]['.$index.']" value="' . $options['urls']['en'][$index] . '" />';
			$html.= '<input type="hidden" id="episode_de_url'.$index.'" name="tnet_episodes[urls][de]['.$index.']" value="' . $options['urls']['de'][$index] . '" />';
			
			// images			
			$html.= '<div id="episode_en'.$index.'" style="width:128px; height:47px; background-image: url('.$options['urls']['en'][$index].'); ' . $episdoe_additional_style . '"></div>';						
			$html.= '<div id="episode_de'.$index.'" style="width:128px; height:47px; background-image: url('.$options['urls']['de'][$index].'); ' . $episdoe_additional_style . '"></div>';						
			$html.= '<br/>';
			
			// buttons
			$html.= '<input en="true" index="'.$index.'" id="upload_episode_en'.$index.'" type="button" class="episode_upload_button" value="' . tnet_pl(ADMIN_EPISODES_EN) . '" />';
			$html.= '<input en="false" index="'.$index.'" id="upload_episode_de'.$index.'" type="button" class="episode_upload_button" value="' . tnet_pl(ADMIN_EPISODES_DE) . '" />';
			$html.= '<br/>';
			
			// alts
			$html.= tnet_pl(ADMIN_EPISODES_ALT_EN);
			$html.= '<input type="text" id="episode_alt_en'.$index.'" name="tnet_episodes[alts][en]['.$index.']" value="' . $options['alts']['en'][$index] . '" />';
			$html.= tnet_pl(ADMIN_EPISODES_ALT_DE);
			$html.= '<input type="text" id="episode_alt_de'.$index.'" name="tnet_episodes[alts][de]['.$index.']" value="' . $options['alts']['de'][$index] . '" />';
			$html.= '<br/>';
		}
		else
		{
			$html.= tnet_pl(ADMIN_EPISODES_VIDEO_URL_EN);
			$html.= '<input type="text" id="episode_en_url" name="tnet_episodes[urls][en]['.$index.']" value="' . $options['urls']['en'][$index] . '" />';
			$html.= tnet_pl(ADMIN_EPISODES_VIDEO_URL_DE);
			$html.= '<input type="text" id="episode_de_url" name="tnet_episodes[urls][de]['.$index.']" value="' . $options['urls']['de'][$index] . '" />';
			$html.= '<br/>';
		}
		
		// Types
		$html.= tnet_pl(ADMIN_EPISODES_TYPE);
		$html .= '<select id="tnet_episode_type'.$index.'" name="tnet_episodes[types]['.$index.']">';
			$html .= '<option value="default">'.tnet_pl(ADMIN_EPISODES_SELECT_TYPE).'</option>';
			$html .= '<option value="image"' . selected( $options['types'][$index], 'image', false) . '>'.tnet_pl(ADMIN_EPISODES_TYPE_IMAGE).'</option>';
			$html .= '<option value="video"' . selected( $options['types'][$index], 'video', false) . '>'.tnet_pl(ADMIN_EPISODES_TYPE_VIDEO).'</option>';
		$html .= '</select>';
		
		// Thumbnails		
		$html.= '<input type="hidden" id="thumbnail_url'.$index.'" name="tnet_episodes[thumbnails]['.$index.']" value="' . $options['thumbnails'][$index] . '" />';		
		$html.= '<input index="'.$index.'" id="upload_thumbnail'.$index.'" type="button" class="thumbnial_upload_button" value="' . tnet_pl(ADMIN_EPISODES_THUMBNAIL) . '" />';
		$html.= '<div id="episode_thumbnail'.$index.'" style="width:40px; height:20px; background-image: url('.$options['thumbnails'][$index].');
					background-size: contain; display: inline-block; background-repeat: no-repeat;"></div>';			
		
		echo $html;
	}
	
	
	
	function validate_tnet_episodes($input)
	{
		// Output
		$output = tnet_get_option('tnet_episodes');

		// Count
		$count = $input['count'];
		
		if( tnet_is_int($count) ) $output['count'] = tnet_fit_into_range($count, 0, 999);
		
		// Iteration
		for ($i = 0; $i < $count; $i++)
		{
			$index = strval($i);
		
			if( isset($input['titles']['en'][$index]) ) { $output['titles']['en'][$index] = strip_tags( stripslashes( $input['titles']['en'][$index] ) ); }
			if( isset($input['titles']['de'][$index]) ) { $output['titles']['de'][$index] = strip_tags( stripslashes( $input['titles']['de'][$index] ) ); }
			if( isset($input['alts']['en'][$index]) ) { $output['alts']['en'][$index] = strip_tags( stripslashes( $input['alts']['en'][$index] ) ); }
			if( isset($input['alts']['de'][$index]) ) { $output['alts']['de'][$index] = strip_tags( stripslashes( $input['alts']['de'][$index] ) ); }
			
			if( isset($input['types'][$index]) ) { $output['types'][$index] = $input['types'][$index]; }
			
			$output['urls']['en'][$index] = tnet_check_image( $input['urls']['en'][$index] );
			$output['urls']['de'][$index] = tnet_check_image( $input['urls']['de'][$index] );
			$output['thumbnails'][$index] = tnet_check_image( $input['thumbnails'][$index] );
		}
		
		// Do the unclear wordpress filter vodoo!
		return apply_filters('validate_tnet_episodes', $output, $input);		
	}
	
	
	
	/* ------------------------------------------------------------------------ *
	 * Misc
	 * ------------------------------------------------------------------------ */	
	function tnet_options_enqueue_scripts()
	{
		global $tnet_social_page_id, $tnet_cast_page_id, $tnet_episode_page_id, $tnet_blog_page_id, $tnet_main_page_id;
	
		wp_register_script('tnet_options_image_upload', get_template_directory_uri().'/js/options-image-upload.js', array('jquery','media-upload','thickbox'));
 
		if($tnet_social_page_id == get_current_screen() -> id || 
			$tnet_cast_page_id == get_current_screen() -> id ||	
			$tnet_episode_page_id == get_current_screen() -> id ||
			$tnet_blog_page_id == get_current_screen() -> id ||
			$tnet_main_page_id == get_current_screen() -> id)
		{
			wp_enqueue_script('jquery');
	 
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
	 
			wp_enqueue_script('media-upload');
			wp_enqueue_script('tnet_options_image_upload'); 
		}		
	}
	add_action('admin_enqueue_scripts', 'tnet_options_enqueue_scripts');	
	
	
	
	function tnet_get_option($option)
	{
		$result = get_option($option);
		
		if($result == false)
		{
			// General
			if($option == 'tnet_general')
			{				
				$result = array(
					'social_buttons' => array(
										'up_image_urls' => array(),
										'down_image_urls' => array(),
										'urls' => array(
														'de' => array(),
														'en' => array()
														),
										'descriptions' => array(
																'de' => array(),
																'en' => array()
																),
										'size' => 0,
										'count' => 0
										));

				add_option('tnet_general', $result);				
			}
			
			// Blog Emotions
			if($option == 'tnet_blog_emotions')
			{
				$result = array(							
							'urls' => array(),
							'width' => 0,
							'height' => 0,
							'count' => 0
							);
		
				add_option('tnet_blog_emotions', $result);
			}
			
			// Header Cast
			if($option == 'tnet_header_cast')
			{
				$result = array(
							'left_urls' => array(
												'en' => array(),
												'de' => array()
												),
							'right_urls' => array(
												'en' => array(),
												'de' => array()
												),
							'width' => 0,
							'height' => 0,
							'count' => 0
							);
		
				add_option('tnet_header_cast', $result);
			}
			
			// Episodes
			if($option == 'tnet_episodes')
			{
				$result = array(								
						'urls' => array( 'en' => array(), 'de' => array() ),
						'titles' => array( 'en' => array(), 'de' => array() ),
						'alts' => array( 'en' => array(), 'de' => array() ),
						'thumbnails' => array(),
						'types' => array(),
						'count' => 0
						);
		
				add_option('tnet_episodes', $result);
			}
		}		
		
		return $result;
	}
	
	
	
	function tnet_check_image($image_url)
	{
		if(	isset($image_url) && tnet_file_exists($image_url) )
			return strip_tags( stripslashes($image_url) );
		else
			return '';	
	}
		
	function tnet_is_int($int)
	{		
		if(	is_numeric($int) )
		{
			if($int != round($int))
				return false;			
			if($int < 0)
				return false;			
			
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	function tnet_file_exists($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		
		// don't download content
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		if(curl_exec($ch)!==FALSE)
			return true;
		else 
			return false;
	}
	
	function tnet_debug($message)
	{
		echo '<script type="text/javascript">alert('.$message.');</script>';
	}
?>