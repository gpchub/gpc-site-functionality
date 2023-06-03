<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Term_Meta
{
    protected $id;
    protected $title;
    protected $taxonomy;
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

    public function where( $taxonomy )
    {
        if ( !is_array($taxonomy) ) {
            $taxonomy = [ $taxonomy ];
        }

        $this->taxonomy = $taxonomy;

        if ( is_admin() ) {
            foreach ( $this->taxonomy as $tax ) {
                add_action( $tax . '_add_form_fields', [ $this, 'render_add_form_fields' ] );
                add_action( $tax . '_edit_form_fields', [ $this, 'render_edit_form_fields' ], 12 );

                add_action( 'created_' . $tax, [ $this, 'save_term_fields' ] );
                add_action( 'edited_' . $tax, [ $this, 'save_term_fields' ] );
            }
        }

        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_script' ], 100, 1 );

        return $this;
    }

    public function enqueue_admin_script()
    {
        $current_screen = get_current_screen();
        if ( $current_screen->base == 'edit-tags' && in_array( $current_screen->taxonomy, $this->taxonomy ) ) {
            wp_register_script( 'gpc-term-meta', esc_url( GPC_SITE_PLUGIN_ASSETS_URL ) . 'js/custom-fields-edit-tags.js', array( 'jquery' ), GPC_SITE_PLUGIN_VERSION, true );
            wp_enqueue_script( 'gpc-term-meta' );
        }
    }

    public function add_fields( $fields = [] )
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * Thêm fields vào form add term
     */
    public function render_add_form_fields()
    {
        ?>
        <h2 style="font-size: 20px; font-weight: bold;"><?php echo $this->title; ?></h2>
        <?php
        foreach ( $this->fields as $field ) : ?>
        <div class="form-field">
			<label for="<?php echo $field->id; ?>"><?php echo $field->label; ?></label>
			<?php echo $field->render(); ?>
		</div>
        <?php endforeach;
    }

    /**
     * Thêm fields vào form edit term
     */
    public function render_edit_form_fields( $term )
    {
        ?>
        <tr class="form-field">
            <th colspan="2"><h2><?php echo $this->title; ?></h2></th>
        </tr>
        <?php
        foreach ( $this->fields as $field ) :
            $field->value = get_term_meta( $term->term_id, $field->id, true );
        ?>
        <tr class="form-field">
            <th><label for="<?php echo $field->id; ?>"><?php echo $field->label; ?></label></th>
            <td>
                <?php echo $field->render(); ?>
            </td>
        </tr>
        <?php endforeach;
    }

    public function save_term_fields( $term_id )
    {
        if ( ! is_array( $this->fields ) || 0 === count( $this->fields ) ) {
			return;
		}

		foreach ( $this->fields as $field ) {
			if ( isset( $_REQUEST[ $field->id ] ) && '' !==  $_REQUEST[ $field->id ] ) {
				update_term_meta( $term_id, $field->id, $field->sanitize( $_REQUEST[ $field->id ] ) );
			} else {
				delete_term_meta( $term_id, $field->id );
			}
		}
    }
}