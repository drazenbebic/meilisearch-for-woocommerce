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

		define( 'MEILI_ABSPATH', dirname( MEILI_PLUGIN_FILE ) . '/' );
		define( 'MEILI_ASSETS_DIR', MEILI_ABSPATH . 'assets/' );
		define( 'MEILI_TEMPLATES_DIR', MEILI_ABSPATH . 'templates/' );
		define( 'MEILI_MIGRATIONS_DIR', MEILI_ABSPATH . 'migrations/' );
		define( 'MEILI_ASSETS_URL', MEILI_PLUGIN_URL . 'assets/' );
		define( 'MEILI_CSS_URL', MEILI_ASSETS_URL . 'css/' );
		define( 'MEILI_JS_URL', MEILI_ASSETS_URL . 'js/' );
		define( 'MEILI_IMG_URL', MEILI_ASSETS_URL . 'img/' );
		define( 'MEILI_ADMIN_CSS_URL', MEILI_ASSETS_URL . 'admin/css/' );
		define( 'MEILI_ADMIN_JS_URL', MEILI_ASSETS_URL . 'admin/js/' );
		define( 'MEILI_ADMIN_IMG_URL', MEILI_ASSETS_URL . 'admin/img/' );
	}

	private function hooks() {
		register_activation_hook(
			MEILI_PLUGIN_FILE,
			array( '\MeilisearchForWooCommerce\Setup', 'activate' )
		);

		register_deactivation_hook(
			MEILI_PLUGIN_FILE,
			array( '\MeilisearchForWooCommerce\Setup', 'deactivate' )
		);

		register_uninstall_hook(
			MEILI_PLUGIN_FILE,
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