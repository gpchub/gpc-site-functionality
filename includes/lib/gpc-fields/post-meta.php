<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Post_Meta
{
    protected $id;
    protected $title;
    protected $post_types;
    protected $priority = 'default'; //'high', 'core', 'default', or 'low'
    protected $context = 'advanced'; //'advanced' or 'side';
    /**
     * List of fields
     *
     * @var Field[]
     */
    protected $fields;

    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function set_priority( $priority )
    {
        $this->priority = $priority;
        return $this;
    }

    public function set_context( $context )
    {
        $this->context = $context;
        return $this;
    }

    public function where( $post_types )
    {
        if ( !is_array($post_types) ) {
            $post_types = [ $post_types ];
        }

        $this->post_types = $post_types;

        if ( is_admin() ) {
            add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
            add_action( 'save_post', [ $this, 'save_postdata' ] );
        }

        return $this;
    }

    public function add_fields( $fields = [] )
    {
        $this->fields = $fields;
        return $this;
    }

    public function add_meta_boxes()
    {
        $screens = $this->post_types;
		foreach ( $screens as $screen ) {
			add_meta_box(
				$this->id, // Unique ID
				$this->title, // Box title
				[ $this, 'metabox_html' ], // Content callback, must be of type callable
				$screen, // Post type
                $this->context,
                $this->priority
			);
		}
    }

    public function metabox_html( $post )
    {
        if ( ! is_array( $this->fields ) || 0 === count( $this->fields ) ) {
			return;
		}

        echo '<div class="custom-field-panel">' . "\n";

		foreach ( $this->fields as $field ) {

            $value = get_post_meta( $post->ID, $field->id, true );
            $field->set_value($value);

            ?>
            <div class="form-field">
                <label for="<?php echo $field->id; ?>"><?php echo $field->label; ?></label>
                <div class="form-control <?php echo 'gpc-field-' . $field->type . '-wrapper'; ?>">
                    <?php echo $field->render(); ?>
                </div>
            </div>
            <?php
		}

		echo '</div>' . "\n";
    }

    public function save_postdata( $post_id )
    {
        if ( ! is_array( $this->fields ) || 0 === count( $this->fields ) ) {
			return;
		}

		foreach ( $this->fields as $field ) {
			if ( isset( $_REQUEST[ $field->id ] )  && '' !==  $_REQUEST[ $field->id ] ) {
				update_post_meta( $post_id, $field->id, $field->sanitize( $_REQUEST[ $field->id ] ) );
			} else {
				delete_post_meta( $post_id, $field->id );
			}
		}
    }
}