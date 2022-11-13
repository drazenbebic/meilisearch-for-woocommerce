<?php

namespace MeilisearchForWooCommerce;

defined( 'ABSPATH' ) || exit;

class Dependencies {

	/**
	 * @var array|null
	 */
	private static ?array $active_plugins = null;

	/**
	 * Initializes the active plugins
	 */
	public static function init(): void {
		self::$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			self::$active_plugins = array_merge(
				self::$active_plugins,
				get_site_option( 'active_sitewide_plugins', array() )
			);
		}
	}

	/**
	 * Identifies whether the given plugin is active. Uses the `active_plugins`
	 * option.
	 *
	 * @param string $plugin
	 *
	 * @return bool
	 */
	private static function is_plugin_active( string $plugin ): bool {
		if ( ! self::$active_plugins ) {
			self::init();
		}

		return in_array( $plugin, self::$active_plugins ) || array_key_exists( $plugin, self::$active_plugins );
	}

	/**
	 * Identifies whether WooCommerce is active.
	 *
	 * @return bool
	 */
	public static function is_woocommerce_active(): bool {
		return self::is_plugin_active( 'woocommerce/woocommerce.php' );
	}


	/**
	 * Identifies whether WooCommerce Subscriptions is active.
	 *
	 * @return bool
	 */
	public static function is_woocommerce_subscriptions_active(): bool {
		return self::is_plugin_active( 'woocommerce-subscriptions/woocommerce-subscriptions.php' );
	}
}