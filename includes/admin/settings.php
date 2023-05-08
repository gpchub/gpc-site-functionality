<?php
/**
 * Settings class file.
 *
 * @package WordPress Plugin Template/Settings
 */

namespace GpcSiteFunctionality\Admin;

use GpcSiteFunctionality\Lib\Admin_Api;
use GpcSiteFunctionality\Trait\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings class.
 */
class Settings {

	use Singleton;

	/**
	 * Admin Api
	 *
	 * @var Admin_Api
	 */
	public $admin_api = null;

	/**
	 * Available settings for plugin.
	 *
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = array();

	public function __construct()
	{
		$this->admin_api = Admin_Api::instance();

		// Initialise settings.
		add_action( 'init', array( $this, 'init_settings' ), 11 );

		// Add settings page to menu.
		add_action( 'admin_menu', array( $this, 'add_menu_item' ) );

		// Register plugin settings.
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// Add settings link to plugins page.
		add_filter(
			'plugin_action_links_' . plugin_basename( GPC_SITE_PLUGIN_FILE ),
			array(
				$this,
				'add_settings_link',
			)
		);
	}

	/**
	 * Initialise settings
	 *
	 * @return void
	 */
	public function init_settings() {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Add settings page to admin menu
	 *
	 * @return void
	 */
	public function add_menu_item() {

		$args = $this->menu_settings();

		// Do nothing if wrong location key is set.
		if ( is_array( $args ) && isset( $args['location'] ) && function_exists( 'add_' . $args['location'] . '_page' ) ) {
			switch ( $args['location'] ) {
				case 'options':
				case 'submenu':
					$page = add_submenu_page( $args['parent_slug'], $args['page_title'], $args['menu_title'], $args['capability'], $args['menu_slug'], $args['function'] );
					break;
				case 'menu':
					$page = add_menu_page( $args['page_title'], $args['menu_title'], $args['capability'], $args['menu_slug'], $args['function'], $args['icon_url'], $args['position'] );
					break;
				default:
					return;
			}
			add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
		}
	}

	/**
	 * Prepare default settings page arguments
	 *
	 * @return mixed|void
	 */
	private function menu_settings() {
		return apply_filters(
			GPC_SITE_PLUGIN_NAME . '_menu_settings',
			array(
				'location'    => 'options', // Possible settings: options, menu, submenu.
				'parent_slug' => 'options-general.php',
				'page_title'  => get_bloginfo('name') . ' settings',
				'menu_title'  => get_bloginfo('name') . ' settings',
				'capability'  => 'manage_options',
				'menu_slug'   => GPC_SITE_PLUGIN_NAME . '_settings',
				'function'    => array( $this, 'settings_page' ),
				'icon_url'    => '',
				'position'    => null,
			)
		);
	}

	/**
	 * Load settings JS & CSS
	 *
	 * @return void
	 */
	public function settings_assets() {

		// We're including the farbtastic script & styles here because they're needed for the colour picker
		// If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below.
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_script( 'farbtastic' );

		// We're including the WP media scripts here because they're needed for the image upload field.
		// If you're not including an image upload then you can leave this function call out.
		wp_enqueue_media();

		wp_register_script( GPC_SITE_PLUGIN_NAME . '-settings-js', GPC_SITE_PLUGIN_ASSETS_URL . 'js/settings.js', array( 'farbtastic', 'jquery' ), '1.0.0', true );
		wp_enqueue_script( GPC_SITE_PLUGIN_NAME . '-settings-js' );
	}

	/**
	 * Add settings link to plugin list table
	 *
	 * @param  array $links Existing links.
	 * @return array        Modified links.
	 */
	public function add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=' . GPC_SITE_PLUGIN_NAME . '_settings">' . __( 'Settings', 'gpc-site-functionality' ) . '</a>';
		array_push( $links, $settings_link );
		return $links;
	}

