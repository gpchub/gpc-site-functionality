<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field;

class Select_Term extends Field
{
    protected $taxonomy = 'category';

    public function set_taxonomy( $type )
    {
        $type = !empty($type) ? $type : 'category';
        $this->taxonomy = $type;
        return $this;
    }

    public function get_script_depends()
    {
        return ['jquery-ui-autocomplete'];
    }

    public function get_style_depends()
    {
        return [ 'jquery-ui-theme' ];
    }

    public function render_field()
    {
        $term_ids = [];
        if ( !empty( $this->value ) ) {
            $term_ids = maybe_unserialize($this->value);
        }

        $list_style = '';
        if ( empty($term_ids) ) {
            $list_style = 'style="display:none;"';
        }

        ob_start(); ?>

        <div class="gpc-field-autocomplete" data-type="term" data-taxonomy="<?php echo $this->taxonomy; ?>">
            <input id="<?php esc_attr_e($this->id); ?>_input" type="text" name="<?php esc_attr_e($this->id); ?>_input" placeholder="<?php esc_attr_e($this->placeholder); ?>" value="" class="gpc-field-term-search gpc-field-autocomplete-input" />
            <ul class="gpc-field-autocomplete-selected" <?php echo $list_style; ?>>
                <?php foreach ($term_ids as $i => &$id) :
                    $term = get_term( $id, $this->taxonomy );
                    if ($term) :
                ?>
                        <li data-id="<?php echo $id; ?>" class="gpc-field-autocomplete-selected__item ui-state-default">
                            <span class="ui-icon ui-icon-arrowthick-2-n-s"></span> <?php echo $term->name; ?>
                            <a href="#" class="gpc-field-autocomplete-selected__remove"><span class="dashicons dashicons-remove"></span></a>
                        </li>
                <?php else :
                        unset( $term_ids[ $i ] );
                    endif;
                endforeach; ?>
            </ul>
            <input id="<?php esc_attr_e($this->id); ?>" class="gpc-field-autocomplete__value" type="hidden" name="<?php esc_attr_e($this->get_field_name()); ?>" value="<?php echo join( ',', $term_ids ); ?>" />
        </div>
        <?php

        $html = ob_get_clean();
        return $html;
    }

    public function sanitize($value)
    {
        if ( !empty($value) ) {
            $value = array_map('intval', explode(',', $value));
        }
        return $value;
    }
}