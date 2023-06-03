<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Field;

class Media extends Field
{
    protected $is_multiple = false;

    public function set_multiple( bool $value )
    {
        $this->is_multiple = $value;
        return $this;
    }

    public function get_script_depends()
    {
        $deps = ['wp-media'];
        if ($this->is_multiple) {
            $deps[] = 'jquery-ui-sortable';
        }
        return $deps;
    }

    public function render_field()
    {
        if ( $this->is_multiple ) {
            return $this->render_field_gallery();
        } else {
            return $this->render_field_image();
        }
    }

    public function render_field_image()
    {
        $image_thumb = '';

        if ( !empty( $this->value ) ) {
            $image_thumb = wp_get_attachment_thumb_url( $this->value );
        }

        ob_start(); ?>
        <div class="gpc-field-image">
            <img style="display: block; margin-bottom: 5px;" id="<?php echo $this->id; ?>_preview" class="image_preview" src="<?php echo $image_thumb; ?>" />
            <input id="<?php echo $this->id; ?>_button"
                    type="button"
                    data-uploader_title="<?php _e( 'Add Image', 'gpc-site-functionality' ); ?>"
                    data-uploader_button_text="<?php _e( 'Use image', 'gpc-site-functionality' ); ?>"
                    class="image_upload_button button"
                    value="<?php _e( 'Add Image', 'gpc-site-functionality' ); ?>" />
            <input id="<?php echo $this->id; ?>_delete"
                    type="button"
                    class="image_delete_button button"
                    value="<?php _e( 'Remove Image', 'gpc-site-functionality' ); ?>" />
            <input id="<?php echo $this->id; ?>" class="gpc-field-image__value" type="hidden" name="<?php echo $this->get_field_name(); ?>" value="<?php echo $this->value; ?>"/>
        </div>
        <?php

        $html = ob_get_clean();

        return $html;
    }

    public function render_field_gallery()
    {
        $image_ids = [];
        if ( !empty( $this->value ) ) {
            $image_ids = maybe_unserialize($this->value);
        }

        ob_start(); ?>
        <div class="gpc-field-gallery">
            <ul class="gpc-field-gallery-selected">
            <?php foreach( $image_ids as $i => &$id ) :
                $url = wp_get_attachment_image_url( $id, 'thumbnail' );
                if( $url ) { ?>
                    <li class="gpc-field-gallery__item attachment" data-id="<?php echo $id; ?>">
                        <div class="gpc-field-gallery__preview attachment-preview">
                            <div class="thumbnail">
                                <img src="<?php echo $url; ?>">
                            </div>
                        </div>
                        <button type="button" class="button-link attachment-close media-modal-icon gpc-field-gallery__remove">
                            <span class="screen-reader-text">Xóa bỏ</span>
                        </button>
                    </li>
                <?php } else {
                    unset( $image_ids[ $i ] );
                }
            endforeach; ?>
            </ul>
            <input type="hidden" class="gpc-field-gallery__value" name="<?php echo $this->get_field_name(); ?>" value="<?php echo join( ',', $image_ids ); ?>" />
            <a href="#" class="button gpc-field-gallery-upload-button">Add Images</a>
        </div>

        <?php
        $html = ob_get_clean();
        return $html;
    }

    public function sanitize($value)
    {
        if ( $this->is_multiple && !empty($value) ) {
            $value = array_map('intval', explode(',', $value));
        }

        return $value;
    }
}