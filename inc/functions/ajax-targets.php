<?php
    //Load page into another page
    add_action( 'wp_ajax_tnet_load_post_content', 'tnet_load_post_content' );
    add_action( 'wp_ajax_nopriv_tnet_load_post_content', 'tnet_load_post_content' );

    function tnet_load_post_content() {

        $id = $_POST['pageId'];
        $meta = get_post_meta( $id, 'panels_data', true );

        if( class_exists( 'SiteOrigin_Panels' ) && $meta )
        {
            $renderer = SiteOrigin_Panels::renderer();
            $content = $renderer->render( $id );
            $css = $renderer->generate_css( $id );
        }
        else
        {
            $css = '';
            $content = apply_filters( 'the_content', get_page($id)->post_content );
        }

        $content = COMPLIANZ::$cookie_blocker->replace_tags($content);
        echo json_encode(array($content, $css));
        die(); //<- will add a 0 in response, if not called!
    }

    //Verify portfolio password
    add_action( 'wp_ajax_tnet_verify_portfolio_password', 'tnet_verify_portfolio_password' );
    add_action( 'wp_ajax_nopriv_tnet_verify_portfolio_password', 'tnet_verify_portfolio_password' );
    define('PORTFOLIO_PASSWORD', 'please');

    function tnet_verify_portfolio_password()
    {
        $input = $_POST['input'];
        echo $input == PORTFOLIO_PASSWORD ? "true" : "false";
        die(); //<- will add a 0 in response, if not called!
    }

    //Load gallery widget modal html layout
    add_action( 'wp_ajax_tnet_load_gallery_modal', 'tnet_load_gallery_modal' );
    add_action( 'wp_ajax_nopriv_tnet_load_gallery_modal', 'tnet_load_gallery_modal' );

    function tnet_load_gallery_modal()
    {
        $path = get_template_directory() . '/inc/functions/gallery-widget-modal.php';
        $content = file_get_contents($path); //<- require adds a 1 in response otherwise
        echo $content;
        die(); //<- will add a 0 in response, if not called!
    }
?>