	/**
	 * Build settings fields
	 *
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields() {

		$settings['standard'] = array(
			'title'       => __( 'Standard', 'gpc-site-functionality' ),
			'description' => __( 'These are fairly standard form input fields.', 'gpc-site-functionality' ),
			'fields'      => array(
				array(
					'id'          => 'text_field',
					'label'       => __( 'Some Text', 'gpc-site-functionality' ),
					'description' => __( 'This is a standard text field.', 'gpc-site-functionality' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Placeholder text', 'gpc-site-functionality' ),
				),
				array(
					'id'          => 'password_field',
					'label'       => __( 'A Password', 'gpc-site-functionality' ),
					'description' => __( 'This is a standard password field.', 'gpc-site-functionality' ),
					'type'        => 'password',
					'default'     => '',
					'placeholder' => __( 'Placeholder text', 'gpc-site-functionality' ),
				),
				array(
					'id'          => 'secret_text_field',
					'label'       => __( 'Some Secret Text', 'gpc-site-functionality' ),
					'description' => __( 'This is a secret text field - any data saved here will not be displayed after the page has reloaded, but it will be saved.', 'gpc-site-functionality' ),
					'type'        => 'text_secret',
					'default'     => '',
					'placeholder' => __( 'Placeholder text', 'gpc-site-functionality' ),
				),
				array(
					'id'          => 'text_block',
					'label'       => __( 'A Text Block', 'gpc-site-functionality' ),
					'description' => __( 'This is a standard text area.', 'gpc-site-functionality' ),
					'type'        => 'textarea',
					'default'     => '',
					'placeholder' => __( 'Placeholder text for this textarea', 'gpc-site-functionality' ),
				),
				array(
					'id'          => 'single_checkbox',
					'label'       => __( 'An Option', 'gpc-site-functionality' ),
					'description' => __( 'A standard checkbox - if you save this option as checked then it will store the option as \'on\', otherwise it will be an empty string.', 'gpc-site-functionality' ),
					'type'        => 'checkbox',
					'default'     => '',
				),
				array(
					'id'          => 'select_box',
					'label'       => __( 'A Select Box', 'gpc-site-functionality' ),
					'description' => __( 'A standard select box.', 'gpc-site-functionality' ),
					'type'        => 'select',
					'options'     => array(
						'drupal'    => 'Drupal',
						'joomla'    => 'Joomla',
						'wordpress' => 'WordPress',
					),
					'default'     => 'wordpress',
				),
				array(
					'id'          => 'radio_buttons',
					'label'       => __( 'Some Options', 'gpc-site-functionality' ),
					'description' => __( 'A standard set of radio buttons.', 'gpc-site-functionality' ),
					'type'        => 'radio',
					'options'     => array(
						'superman' => 'Superman',
						'batman'   => 'Batman',
						'ironman'  => 'Iron Man',
					),
					'default'     => 'batman',
				),
				array(
					'id'          => 'multiple_checkboxes',
					'label'       => __( 'Some Items', 'gpc-site-functionality' ),
					'description' => __( 'You can select multiple items and they will be stored as an array.', 'gpc-site-functionality' ),
					'type'        => 'checkbox_multi',
					'options'     => array(
						'square'    => 'Square',
						'circle'    => 'Circle',
						'rectangle' => 'Rectangle',
						'triangle'  => 'Triangle',
					),
					'default'     => array( 'circle', 'triangle' ),
				),
			),
		);

		$settings['extra'] = array(
			'title'       => __( 'Extra', 'gpc-site-functionality' ),
			'description' => __( 'These are some extra input fields that maybe aren\'t as common as the others.', 'gpc-site-functionality' ),
			'fields'      => array(
				array(
					'id'          => 'number_field',
					'label'       => __( 'A Number', 'gpc-site-functionality' ),
					'description' => __( 'This is a standard number field - if this field contains anything other than numbers then the form will not be submitted.', 'gpc-site-functionality' ),
					'type'        => 'number',
					'default'     => '',
					'placeholder' => __( '42', 'gpc-site-functionality' ),
				),
				array(
					'id'          => 'colour_picker',
					'label'       => __( 'Pick a colour', 'gpc-site-functionality' ),
					'description' => __( 'This uses WordPress\' built-in colour picker - the option is stored as the colour\'s hex code.', 'gpc-site-functionality' ),
					'type'        => 'color',
					'default'     => '#21759B',
				),
				array(
					'id'          => 'an_image',
					'label'       => __( 'An Image', 'gpc-site-functionality' ),
					'description' => __( 'This will upload an image to your media library and store the attachment ID in the option field. Once you have uploaded an imge the thumbnail will display above these buttons.', 'gpc-site-functionality' ),
					'type'        => 'image',
					'default'     => '',
					'placeholder' => '',
				),
				array(
					'id'          => 'multi_select_box',
					'label'       => __( 'A Multi-Select Box', 'gpc-site-functionality' ),
					'description' => __( 'A standard multi-select box - the saved data is stored as an array.', 'gpc-site-functionality' ),
					'type'        => 'select_multi',
					'options'     => array(
						'linux'   => 'Linux',
						'mac'     => 'Mac',
						'windows' => 'Windows',
					),
					'default'     => array( 'linux' ),
				),
			),
		);

		$settings = apply_filters( GPC_SITE_PLUGIN_NAME . '_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Register plugin settings
	 *
	 * @return void
	 */
	public function register_settings() {
		if ( is_array( $this->settings ) ) {

			// Check posted/selected tab.
			//phpcs:disable
			$current_section = '';
			if ( isset( $_POST['tab'] ) && $_POST['tab'] ) {
				$current_section = $_POST['tab'];
			} else {
				if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
					$current_section = $_GET['tab'];
				}
			}
			//phpcs:enable

			foreach ( $this->settings as $section => $data ) {

				if ( $current_section && $current_section !== $section ) {
					continue;
				}

				// Add section to page.
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), GPC_SITE_PLUGIN_NAME . '_settings' );

