<?php

	// Language Checks
	function tnet_is_language($languageString) { return pll_current_language() == $languageString; }
	function tnet_get_language() { return pll_current_language(); }
	function tnet_get_locale() { return pll_current_language('locale'); }



	// Page Checks
	function tnet_is_game_or_child() { return tnet_is_page_or_child('project-gaia'); }

	function tnet_is_comic_page() { return tnet_is_page('the-box-theory'); }
	function tnet_is_comic_or_child() { return tnet_is_page_or_child('the-box-theory'); }

	function tnet_is_blog_page() { tnet_is_page('blog'); }
	function tnet_is_blog_or_child() { return tnet_is_page_or_child('blog') || is_singular('post'); }

	function tnet_is_page($slug)
	{
		$page = tnet_get_page();

		return $page == $slug || $page == $slug.'-2';
	}

	function tnet_is_page_or_child($slug)
	{
		$page = tnet_get_page();
		$parent = tnet_get_parent();

		return $page == $slug || $page == $slug.'-2' || $parent == $slug || $parent == $slug.'-2';
	}


	function tnet_get_blog_url() { return tnet_get_page_link( tnet_is_language('en') ? 'blog' : 'blog-2' ); }
	function tnet_get_comic_url() { return tnet_get_page_link( tnet_is_language('en') ? 'the-box-theory' : 'the-box-theory-2' ); }
	function tnet_get_game_url() { return tnet_get_page_link( tnet_is_language('en') ? 'project-gaia' : 'project-gaia-2' ); }
	function tnet_get_projects_url() { return tnet_get_page_link( tnet_is_language('en') ? 'blog/projects' : 'blog-2/projects-2' ); }
	function tnet_get_about_url() { return tnet_get_page_link( tnet_is_language('en') ? 'blog/about' : 'blog-2/about-2' ); }

	function tnet_get_legal_url() { return tnet_get_page_link( tnet_is_language('en') ? 'home/legal' : 'home-2/legal-2' ); }
	function tnet_get_data_url() { return tnet_get_page_link( tnet_is_language('en') ? 'home/data' : 'home-2/data-2'); }
	function tnet_get_license_url() { return tnet_get_page_link( tnet_is_language('en') ? 'home/license' : 'home-2/license-2' ); }

	function tnet_get_page_link($page_slug) { return esc_url( get_permalink( get_page_by_path($page_slug)->ID ) ); }



	function tnet_get_page() { return get_queried_object()->post_name; }
	function tnet_get_parent() { return get_post(get_queried_object()->post_parent)->post_name; }



	// Comic Episode Checks
	function tnet_get_next_episode($episode_index, $episode_count, $delta)
	{
		return esc_url(tnet_get_comic_url(). '?episode='.( tnet_fit_into_range( $episode_index+$delta, 1, $episode_count) ));
	}



	// Misc
	function tnet_fit_into_range($value, $min, $max)
	{
		if($value < $min) $value = $min;
		if($value > $max) $value = $max;

		return $value;
	}

	function tnet_echo_header_text($destination, $translatedText)
	{
		$url = esc_url($destination);
		$text = esc_html($translatedText);
		echo '<a class ="header-text-link centered-text" href="' . $url . '"><h2>' . $text . '</h2></a>';
	}
?>