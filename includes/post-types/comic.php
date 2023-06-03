<?php

namespace GpcSiteFunctionality\Post_Types;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Post_Type_Helper;
use GpcSiteFunctionality\Lib\Taxonomy_Helper;
use GpcSiteFunctionality\Trait\Singleton;

class Comic
{
    use Singleton;

    public function __construct()
    {
        add_action( 'init', array( $this, 'register_post_type' ) );
    }

    public function register_post_type()
    {
        Post_Type_Helper::register('gpc_comic', 'Comic', '', [
            'rewrite' => array( 'slug' => 'comic' ),
        ]);
        Taxonomy_Helper::regiter('gpc_comic_cat', ['gpc_comic'], 'Danh mục comic', '', [
            'rewrite' => array( 'slug' => 'danh-muc-comic' ),
        ]);
    }

}