
<footer id="footer-main">
	<div id="footer-infos-container">

		<div id="contact-info" class="footer-info">
			<h4><?php tnet_e(FOOTER_CONTACT_HEAD); ?> </h4>
			<p class = "footer-p"><a class="footer-link" href="mailto:<?php esc_html_e( get_option('admin_email') );?>"><?php echo tnet_pl(FOOTER_MAIL). ' ' .get_option('admin_email');?></a></p>
			<p class = "footer-p"><a class="footer-link" href="https://discordapp.com/users/290486871115563009"><?php tnet_e(FOOTER_DISCORD);?></a></p>
			<p class = "footer-p"><a class="footer-link" href="https://discord.gg/kpczujEVw3"><?php tnet_e(FOOTER_DISCORD_SERVER);?></a></p>			
		</div>

		<div id="left-delimiter" class="footer-delimiter"></div>

		<div id="social-info" class="footer-info">
			<h4><?php tnet_e(FOOTER_SOCIAL_HEAD); ?> </h4>

			<div id="social-buttons-container">
				<?php

				// Get options and extract social buttons
				$options = get_option('tnet_general');
				$social_buttons = $options['social_buttons'];

				// Loop over social buttons and set data into divs
				for ($i = 0; $i < (int)$social_buttons['count']; $i++)
				{
					$up_link = esc_url( $social_buttons['up_image_urls'][$i] );
					$down_link = esc_url( $social_buttons['down_image_urls'][$i] );
					$destination = esc_url( $social_buttons['urls'][tnet_get_language()][$i] );
					$title = esc_attr( $social_buttons['descriptions'][tnet_get_language()][$i] );
				?>
					<a class="social-button box-shadow" id="<?php echo esc_attr('social-button'.$i); ?>"
						href="<?php echo $destination; ?>"
						title="<?php echo $title;?>"
						style="width:<?php esc_html_e( $social_buttons['size'] );?>px; height:<?php esc_html_e( $social_buttons['size'] )?>px;">
						<div class="social-up-image nearest-neighbor" style="background-image: url(<?php echo $up_link;?>);"></div>
						<div class="social-down-image nearest-neighbor" style="background-image: url(<?php echo $down_link;?>);"></div>
					</a>
				<?php } ?>

			</div>

		</div>

		<div id="right-delimiter" class="footer-delimiter"></div>

		<div id="legal-info" class="footer-info">
			<h4><?php tnet_e(FOOTER_LEGAL_HEAD); ?> </h4>
			<p class = "footer-p"><a class="footer-link" href="<?php echo tnet_get_legal_url(); ?>"><?php tnet_e(FOOTER_LEGAL);?></a></p>
			<p class = "footer-p"><a class="footer-link" href="<?php echo tnet_get_data_url();; ?>"><?php tnet_e(FOOTER_DATA);?></a></p>
			<p class = "footer-p"><a class="footer-link" href="<?php echo tnet_get_license_url(); ?>"><?php tnet_e(FOOTER_LICENSE);?></a></p>
		</div>
	</div>
</footer>
<span id = "post-footer-hook">
	<?php wp_footer(); // Plugins use this to register Javascript! ?>
</span>