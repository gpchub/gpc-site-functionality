<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field;

class Colorpicker extends Field
{
    public function get_script_depends()
    {
        return ['wp-color-picker'];
    }

    public function get_style_depends()
    {
        return ['wp-color-picker'];
    }

    public function render_field()
    {
        ob_start(); ?>

        <input id="<?php esc_attr_e($this->id); ?>" type="text" class="gpc-field-color" name="<?php esc_attr_e($this->get_field_name()); ?>" placeholder="<?php esc_attr_e($this->placeholder); ?>" value="<?php esc_attr_e( $this->value ); ?>" />

        <?php

        $html = ob_get_clean();

        return $html;
    }

    public function sanitize($value)
    {
        return esc_attr( $value );
    }
}