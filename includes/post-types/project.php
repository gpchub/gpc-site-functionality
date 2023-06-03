<?php

namespace GpcSiteFunctionality\Post_Types;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field_Container;
use GpcSiteFunctionality\Lib\Gpc_Fields\Field_Factory;
use GpcSiteFunctionality\Lib\Post_Type_Helper;
use GpcSiteFunctionality\Lib\Taxonomy_Helper;
use GpcSiteFunctionality\Trait\Singleton;

class Project extends Gpc_Kadence_Post_Type
{
    use Singleton;

    public function __construct()
    {
        add_action( 'init', array( $this, 'register_post_type' ) );

        $this->add_meta_box();
        $this->add_term_meta();

        parent::__construct();
    }

    public function get_related_options()
    {
        return [
            'enabled' => true,
            'post_type' => 'gpc_project',
            'heading' => 'Xem thêm dự án khác',
            'cols' => array(
                'xxl' => 3,
                'xl'  => 3,
                'md'  => 3,
                'sm'  => 2,
                'xs'  => 2,
                'ss'  => 1,
            ),
            'count' => 6,
            'related_by' => []
        ];
    }

    public function register_post_type()
    {
        Post_Type_Helper::register('gpc_project', 'Dự án', '', [
            'rewrite' => array( 'slug' => 'du-an' ),
        ]);
        Taxonomy_Helper::regiter('gpc_project_cat', ['gpc_project'], 'Danh mục dự án', '', [
            'rewrite' => array( 'slug' => 'danh-muc-du-an' ),
        ]);
    }

    public function add_meta_box()
    {
        $container = Field_Container::instance();
        $container->make('post_meta', 'gpc_project_info', 'Thông tin dự án')
            ->where('gpc_project')
            ->add_fields( array(
                    Field_Factory::make('text', 'project-custom-name', 'Project Custom Name')
                        ->set_description('Project Custom Name Description'),
                    Field_Factory::make('textarea', 'project-description', 'Project Description'),
                    Field_Factory::make('checkbox', 'project-checkbox', 'Project checkbox')
                        ->set_description('Checkbox description'),
                    Field_Factory::make('checkbox', 'project-checkbox-list', 'Project checkbox list')
                        ->set_multiple(true)
                        ->set_description('Checkbox list description')
                        ->set_options([
                            'thu-2' => 'Thu 2',
                            'thu-3' => 'Thu 3',
                            'thu-4' => 'Thu 4',
                            'thu-5' => 'Thu 5',
                        ]),
                    Field_Factory::make('radio', 'project-radio-list', 'Project radio list')
                        ->set_description('Radio description')
                        ->set_options([
                            'thu-2' => 'Thu 2',
                            'thu-3' => 'Thu 3',
                            'thu-4' => 'Thu 4',
                            'thu-5' => 'Thu 5',
                        ]),
                    Field_Factory::make('select', 'project-select', 'Project select')
                        ->set_description('Select description')
                        ->set_options([
                            'thu-2' => 'Thu 2',
                            'thu-3' => 'Thu 3',
                            'thu-4' => 'Thu 4',
                            'thu-5' => 'Thu 5',
                        ]),
                    Field_Factory::make('number', 'project-number', 'Project Number')
                        ->set_min(0)
                        ->set_max(10),
                    Field_Factory::make('colorpicker', 'project-color', 'Màu dự án'),
                    Field_Factory::make('datepicker', 'project-date', 'Ngày dự án'),
                    Field_Factory::make('media', 'project-image', 'Hình dự án'),
                    Field_Factory::make('gallery', 'project-gallery', 'Gallery dự án'),
                    Field_Factory::make('select-post', 'project-posts', 'Liên kết posts')
                        ->set_post_type('gpc_project'),
                    Field_Factory::make('select-term', 'project-terms', 'Liên kết terms')
                        ->set_taxonomy('category'),
                )
            );
    }

    public function add_term_meta()
    {
        $container = Field_Container::instance();
        $container->make('term_meta', 'gpc_project_cat_info', 'Thông tin chuyên mục')
            ->where('gpc_project_cat')
            ->add_fields( array(
                    Field_Factory::make('text', 'project-custom-name', 'Project Custom Name')
                        ->set_description('Project Custom Name Description'),
                    Field_Factory::make('textarea', 'project-description', 'Project Description'),
                    Field_Factory::make('checkbox', 'project-checkbox', 'Project checkbox')
                        ->set_description('Checkbox description'),
                    Field_Factory::make('checkbox', 'project-checkbox-list', 'Project checkbox list')
                        ->set_multiple(true)
                        ->set_description('Checkbox list description')
                        ->set_options([
                            'thu-2' => 'Thu 2',
                            'thu-3' => 'Thu 3',
                            'thu-4' => 'Thu 4',
                            'thu-5' => 'Thu 5',
                        ]),
                    Field_Factory::make('radio', 'project-radio-list', 'Project radio list')
                        ->set_description('Radio description')
                        ->set_options([
                            'thu-2' => 'Thu 2',
                            'thu-3' => 'Thu 3',
                            'thu-4' => 'Thu 4',
                            'thu-5' => 'Thu 5',
                        ]),
                    Field_Factory::make('select', 'project-select', 'Project select')
                        ->set_description('Select description')
                        ->set_options([
                            'thu-2' => 'Thu 2',
                            'thu-3' => 'Thu 3',
                            'thu-4' => 'Thu 4',
                            'thu-5' => 'Thu 5',
                        ]),
                    Field_Factory::make('number', 'project-number', 'Project Number')
                        ->set_min(0)
                        ->set_max(10),
                    Field_Factory::make('colorpicker', 'project-color', 'Màu dự án'),
                    Field_Factory::make('datepicker', 'project-date', 'Ngày dự án'),
                    Field_Factory::make('media', 'project-image', 'Hình dự án'),
                    Field_Factory::make('gallery', 'project-gallery', 'Gallery dự án'),
                    Field_Factory::make('select-post', 'project-posts', 'Liên kết posts')
                        ->set_post_type('gpc_project'),
                    Field_Factory::make('select-term', 'project-terms', 'Liên kết terms')
                        ->set_taxonomy('category'),
                )
            );
    }
}