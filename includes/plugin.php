<?php
/**
 * Main plugin class file.
 */

namespace GpcSiteFunctionality;

use GpcSiteFunctionality\Admin\Settings;
use GpcSiteFunctionality\Block_Editor\Block_Patterns;
use GpcSiteFunctionality\Post_Types\Comic;
use GpcSiteFunctionality\Post_Types\Pet;
use GpcSiteFunctionality\Post_Types\Project;
use GpcSiteFunctionality\Trait\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin
{
	use Singleton;

	public function __construct()
	{
		register_activation_hook( GPC_SITE_PLUGIN_FILE, array( $this, 'install' ) );

		$this->load_plugin_textdomain();

		$this->register_post_types();
		$this->load_admin();
		$this->load_public();
	}

	public function register_post_types()
	{
		Project::instance();
		Pet::instance();
		Comic::instance();
	}

	public function load_admin()
	{
		if ( is_admin() ) {
			Settings::instance();
		}

		// Load admin JS & CSS.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ), 10, 1 );
	}

	public function load_public()
	{
		Block_Patterns::instance();
	}

	public function admin_enqueue_styles( $hook = '' ) {
		wp_register_style( GPC_SITE_PLUGIN_NAME . '-admin', esc_url( GPC_SITE_PLUGIN_ASSETS_URL ) . 'css/admin.css', array(), GPC_SITE_PLUGIN_VERSION );
		wp_enqueue_style( GPC_SITE_PLUGIN_NAME . '-admin' );
	}

	public function admin_enqueue_scripts( $hook = '' ) {
		wp_register_script( GPC_SITE_PLUGIN_NAME . '-admin', esc_url( GPC_SITE_PLUGIN_ASSETS_URL ) . 'js/admin.js', array( 'jquery' ), GPC_SITE_PLUGIN_VERSION, true );
		wp_enqueue_script( GPC_SITE_PLUGIN_NAME . '-admin' );
	}

	public function load_plugin_textdomain()
	{
		$domain = GPC_SITE_PLUGIN_NAME;

		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, dirname( plugin_basename( GPC_SITE_PLUGIN_FILE ) ) . '/lang/' );
	}

	/**
	 * Installation. Runs on activation.
	 *
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	public function install()
	{
		$this->_log_version_number();
	}

	/**
	 * Log the plugin version number.
	 *
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	private function _log_version_number() //phpcs:ignore
	{
		update_option( GPC_SITE_PLUGIN_NAME . '_version', GPC_SITE_PLUGIN_VERSION );
	}
}
