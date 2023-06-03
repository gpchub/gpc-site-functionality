<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields;

if ( ! defined( 'ABSPATH' ) ) {
    die;
}

class Field
{
    public $id;
    public $label;
    public $type;
    public $description;
    public $default;
    public $placeholder;
    public $value;
    public $setting_id; // dùng cho trang setting

    public $script_depends = [];
    public $style_depends = [];

    public function __construct( $type, $id, $label )
    {
        $this->type = $type;
        $this->id = $id;
        $this->label = $label;

        $this->script_depends = $this->get_script_depends();
        $this->style_depends = $this->get_style_depends();

        if ( !empty($this->script_depends) ) {
            add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ], 10, 1 );
        }

        if ( !empty($this->style_depends) ) {
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ), 10, 1 );
        }
    }

    public function get_script_depends()
    {
        return [];
    }

    public function get_style_depends()
    {
        return [];
    }

    protected function get_field_name()
    {
        if ( !empty($this->setting_id) ) {
            return $this->setting_id . '[' . $this->id . ']';
        }

        return $this->id;
    }

    public function enqueue_admin_scripts()
    {
        foreach ( $this->script_depends as $script ) {
            if ( is_array( $script ) ) {
                $deps = isset($script['deps']) ? $script['deps'] : [];
                $version = isset($script['version']) ? $script['version'] : '';
                wp_enqueue_script( $script['id'], $script['src'], $deps, $version, true );
            } else if ( is_string( $script ) ) {
                if ( $script == 'wp-media' ) {
                    wp_enqueue_media();
                } else {
                    wp_enqueue_script( $script );
                }
            }
        }
    }

    public function enqueue_admin_styles()
    {
        foreach ( $this->style_depends as $style ) {
            if ( is_array( $style ) ) {
                $deps = isset($style['deps']) ? $style['deps'] : [];
                $version = isset($style['version']) ? $style['version'] : '';
                wp_enqueue_style( $style['id'], $style['src'], $deps, $version );
            } else if ( is_string( $style ) ) {
                wp_enqueue_style( $style );
            }
        }
    }

    public function set_placeholder($text)
    {
        $this->placeholder = $text;
        return $this;
    }

    public function set_description($text)
    {
        $this->description = $text;
        return $this;
    }

    public function set_default($value)
    {
        $this->default = $value;
        return $this;
    }

    public function set_value( $value )
    {
        $this->value = $value;
        return $this;
    }

    public function render()
    {
        return $this->render_field() . $this->render_description();
    }

    public function render_field()
    {
        return '';
    }

    public function render_description()
    {
        $html = '';
        if ( !empty( $this->description ) ) {
            $html = '<span class="description">' . $this->description . '</span>';
        }

        return $html;
    }

    public function sanitize( $value )
    {
        return $value;
    }
}