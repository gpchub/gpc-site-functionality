<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field;

class Select extends Field
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

        <select name="<?php echo $this->get_field_name(); ?>" id="<?php echo $this->id; ?>">
        <?php foreach ( $this->options as $val => $label ) :
            $selected = false;
            if ( $val === $this->value ) {
                $selected = true;
            } ?>
            <option <?php selected( $selected, true, true ); ?> value="<?php esc_attr_e( $val ); ?>"><?php echo $label; ?></option>
        <?php endforeach; ?>
        </select>

        <?php
        $html = ob_get_clean();
        return $html;
    }
}