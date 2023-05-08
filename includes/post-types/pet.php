<?php

namespace GpcSiteFunctionality\Post_Types;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Post_Type_Helper;
use GpcSiteFunctionality\Lib\Taxonomy_Helper;
use GpcSiteFunctionality\Trait\Singleton;

class Pet
{
    use Singleton;

    public function __construct()
    {
        add_action( 'init', array( $this, 'register_post_type' ) );
    }

    public function register_post_type()
    {
        Post_Type_Helper::register('gpc_pet', 'Thú cưng', '', [
            'rewrite' => array( 'slug' => 'thu-cung' ),
        ]);
        Taxonomy_Helper::regiter('gpc_pet_cat', ['gpc-pet'], 'Danh mục thú cưng', '', [
            'rewrite' => array( 'slug' => 'danh-muc-thu-cung' ),
        ]);
    }

}