				foreach ( $data['fields'] as $field ) {

					// Validation callback for field.
					$validation = '';
					if ( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field.
					$option_name = GPC_SITE_PLUGIN_NAME . '_' . $field['id'];
					register_setting( GPC_SITE_PLUGIN_NAME . '_settings', $option_name, $validation );

					// Add field to page.
					add_settings_field(
						$field['id'],
						$field['label'],
						array( $this->admin_api, 'display_field' ),
						GPC_SITE_PLUGIN_NAME . '_settings',
						$section,
						array(
							'field'  => $field,
							'prefix' => GPC_SITE_PLUGIN_NAME . '_',
						)
					);
				}

				if ( ! $current_section ) {
					break;
				}
			}
		}
	}

	/**
	 * Settings section.
	 *
	 * @param array $section Array of section ids.
	 * @return void
	 */
	public function settings_section( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html; //phpcs:ignore
	}

	/**
	 * Load settings page content.
	 *
	 * @return void
	 */
	public function settings_page() {

		// Build page HTML.
		$html      = '<div class="wrap" id="' . GPC_SITE_PLUGIN_NAME . '_settings">' . "\n";
			$html .= '<h2>' . get_bloginfo('name') . ' Settings' . '</h2>' . "\n";

			$tab = '';
		//phpcs:disable
		if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
			$tab .= $_GET['tab'];
		}
		//phpcs:enable

		// Show page tabs.
		if ( is_array( $this->settings ) && 1 < count( $this->settings ) ) {

			$html .= '<h2 class="nav-tab-wrapper">' . "\n";

			$c = 0;
			foreach ( $this->settings as $section => $data ) {

				// Set tab class.
				$class = 'nav-tab';
				if ( ! isset( $_GET['tab'] ) ) { //phpcs:ignore
					if ( 0 === $c ) {
						$class .= ' nav-tab-active';
					}
				} else {
					if ( isset( $_GET['tab'] ) && $section == $_GET['tab'] ) { //phpcs:ignore
						$class .= ' nav-tab-active';
					}
				}

				// Set tab link.
				$tab_link = add_query_arg( array( 'tab' => $section ) );
				if ( isset( $_GET['settings-updated'] ) ) { //phpcs:ignore
					$tab_link = remove_query_arg( 'settings-updated', $tab_link );
				}

				// Output tab.
				$html .= '<a href="' . $tab_link . '" class="' . esc_attr( $class ) . '">' . esc_html( $data['title'] ) . '</a>' . "\n";

				++$c;
			}

			$html .= '</h2>' . "\n";
		}

			$html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

				// Get settings fields.
				ob_start();
				settings_fields( GPC_SITE_PLUGIN_NAME . '_settings' );
				do_settings_sections( GPC_SITE_PLUGIN_NAME . '_settings' );
				$html .= ob_get_clean();

				$html     .= '<p class="submit">' . "\n";
					$html .= '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '" />' . "\n";
					$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings', 'gpc-site-functionality' ) ) . '" />' . "\n";
				$html     .= '</p>' . "\n";
			$html         .= '</form>' . "\n";
		$html             .= '</div>' . "\n";

		echo $html; //phpcs:ignore
	}
}
