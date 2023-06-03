<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field;

class Select_Post extends Field
{
    protected $post_type = 'post';

    public function set_post_type( $type )
    {
        $type = !empty($type) ? $type : 'post';
        $this->post_type = $type;
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
        $post_ids = [];
        if ( !empty( $this->value ) ) {
            $post_ids = maybe_unserialize($this->value);
        }

        $list_style = '';
        if ( empty($post_ids) ) {
            $list_style = 'style="display:none;"';
        }

        ob_start(); ?>

        <div class="gpc-field-autocomplete" data-type="post" data-post-type="<?php echo $this->post_type; ?>">
            <input id="<?php esc_attr_e($this->id); ?>_input" type="text" name="<?php esc_attr_e($this->id); ?>_input" placeholder="<?php esc_attr_e($this->placeholder); ?>" value="" class="gpc-field-post-search gpc-field-autocomplete-input" />
            <ul class="gpc-field-autocomplete-selected" <?php echo $list_style; ?>>
                <?php foreach ($post_ids as $i => &$id) :
                    $post = get_post( $id );
                    if ($post) :
                ?>
                        <li data-id="<?php echo $id; ?>" class="gpc-field-autocomplete-selected__item ui-state-default">
                            <span class="ui-icon ui-icon-arrowthick-2-n-s"></span> <?php echo $post->post_title; ?>
                            <a href="#" class="gpc-field-autocomplete-selected__remove"><span class="dashicons dashicons-remove"></span></a>
                        </li>
                <?php else :
                        unset( $post_ids[ $i ] );
                    endif;
                endforeach; ?>
            </ul>
            <input id="<?php esc_attr_e($this->id); ?>" class="gpc-field-autocomplete__value" type="hidden" name="<?php esc_attr_e($this->get_field_name()); ?>" value="<?php echo join( ',', $post_ids ); ?>" />
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