<?php

namespace MeilisearchForWooCommerce;

defined( 'ABSPATH' ) || exit;

final class Plugin {

	/**
	 * @var Plugin|null
	 */
	protected static $instance = null;

	private function __construct() {
		$this->constants();
		$this->hooks();
	}


	/**
	 * Ensures only one instance of MeilisearchForWooCommerce is loaded at any
	 * time.
	 *
	 * @return Plugin
	 */
	public static function instance() {
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function constants() {
		if ( ! defined( 'ABSPATH_LENGTH' ) ) {
			define( 'ABSPATH_LENGTH', strlen( ABSPATH ) );
		}
	}

	private function hooks() {
		register_activation_hook(
			MSFWC_PLUGIN_FILE,
			array('\MeilisearchForWooCommerce\Setup', 'activate')
		);

		register_deactivation_hook(
			MSFWC_PLUGIN_FILE,
			array('\MeilisearchForWooCommerce\Setup', 'deactivate')
		);

		register_uninstall_hook(
			MSFWC_PLUGIN_FILE,
			array('\MeilisearchForWooCommerce\Setup', 'uninstall')
		);
	}
}