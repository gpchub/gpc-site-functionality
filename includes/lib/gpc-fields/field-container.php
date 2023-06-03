<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Trait\Singleton;

class Field_Container
{
    use Singleton;

    public function __construct()
    {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_script' ], 99, 1 );
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_styles' ], 99, 1 );

        add_action( 'wp_ajax_gpc_field_search_post', [ $this, 'search_post' ]);
        add_action( 'wp_ajax_gpc_field_search_term', [ $this, 'search_term' ]);
    }

    public function make( $type, $id, $title )
    {
        $container = null;
        switch( $type ) {
            case 'post_meta':
                $container = new Post_Meta($id, $title);
                break;
            case 'term_meta':
                $container = new Term_Meta($id, $title);
                break;
            case 'settings':
                $container = new Settings($id, $title);
                break;
        }

        return $container;
    }

    public function enqueue_admin_script()
    {
        wp_register_script( 'gpc-fields', esc_url( GPC_SITE_PLUGIN_ASSETS_URL ) . 'js/custom-fields.js', array( 'jquery' ), GPC_SITE_PLUGIN_VERSION, true );
		wp_enqueue_script( 'gpc-fields' );
    }

    public function admin_enqueue_styles()
    {
        //register jquery ui theme để field nào cần thì enqueue
        wp_register_style( 'jquery-ui-theme', esc_url( GPC_SITE_PLUGIN_ASSETS_URL ) . 'css/jquery-ui.min.css', array(), '1.13.2' );

        wp_register_style( 'gpc-fields', esc_url( GPC_SITE_PLUGIN_ASSETS_URL ) . 'css/custom-fields.css', array(), GPC_SITE_PLUGIN_VERSION );
		wp_enqueue_style( 'gpc-fields' );
    }

    /**
     * Ajax search post theo từ khoá, dùng cho field autocomplete
     */
    public function search_post()
    {
        // we will pass post IDs and titles to this array
        $return = array();

        $post_type = !empty($_GET['post_type']) ? $_GET['post_type'] : 'post';

        // you can use WP_Query, query_posts() or get_posts() here - it doesn't matter
        $search_results = new \WP_Query( array(
            's'=> $_GET['q'], // the search query
            'post_type' => $post_type,
            'post_status' => 'publish', // if you don't want drafts to be returned
            'ignore_sticky_posts' => 1,
            'posts_per_page' => 10 // how much to show at once
        ) );

        if( $search_results->have_posts() ) :
            while( $search_results->have_posts() ) :
                $search_results->the_post();
                // shorten the title a little
                //$title = ( mb_strlen( $search_results->post->post_title ) > 100 ) ? mb_substr( $search_results->post->post_title, 0, 99 ) . '...' : $search_results->post->post_title;
                $title = $search_results->post->post_title;
                $return[] = array(
                    'id' => $search_results->post->ID,
                    'label' => $title,
                    'value' => $title,
                ); // array( Post ID, Post Title )
            endwhile;
        endif;
        echo json_encode( $return );
        die;
    }

    /**
     * Ajax search term theo từ khoá, dùng cho field autocomplete
     */
    public function search_term()
    {
        $return = array();

        $taxonomy = !empty($_GET['taxonomy']) ? $_GET['taxonomy'] : 'category';

        $terms = get_terms( array(
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
            'name__like' => $_GET['q'],
        ) );

        if( !empty($terms) ) :
            foreach ( $terms as $term ) :
                $title = $term->name;
                $return[] = array(
                    'id' => $term->term_id,
                    'label' => $title,
                    'value' => $title,
                ); // array( Post ID, Post Title )
            endforeach;
        endif;
        echo json_encode( $return );
        die;
    }
}