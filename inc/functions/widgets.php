<?php

	// Register and load widgets
	function tnet_register_progress_bar_widget()
	{
		register_widget('tnet_progress_bar');
		register_widget('tnet_gallery');
	}
	add_action( 'widgets_init', 'tnet_register_progress_bar_widget' );




	// Progress bar
	class tnet_progress_bar extends WP_Widget
	{
		function __construct()
		{
			// Add Widget scripts
			add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

			parent::__construct(
				'progress_bar', // ID
				tnet_pl(WIDGED_PRGORESS_BAR_NAME),
				array( 'description' => tnet_pl(WIDGET_PROGRESS_BAR_DESCRIPTION) )
			);
		}

		public function enqueue_scripts()
		{
		   wp_enqueue_script('media-upload');
		   wp_enqueue_media();
		   wp_enqueue_script('tnet_widgets_image_upload', get_template_directory_uri() . '/js/widgets-image-upload.js', array('jquery'));
		}



		// Creating widget front-end
		public function widget($args, $input)
		{
			// before and after widget arguments are defined by themes
			echo $args['before_widget'];

			// Widget content
			$instance = $this->sanitize($input);

			$image_url = $instance['image-url'];
			$image_alt = $instance['image-alt'];
			$caption = $instance['caption'];
			$note = $instance['note'];
			$percentage = (int)$instance['percentage'];
			$show_percentage = $instance['show-percentage'];

			?>
				<div class="progress-bar" title="<?php echo esc_attr($image_alt); ?>">
					<?php if($image_url != '') : ?>
						<img class="progress-bar-image nearest-neighbor" src="<?php echo esc_url($image_url); ?>"></img>
					<?php endif; ?>
					<div class="progress-bar-main">
						<div class="progress-bar-fill" style="width:<?php esc_html_e($percentage.'%'); ?>;"></div>
						<?php if($show_percentage == 'on') : ?>
							<p class="progress-bar-percentage"><?php echo $percentage.'%'; ?></p>
						<?php endif; ?>
						<p class="progress-bar-text"><?php esc_html_e($caption); ?></p>
					</div>
				</div>
				<?php if($note != '') : ?>
					<p class="progress-bar-note"><?php esc_html_e($note); ?></p>
				<?php endif; ?>
			<?php

			// End args
			echo $args['after_widget'];
		}

		// Widget Backend
		public function form($input)
		{
			$instance = $this->sanitize($input);

			$image_url = $instance['image-url'];
			$image_alt = $instance['image-alt'];
			$caption = $instance['caption'];
			$note = $instance['note'];
			$percentage = $instance['percentage'];
			$show_percentage = $instance['show-percentage'];			

			// Widget admin form
			?>
				<p>
				  <label for="<?php echo $this->get_field_id( 'image-url' ); ?>"><?php tnet_e(WIDGET_PROGRESS_BAR_IMAGE) ; ?></label>
				  <img id="progress-bar-widget-software-image" src="<?php echo esc_url($image_url); ?>">
				  <input class="widefat" id="<?php echo $this->get_field_id( 'image-url' ); ?>" name="<?php echo $this->get_field_name( 'image-url' ); ?>" type="text" value="<?php echo esc_url( $image_url ); ?>" />
				  <button class="upload-progress-bar-image-button"><?php tnet_e(WIDGET_PROGRESS_BAR_UPLOAD_BUTTON); ?></button>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'image-alt' ); ?>"><?php tnet_e(WIDGET_PROGRESS_BAR_IMAGE_ALT); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'image-alt' ); ?>" name="<?php echo $this->get_field_name( 'image-alt' ); ?>" type="text" value="<?php echo esc_attr( $image_alt ); ?>">
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'caption' ); ?>"><?php tnet_e(WIDGET_PROGRESS_BAR_CAPTION); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'caption' ); ?>" name="<?php echo $this->get_field_name( 'caption' ); ?>" type="text" value="<?php echo esc_attr( $caption ); ?>">
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'note' ); ?>"><?php tnet_e(WIDGET_PROGRESS_BAR_NOTE); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'note' ); ?>" name="<?php echo $this->get_field_name( 'note' ); ?>" type="text" value="<?php echo esc_attr( $note ); ?>">
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'percentage' ); ?>"><?php tnet_e(WIDGET_PROGRESS_BAR_PERCENTAGE); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'percentage' ); ?>" name="<?php echo $this->get_field_name( 'percentage' ); ?>" type="text" value="<?php echo esc_attr( $percentage ); ?>">
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'show-percentage' ); ?>"><?php tnet_e(WIDGET_PROGRESS_BAR_SHOW_PERCENTAGE); ?></label>
					<input class="checkbox" id="<?php echo $this->get_field_id( 'show-percentage' ); ?>" name="<?php echo $this->get_field_name( 'show-percentage' ); ?>"
						type="checkbox" <?php checked( $instance[ 'show-percentage' ], 'on' ); ?> >
				</p>
			<?php
		}

		// Updating widget replacing old instances with new
		public function update( $new_instance, $old_instance )
		{
			return $this->sanitize($new_instance);
		}

		private function sanitize($input)
		{
			$output = array();
			$output['image-url'] = (!empty( $input['image-url'] )) ? $input['image-url'] : '';
			$output['image-alt'] = (!empty( $input['image-alt'] )) ? $input['image-alt'] : '';
			$output['caption'] = (!empty( $input['caption'] )) ? $input['caption'] : '';
			$output['note'] = (!empty( $input['note'] )) ? $input['note'] : '';
			$output['percentage'] = (!empty( $input['percentage'] )) ? $input['percentage'] : '0%';
			$output['show-percentage'] = (!empty( $input['show-percentage'] )) ? $input['show-percentage'] : 'off';
			return $output;
		}
	}



	// Gallery
	class tnet_gallery extends WP_Widget
	{

		function __construct()
		{
			// Add Widget scripts
			add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

			parent::__construct(
				'progress_bar', // ID
				tnet_pl(WIDGED_GALLERY_NAME),
				array( 'description' => tnet_pl(WIDGET_GALLERY_DESCRIPTION) )
			);
		}

		public function enqueue_scripts()
		{
		   wp_enqueue_script('media-upload');
		   wp_enqueue_media();
		   wp_enqueue_script('tnet_widgets_image_upload', get_template_directory_uri() . '/js/widgets-image-upload.js', array('jquery'));
		}



		// Creating widget front-end
		public function widget($args, $input)
		{
			// before and after widget arguments are defined by themes
			echo $args['before_widget'];

			// Widget javascript
			wp_enqueue_script('gallery-widget', get_template_directory_uri() . '/js/gallery-widget.js', array('jquery'), false, false);
			wp_localize_script('gallery-widget', 'ajaxAdmin', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

			// Widget content
			$instance = $this->sanitize($input);
			$image_urls = $instance['image-urls'];
			$title = $instance['title'];

			?>
				<div class="gallery-widget">

					<?php if( !empty($title)) : ?>
						<div class="gallery-widget-title">
							<p><?php esc_html_e($title); ?></p>
						</div>
					<?php endif; ?>

					<div class="gallery-widget-images-container">
						<?php for($i = 0; $i < count($image_urls); $i++) : ?>
							<div class="gallery-widget-image box-shadow"
								data-src="<?php echo esc_url($image_urls[$i]); ?>"
								data-index="<?php echo $i; ?>"
								style="background-image: url('<?php echo esc_url($image_urls[$i]); ?>')">
							</div>
						<?php endfor; ?>
					</div>
				</div>
			<?php
			// End args
			echo $args['after_widget'];
		}

		// Widget Backend
		public function form($input)
		{
			$instance = $this->sanitize($input);
			$title = $instance['title'];
			$image_urls = $instance['image-urls'];

			$input_field_format = '<input type="text" name="' .esc_attr( $this->get_field_name('image-urls') ). '[%1$s]" value="%2$s" class="hidden">';
			$image_format = '<div class="gallery-widget-admin-image-container"><img class="gallery-widget-admin-image" src="%1$s"></img></div>';
			$image_urls_html = array();

			// Assemble html that is already there
			for($i = 0; $i < count($image_urls); $i++)
			{
				$input_field_html = sprintf($input_field_format, $i, esc_attr($image_urls[$i]));
				$image_html = sprintf($image_format, esc_attr($image_urls[$i]));
				$image_urls_html[] = $input_field_html.$image_html;
			}

			?>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php tnet_e(WIDGET_GALLERY_TITLE); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

				<label for="gallery-widget-images"><?php tnet_e(WIDGET_GALLERY_IMAGES); ?></label>
				<div id="gallery-widget-images" data-input-field-format="<?php echo esc_attr($input_field_format); ?>" data-image-format="<?php echo esc_attr($image_format); ?>">
					<?php echo join('<br/>', $image_urls_html); ?>
				</div>
				<button class="upload-gallery-images-button"><?php tnet_e(WIDGET_GALLERY_UPLOAD_BUTTON); ?></button>
			<?php
		}

		// Updating widget replacing old instances with new
		public function update( $new_instance, $old_instance )
		{
			return $this->sanitize($new_instance);
		}

		private function sanitize($input)
		{
			$output = array();
			$output['title'] = ( !empty( $input['title'] )) ? $input['title'] : '';
			$output['image-urls'] = ( !empty( $input['image-urls'] )) ? $input['image-urls'] : array();

			return $output;
		}
	}
?>