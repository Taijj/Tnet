<?php
	$layoutPath = get_template_directory();
	$translatedText = "";
	$linkDestination = "";
	if( tnet_is_comic_or_child() )
	{
		$layoutPath .= '/inc/headers/comic.php';
		$translatedText = tnet_pl(HEADER_COMIC);
		$linkDestination = tnet_get_comic_url();
	}
	else if( tnet_is_game_or_child() )
	{
		$layoutPath .= '/inc/headers/game.php';
		$translatedText = tnet_pl(HEADER_GAME);
		$linkDestination = tnet_get_game_url();
	}
	else if( tnet_is_blog_or_child() )
	{
		$layoutPath .= '/inc/headers/blog.php';
		$translatedText = tnet_pl(HEADER_BLOG);
		$linkDestination = tnet_get_blog_url();
	}
	else
	{
		$layoutPath .= '/inc/headers/main.php';
		$translatedText = tnet_pl(HEADER_MAIN);
		$linkDestination = get_home_url();
	}
?>

<header class="header" role="banner">
	<div class="header-container">
		<div class="header-menu-section">
			<div class="mobile-menu-button nearest-neighbor"></div>
		</div>
		<div class="header-main-section">
			<a class="header-images-link" href="<?php echo $linkDestination; ?>">
				<?php require($layoutPath); ?>
			</a>
			<?php tnet_echo_header_text($linkDestination, $translatedText); ?>
		</div>
		<div class="header-language-section">
			<?php pll_the_languages(array ('show_flags' => 1, 'show_names' => 0)); ?>
		</div>
	</div>
</header>