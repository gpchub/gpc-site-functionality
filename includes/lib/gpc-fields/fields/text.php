<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field;

class Text extends Field
{
    protected $subtype = 'text';

    public function set_subtype($subtype)
    {
        $allowed_subtypes = ['text', 'email', 'url', 'password'];

        if ( !in_array( $subtype, $allowed_subtypes )) {
            $subtype = 'text';
        }

        $this->subtype = $subtype;
        return $this;
    }

    public function render_field()
    {
        ob_start(); ?>

        <input id="<?php esc_attr_e($this->id); ?>" type="<?php echo $this->subtype; ?>" name="<?php esc_attr_e($this->get_field_name()); ?>" class="regular-text" placeholder="<?php esc_attr_e($this->placeholder); ?>" value="<?php esc_attr_e( $this->value ); ?>" />

        <?php

        $html = ob_get_clean();

        return $html;
    }

    public function sanitize($value)
    {
        return esc_attr( $value );
    }
}