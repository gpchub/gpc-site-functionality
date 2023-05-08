<?php
/**
 * Plugin Name: Catsky Functionality
 * Version: 1.0.0
 * Plugin URI: http://giaiphapclinic.com/
 * Description: Các chức năng cho trang web Catsky (custom post type,...).
 * Author: GPC Team
 * Author URI: http://giaiphapclinic.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: gpc-site-functionality
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author GPC Team
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GPC_SITE_PLUGIN_NAME', 'gpc-site-functionality' ); // Nhớ cập nhật tên này ở uninstall.phhp
define( 'GPC_SITE_PLUGIN_VERSION', '1.0.0' );
define( 'GPC_SITE_PLUGIN_FILE', __FILE__ );
define( 'GPC_SITE_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'GPC_SITE_PLUGIN_ASSETS_DIR', trailingslashit( GPC_SITE_PLUGIN_DIR ) . 'assets') ;
define( 'GPC_SITE_PLUGIN_ASSETS_URL', esc_url( trailingslashit( plugins_url( '/assets/', __FILE__) ) ) );

require_once( __DIR__ . '/autoloader.php' );
Gizmo_Autoloader::register();

function catsky_functionality() {
	$instance = GpcSiteFunctionality\Plugin::instance();
	return $instance;
}

catsky_functionality();
