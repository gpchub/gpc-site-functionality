<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings
{
    protected $id;
    protected $title;
    protected $menu_icon;
    protected $menu_position;
    protected $menu_parent;
    protected $capability = 'manage_options';
    protected $page_description = '';
    /**
     * List of fields
     *
     * @var Field[]
     */
    protected $fields;

    protected $option_values;

    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;

        $this->option_values = get_option($this->id);

        add_action('admin_init', [$this, 'settings_init']);
        add_action('admin_menu', [$this, 'add_menu']);
    }

    public function add_fields($fields = [])
    {
        foreach ( $fields as $field ) {
            $field->setting_id = $this->id;
        }
        $this->fields = $fields;
        return $this;
    }

    public function set_menu_icon( $icon )
    {
        $this->menu_icon = $icon;
        return $this;
    }

    public function set_menu_position( $position )
    {
        $this->menu_position = $position;
        return $this;
    }

    public function set_capability( $capability )
    {
        $this->capability = $capability;
        return $this;
    }

    public function set_menu_parent( $parent )
    {
        switch ( $parent ) {
            case 'options':
                $parent = 'options-general.php';
                break;
            case 'tools':
                $parent = 'tools.php';
                break;
            case 'plugins':
                $parent = 'plugins.php';
                break;
            case 'themes':
                $parent = 'themes.php';
                break;
        }
        $this->menu_parent = $parent;
        return $this;
    }

    public function set_page_description( $description )
    {
        $this->page_description = $description;
        return $this;
    }

    public function settings_init()
    {
        register_setting(
            $this->id, // option_group
            $this->id, // option_name
            array(
                'sanitize_callback' => [ $this, 'sanitize_settings' ]
            )
        );

        $section_id = $this->id . '_section';

        // Register a new section in the setting page.
        add_settings_section(
            $section_id,
            '', // không cần section title vì chỉ có 1 section
            [ $this, 'render_page_description' ],
            $this->id
        );

        foreach ( $this->fields as $field ) {
            add_settings_field(
                $field->id, // string $id,
                $field->label, // string $title,
                [ $this, 'render_field' ], // callable $callback,
                $this->id, // string $page,
                $section_id, // string $section = 'default',
                [ // array $args = array()
                    'label_for' => $field->id,
                    'field' => $field,
                ]
            );
        }
    }

    function render_page_description($args)
    {
        echo $this->page_description;
    }

    public function render_field( $args )
    {
        $field = $args['field'];
        $field->value = isset($this->option_values[$field->id]) ? $this->option_values[$field->id] : null;
        echo $field->render();
    }

    public function add_menu()
    {
        if ( !empty( $this->menu_parent ) ) {
            add_submenu_page(
                $this->menu_parent, // string $parent_slug,
                $this->title, // string $page_title,
                $this->title, // string $menu_title,
                $this->capability, // string $capability,
                $this->id, // string $menu_slug,
                [ $this, 'settings_page_html' ], // callable $callback = '',
                $this->menu_position, // int|float $position = null
            );
        } else {
            add_menu_page(
                $this->title, // string $page_title,
                $this->title, // string $menu_title,
                $this->capability, // string $capability,
                $this->id, // string $menu_slug,
                [ $this, 'settings_page_html' ], // callable $callback = '',
                $this->menu_icon, // string $icon_url = '',
                $this->menu_position, // int|float $position = null
            );
        }
    }

    public function settings_page_html()
    {
        // check user capabilities
        if (!current_user_can($this->capability)) {
            return;
        }

        // check if the user have submitted the settings
        // WordPress will add the "settings-updated" $_GET parameter to the url
        if (isset($_GET['settings-updated'])) {
            // add settings saved message with the class of "updated"
            add_settings_error($this->id, 'gpc_site_settings_message', __('Settings Saved', 'wporg'), 'updated');
        }

        // show error/update messages
        settings_errors($this->id);
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
            <?php
                // output security fields for the registered setting
                settings_fields($this->id); // option_group

                // output setting sections and their fields
                do_settings_sections($this->id);

                // output save settings button
                submit_button('Save Settings');
            ?>
            </form>
        </div>
        <?php
    }

    public function sanitize_settings( $input )
    {
        $output = array();

        foreach ( $this->fields as $field ) {
            if ( isset( $input[ $field->id ] ) ) {
                $output[ $field->id ] = $field->sanitize( $input[ $field->id ] );
            }
        }
        return $output;
    }
}
