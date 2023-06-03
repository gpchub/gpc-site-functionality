<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field;

class Number extends Field
{
    protected $min;
    protected $max;

    public function set_min( $min )
    {
        $this->min = $min;
        return $this;
    }

    public function set_max( $max )
    {
        $this->max = $max;
        return $this;
    }

    public function render_field()
    {
        $min_attribute = isset($this->min) ? 'min="' . $this->min . '"' : '';
        $max_attribute = isset($this->max) ? 'max="' . $this->max . '"' : '';

        ob_start(); ?>

        <input id="<?php esc_attr_e($this->id); ?>" type="number" name="<?php esc_attr_e($this->get_field_name()); ?>" placeholder="<?php esc_attr_e($this->placeholder); ?>" <?php echo $min_attribute;?> <?php echo $max_attribute;?> value="<?php esc_attr_e( $this->value ); ?>" />

        <?php

        $html = ob_get_clean();
        return $html;
    }

    public function sanitize($value)
    {
        if ($this->min && $value < $this->min)
        {
            $value = $this->min;
        }

        if ($this->max && $value > $this->max)
        {
            $value = $this->max;
        }

        return $value;
    }
}