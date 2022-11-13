<?php
/**
 * Plugin Name: Meilisearch for WooCommerce
 * Plugin URI: “https://msfwc.bebic.at/
 * Description: Enterprise level search engine directly integrated into WooCommerce
 * Version: 1.0.0
 * Author: drazenbebic
 * Author URI: https://msfwc.bebic.at/
 * Requires at least: 4.7
 * Tested up to: 5.9.2
 * Requires PHP: 7.4
 * WC requires at least: 2.7
 * WC tested up to: 6.3.1
 */

use MeilisearchForWooCommerce\Plugin;

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/functions/autoload.php';

if ( ! defined( 'MSFWC_VERSION' ) ) {
	define( 'MSFWC_VERSION', '1.0.0' );
}

if ( ! defined( 'MSFWC_PLUGIN_FILE' ) ) {
	define( 'MSFWC_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'MSFWC_PLUGIN_DIR' ) ) {
	define( 'MSFWC_PLUGIN_DIR', __DIR__ );
}

if ( ! defined( 'MSFWC_PLUGIN_URL' ) ) {
	define( 'MSFWC_PLUGIN_URL', plugins_url( '', __FILE__ ) . '/' );
}

function meili(): ?Plugin {
	return Plugin::instance();
}

// Global for backwards compatibility
$GLOBALS['msfwc'] = meili();