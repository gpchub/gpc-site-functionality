<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field;

class Checkbox extends Field
{
    protected $is_multiple = false;
    protected $options = [];

    public function set_multiple( bool $value )
    {
        $this->is_multiple = $value;
        return $this;
    }

    public function set_options(array $options = [])
    {
        $this->options = $options;
        return $this;
    }

    public function render_field()
    {
        if ( $this->is_multiple ) {
            return $this->render_field_multiple();
        } else {
            return $this->render_field_single();
        }
    }

    public function render_field_single()
    {
        $checked = '';
        if ( $this->value && 'yes' === $this->value ) {
            $checked = 'checked="checked"';
        }

        ob_start(); ?>

        <input id="<?php echo $this->id; ?>" type="checkbox" name="<?php echo $this->get_field_name(); ?>" value="yes" <?php echo $checked; ?>/>

        <?php

        $html = ob_get_clean();
        return $html;
    }

    public function render_field_multiple()
    {
        if ( empty($this->value) ) {
            $this->value = [];
        }

        ob_start(); ?>

        <ul class="gpc-checkbox-group">
			<?php foreach ( $this->options as $val => $label ) :
                $checked = false;
                if ( in_array( $val, $this->value, true ) ) {
                    $checked = true;
                }

                ?>
                <li>
                    <label for="<?php echo esc_attr_e( $this->id . '_' . $val ); ?>">
                        <input type="checkbox" <?php checked( $checked, true, true ); ?> name="<?php echo $this->get_field_name(); ?>[]" value="<?php esc_attr_e( $val ); ?>" id="<?php echo esc_attr_e( $this->id . '_' . $val); ?>" /><?php echo $label; ?>
                    </label>
                </li>
			<?php endforeach; ?>
        </ul>

        <?php
        $html = ob_get_clean();
        return $html;
    }
}