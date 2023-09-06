<?php
	function ilcc_modify_title_text( $text )
	{
		return tnet_pl(COOKIE_TITLE_TEXT);
	}
	add_filter( 'ilcc_consent_title', 'ilcc_modify_title_text' );

	function ilcc_modify_consent_text( $text )
	{
		return tnet_pl(COOKIE_CONSENT_TEXT);
	}
	add_filter( 'ilcc_consent_text', 'ilcc_modify_consent_text' );

	function ilcc_modify_accept_text( $text )
	{
		return tnet_pl(COOKIE_ACCEPT_TEXT);
	}
	add_filter( 'ilcc_accept_text', 'ilcc_modify_accept_text' );

	add_filter( 'ilcc_load_stylesheet', '__return_false' );
?>