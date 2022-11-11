<?php

namespace MeilisearchForWooCommerce\Integrations\WooCommerce;

defined( 'ABSPATH' ) || exit;

class Settings {

	public function __construct() {
		add_filter( 'woocommerce_settings_tabs_array', array(
			$this,
			'settings_tabs_array'
		), 30 );
		add_filter( 'woocommerce_settings_tabs_meilisearch', array(
			$this,
			'settings_tabs_meilisearch'
		) );
		add_action( 'woocommerce_update_options_meilisearch', array(
			$this,
			'update_options_meilisearch'
		) );
	}

	/**
	 * Adds the "Meilisearch" tab to the WooCommerce settings.
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	public function settings_tabs_array( array $tabs ): array {
		return msfwc_array_insert_after(
			'integration',
			$tabs,
			'meilisearch',
			__( 'Meilisearch', 'meilisearch-for-woocommerce' )
		);
	}

	/**
	 * Adds the plugin settings to the "Meilisearch" tab inside of WooCommerce's
	 * Settings page.
	 */
	public function settings_tabs_meilisearch() {
		woocommerce_admin_fields( $this->get_settings() );
	}

	private function get_settings(): array {
		return apply_filters( 'msfwc_settings_tab_meilisearch', array(
			'product_sync'             => array(
				'id'   => 'msfwc_setting_product_sync_title',
				'name' => __( 'Product synchronization', 'meilisearch-for-woocommerce' ),
				'type' => 'title',
				'desc' => __( 'Define plugin behavior specific to product synchronization.', 'meilisearch-for-woocommerce' )
			),
			'sync_on_product_change'   => array(
				'id'   => 'msfwc_setting_meilisearch_sync_on_product_change',
				'name' => __( 'Keep products in sync', 'meilisearch-for-woocommerce' ),
				'type' => 'checkbox',
				'desc' => __( 'Update the Meilisearch document when the product updates.', 'meilisearch-for-woocommerce' ),
			),
			'product_sync_section_end' => array(
				'id'   => 'msfwc_setting_product_sync_sectionend',
				'type' => 'sectionend',
			),
		) );
	}

	/**
	 * Updates the plugin's settings.
	 */
	public function update_options_meilisearch() {
		woocommerce_update_options( $this->get_settings() );
	}

}