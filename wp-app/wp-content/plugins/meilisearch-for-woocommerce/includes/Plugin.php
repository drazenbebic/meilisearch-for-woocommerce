<?php

namespace MeilisearchForWooCommerce;

defined( 'ABSPATH' ) || exit;

final class Plugin {

	/**
	 * @var Plugin|null
	 */
	protected static ?Plugin $instance = null;

	/**
	 * @var MeilisearchApi|null
	 */
	protected static ?MeilisearchApi $api = null;

	private function __construct() {
		$this->constants();
		$this->hooks();

		add_action( 'init', array( $this, 'init' ) );
	}

	private function constants() {
		if ( ! defined( 'ABSPATH_LENGTH' ) ) {
			define( 'ABSPATH_LENGTH', strlen( ABSPATH ) );
		}

		define( 'MSFWC_ABSPATH', dirname( MSFWC_PLUGIN_FILE ) . 'Plugin.php/' );
		define( 'MSFWC_ASSETS_DIR', MSFWC_ABSPATH . 'assets/' );
		define( 'MSFWC_TEMPLATES_DIR', MSFWC_ABSPATH . 'templates/' );
		define( 'MSFWC_MIGRATIONS_DIR', MSFWC_ABSPATH . 'migrations/' );
		define( 'MSFWC_ASSETS_URL', MSFWC_PLUGIN_URL . 'assets/' );
		define( 'MSFWC_CSS_URL', MSFWC_ASSETS_URL . 'css/' );
		define( 'MSFWC_JS_URL', MSFWC_ASSETS_URL . 'js/' );
		define( 'MSFWC_IMG_URL', MSFWC_ASSETS_URL . 'img/' );
		define( 'MSFWC_ADMIN_CSS_URL', MSFWC_ASSETS_URL . 'admin/css/' );
		define( 'MSFWC_ADMIN_JS_URL', MSFWC_ASSETS_URL . 'admin/js/' );
		define( 'MSFWC_ADMIN_IMG_URL', MSFWC_ASSETS_URL . 'admin/img/' );
	}

	private function hooks() {
		register_activation_hook(
			MSFWC_PLUGIN_FILE,
			array( '\MeilisearchForWooCommerce\Setup', 'activate' )
		);

		register_deactivation_hook(
			MSFWC_PLUGIN_FILE,
			array( '\MeilisearchForWooCommerce\Setup', 'deactivate' )
		);

		register_uninstall_hook(
			MSFWC_PLUGIN_FILE,
			array( '\MeilisearchForWooCommerce\Setup', 'uninstall' )
		);
	}

	/**
	 * Ensures only one instance of MeilisearchForWooCommerce is loaded at any
	 * time.
	 *
	 * @return Plugin
	 */
	public static function instance(): ?Plugin {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function init() {
		new Admin\Assets();
		new Admin\Controller();

		if ( Dependencies::is_woocommerce_active() ) {
			new Integrations\WooCommerce();
		}
	}

	public function api(): MeilisearchApi {
		if ( self::$api === null ) {
			self::$api = new MeilisearchApi();
		}

		return self::$api;
	}
}