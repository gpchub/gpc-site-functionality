<?php

namespace GpcSiteFunctionality\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field_Container;
use GpcSiteFunctionality\Lib\Gpc_Fields\Field_Factory;
use GpcSiteFunctionality\Trait\Singleton;

class Site_Settings
{
    use Singleton;

    public function __construct()
    {
        $container = Field_Container::instance();
        $container->make('settings', 'my-settings', 'My Settings')
            ->set_menu_icon('dashicons-admin-site')
            ->set_page_description('<p>Hello site settings</p>')
            ->add_fields( array(
                    Field_Factory::make('text', 'project-custom-name', 'Project Custom Name')
                        ->set_description('Project Custom Name Description'),
                    Field_Factory::make('textarea', 'project-description', 'Project Description'),
                    Field_Factory::make('checkbox', 'project-checkbox', 'Project checkbox')
                        ->set_description('checkbox description'),
                    Field_Factory::make('checkbox', 'project-checkbox-list', 'Project checkbox list')
                        ->set_multiple(true)
                        ->set_description('checkbox description')
                        ->set_options([
                            'thu-2' => 'Thu 2',
                            'thu-3' => 'Thu 3',
                            'thu-4' => 'Thu 4',
                            'thu-5' => 'Thu 5',
                        ]),
                    Field_Factory::make('radio', 'project-radio-list', 'Project radio list')
                        ->set_description('checkbox description')
                        ->set_options([
                            'thu-2' => 'Thu 2',
                            'thu-3' => 'Thu 3',
                            'thu-4' => 'Thu 4',
                            'thu-5' => 'Thu 5',
                        ]),
                    Field_Factory::make('select', 'project-select', 'Project select')
                        ->set_description('select description')
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