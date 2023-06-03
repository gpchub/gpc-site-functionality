<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field;

class Datepicker extends Field
{
    public function get_script_depends()
    {
        return ['jquery-ui-datepicker'];
    }

    public function get_style_depends()
    {
        return [ 'jquery-ui-theme' ];
    }

    public function render_field()
    {
        $date_value = '';
        if ( $this->value ) {
            $date = \DateTime::createFromFormat('Y/m/d', $this->value);
            $date_value = $date->format('d/m/Y');
        }
        ob_start(); ?>

        <input id="<?php esc_attr_e($this->id); ?>" autocomplete="off" type="text" class="gpc-field-datepicker" name="<?php esc_attr_e($this->get_field_name()); ?>" placeholder="<?php esc_attr_e($this->placeholder); ?>" value="<?php esc_attr_e( $date_value ); ?>" />

        <?php

        $html = ob_get_clean();

        return $html;
    }

    public function sanitize($value)
    {
        // lưu giá trị trong db ở dạng Y/m/d
        if ( !empty($value) ) {
            $date = \DateTime::createFromFormat('d/m/Y', $value);
            $value = $date->format('Y/m/d');
        }
        return $value;
    }
}