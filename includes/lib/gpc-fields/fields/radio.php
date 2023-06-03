<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field;

class Radio extends Field
{
    protected $options = [];

    public function set_options(array $options = [])
    {
        $this->options = $options;
        return $this;
    }

    public function render_field()
    {
        ob_start(); ?>

        <ul class="gpc-radio-group">
        <?php foreach ( $this->options as $val => $label ) :
            $checked = false;
            if ( $val === $this->value ) {
                $checked = true;
            } ?>

            <li>
                <label for="<?php echo esc_attr_e( $this->id . '_' . $val ); ?>">
                    <input type="radio" <?php checked( $checked, true, true ); ?> name="<?php echo $this->get_field_name(); ?>" value="<?php esc_attr_e( $val ); ?>" id="<?php echo esc_attr_e( $this->id . '_' . $val); ?>" /><?php echo $label; ?>
                </label>
            </li>
        <?php endforeach; ?>
        </ul>

        <?php
        $html = ob_get_clean();
        return $html;
    }
}