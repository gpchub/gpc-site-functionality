<?php

namespace GpcSiteFunctionality\Post_Types;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Post_Type_Helper;
use GpcSiteFunctionality\Lib\Taxonomy_Helper;
use GpcSiteFunctionality\Trait\Singleton;

class Project
{
    use Singleton;

    public function __construct()
    {
        add_action( 'init', array( $this, 'register_post_type' ) );
    }

    public function register_post_type()
    {
        Post_Type_Helper::register('gpc_project', 'Dự án', '', [
            'rewrite' => array( 'slug' => 'du-an' ),
        ]);
        Taxonomy_Helper::regiter('gpc_project_cat', ['gpc-project'], 'Danh mục dự án', '', [
            'rewrite' => array( 'slug' => 'danh-muc-du-an' ),
        ]);
    }
}