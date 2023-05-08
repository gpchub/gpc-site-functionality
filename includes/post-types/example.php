<?php

namespace GpcSiteFunctionality\Post_Types;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Admin_Api;
use GpcSiteFunctionality\Lib\Post_Type_Helper;
use GpcSiteFunctionality\Lib\Taxonomy_Helper;
use GpcSiteFunctionality\Trait\Singleton;

class Custom_Post_Type_Name
{
    use Singleton;

    public function __construct()
    {
        add_action( 'init', array( $this, 'register_post_type' ) );

        if ( is_admin() ) {
            add_filter( 'gpc_project_custom_fields', [ $this, 'register_custom_fields' ] );
            add_action( 'add_meta_boxes', [$this, 'add_meta_box'] );
        }
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

    public function register_custom_fields($fields)
    {
        return array(
            array(
                'id'          => 'project-custom-name',
                'label'       => __( 'Some Text', 'gpc-site-functionality' ),
                'description' => __( 'This is a standard text field.', 'gpc-site-functionality' ),
                'type'        => 'text',
                'default'     => '',
                'placeholder' => __( 'Placeholder text', 'gpc-site-functionality' ),
                'metabox'     => 'project-custom-fields'
            ),
            array(
                'id'          => 'password_field',
                'label'       => __( 'A Password', 'gpc-site-functionality' ),
                'description' => __( 'This is a standard password field.', 'gpc-site-functionality' ),
                'type'        => 'password',
                'default'     => '',
                'placeholder' => __( 'Placeholder text', 'gpc-site-functionality' ),
                'metabox'     => 'project-custom-fields'
            ),
            array(
                'id'          => 'secret_text_field',
                'label'       => __( 'Some Secret Text', 'gpc-site-functionality' ),
                'description' => __( 'This is a secret text field - any data saved here will not be displayed after the page has reloaded, but it will be saved.', 'gpc-site-functionality' ),
                'type'        => 'text_secret',
                'default'     => '',
                'placeholder' => __( 'Placeholder text', 'gpc-site-functionality' ),
                'metabox'     => 'project-custom-fields'
            ),
            array(
                'id'          => 'text_block',
                'label'       => __( 'A Text Block', 'gpc-site-functionality' ),
                'description' => __( 'This is a standard text area.', 'gpc-site-functionality' ),
                'type'        => 'textarea',
                'default'     => '',
                'placeholder' => __( 'Placeholder text for this textarea', 'gpc-site-functionality' ),
                'metabox'     => 'project-custom-fields'
            ),
            array(
                'id'          => 'single_checkbox',
                'label'       => __( 'An Option', 'gpc-site-functionality' ),
                'description' => __( 'A standard checkbox - if you save this option as checked then it will store the option as \'on\', otherwise it will be an empty string.', 'gpc-site-functionality' ),
                'type'        => 'checkbox',
                'default'     => '',
                'metabox'     => 'project-custom-fields'
            ),
            array(
                'id'          => 'select_box',
                'label'       => __( 'A Select Box', 'gpc-site-functionality' ),
                'description' => __( 'A standard select box.', 'gpc-site-functionality' ),
                'type'        => 'select',
                'options'     => array(
                    'drupal'    => 'Drupal',
                    'joomla'    => 'Joomla',
                    'wordpress' => 'WordPress',
                ),
                'default'     => 'wordpress',
                'metabox'     => 'project-custom-fields'
            ),
            array(
                'id'          => 'radio_buttons',
                'label'       => __( 'Some Options', 'gpc-site-functionality' ),
                'description' => __( 'A standard set of radio buttons.', 'gpc-site-functionality' ),
                'type'        => 'radio',
                'options'     => array(
                    'superman' => 'Superman',
                    'batman'   => 'Batman',
                    'ironman'  => 'Iron Man',
                ),
                'default'     => 'batman',
                'metabox'     => 'project-custom-fields'
            ),
            array(
                'id'          => 'multiple_checkboxes',
                'label'       => __( 'Some Items', 'gpc-site-functionality' ),
                'description' => __( 'You can select multiple items and they will be stored as an array.', 'gpc-site-functionality' ),
                'type'        => 'checkbox_multi',
                'options'     => array(
                    'square'    => 'Square',
                    'circle'    => 'Circle',
                    'rectangle' => 'Rectangle',
                    'triangle'  => 'Triangle',
                ),
                'default'     => array( 'circle', 'triangle' ),
                'metabox'     => 'project-custom-fields'
            ),
        );
    }

    public function add_meta_box()
    {
        $admin_api = Admin_Api::instance();
        $admin_api->add_meta_box('project-custom-fields', 'Thông tin dự án', 'gpc-project');
    }
}