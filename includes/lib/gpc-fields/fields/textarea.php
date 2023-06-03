<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field;

class Textarea extends Field
{
    protected $rows = 4;

    public function set_rows( $rows )
    {
        $this->rows = $rows;
        return $this;
    }

    public function render_field()
    {
        ob_start(); ?>

        <textarea id="<?php esc_attr_e($this->id); ?>" rows="<?php esc_attr_e($this->rows); ?>" name="<?php esc_attr_e($this->get_field_name()); ?>" class="regular-text" placeholder="<?php esc_attr_e($this->placeholder); ?>"><?php echo $this->value; ?></textarea>

        <?php

        $html = ob_get_clean();
        return $html;
    }
}