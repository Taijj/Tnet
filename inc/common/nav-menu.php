<?php
	/**
	 * @package TNET
	 * @since TNET 1.0
	 */
?>
	<?php
		$nav_menu = '';
		if( tnet_is_comic_or_child() )
		{
			$nav_menu = 'comic';
		}
		else if( tnet_is_game_or_child() )
		{
			$nav_menu = 'game';
		}
		else if( is_404() )
		{
			$nav_menu = 'error';
		}
		else
		{
			$nav_menu = 'common';
		}
	?>

	<div class="nav-menu-mobile">
		<?php wp_nav_menu( array(
			'container_class' => 'wordpress-mobile-menu',
			'theme_location' => $nav_menu,
			'add_li_class' => 'box-shadow' )
			); ?>
	</div>

	<div id="nav-menu-desktop" class="nav-menu-desktop">

		<?php wp_nav_menu( array(
			'container_class' => 'wordpress-desktop-menu',
			'theme_location' => $nav_menu,
			'add_li_class' => 'box-shadow' )
			); ?>

		<div class="language-switcher-desktop">
			<div class="language-switcher">
				<?php pll_the_languages(array ('show_flags' => 1, 'show_names' => 0)); ?>
			</div>
		</div>

	</div>
