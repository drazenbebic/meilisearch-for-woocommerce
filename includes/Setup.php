<?php

namespace MeilisearchForWooCommerce;

use Exception;

defined( 'ABSPATH' ) || exit;

class Setup {

	/**
	 * Activation script
	 *
	 * @return void
	 * @throws Exception
	 */
	public static function activate() {
		self::check_requirements();
		self::set_default_settings();
	}

	/**
	 * Checks if all required plugin components are present.
	 *
	 * @throws Exception
	 */
	private static function check_requirements() {
		if ( version_compare( phpversion(), '7.3.33', '<=' ) ) {
			throw new Exception( __( 'PHP 7.3 or lower detected. Meilisearch for WooCommerce requires PHP 7.4 or greater.', 'meilisearch-for-woocommerce' ) );
		}

		if ( ! Dependencies::is_woocommerce_active() ) {
			throw new Exception( __( 'WooCommerce must be installed and activated to use this plugin.', 'meilisearch-for-woocommerce' ) );
		}
	}

	/**
	 * Set the default plugin options.
	 */
	private static function set_default_settings() {
		// Only update user settings if they don't exist already
		foreach ( self::get_default_settings() as $option_name => $option_value ) {
			if ( ! get_option( $option_name, false ) ) {
				update_option( $option_name, $option_value );
			}
		}
	}

	/**
	 * Returns an associative array of the default plugin settings. The key
	 * represents the setting group, and the value the individual settings
	 * fields with their corresponding values.
	 *
	 * @return array
	 */
	private static function get_default_settings(): array {
		return apply_filters( 'msfwc_default_settings', array(
			'msfwc_setting_sync_on_product_edit' => 'yes',
		) );
	}

	/**
	 * Deactivation script.
	 *
	 * @return void
	 */
	public static function deactivate() {

	}

	/**
	 * Uninstallation script.
	 *
	 * @return void
	 */
	public static function uninstall() {
	}
}