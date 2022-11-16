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
		return meili_array_insert_after(
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
		return apply_filters( 'meili_settings_tab_meilisearch', array(
			// meilisearch_instance
			'meilisearch_instance'             => array(
				'id'   => 'meili_setting_meilisearch_instance_title',
				'name' => __( 'Meilisearch instance', 'meilisearch-for-woocommerce' ),
				'type' => 'title',
				'desc' => __( 'Provide the URL and API key of your Meilisearch instance.', 'meilisearch-for-woocommerce' )
			),
			'url'                              => array(
				'id'       => 'meili_setting_meilisearch_instance_url',
				'name'     => __( 'URL', 'meilisearch-for-woocommerce' ),
				'type'     => 'text',
				'desc'     => __( 'URL of your Meilisearch instance, without a trailing slash.', 'meilisearch-for-woocommerce' ),
				'desc_tip' => 'Example: https://meilisearch.example.com'
			),
			'api_key'                          => array(
				'id'   => 'meili_setting_meilisearch_instance_api_key',
				'name' => __( 'API Key', 'meilisearch-for-woocommerce' ),
				'type' => 'password',
				'desc' => __( 'API key of your Meilisearch instance.', 'meilisearch-for-woocommerce' ),
			),
			'meilisearch_instance_section_end' => array(
				'id'   => 'meili_setting_meilisearch_instance_sectionend',
				'type' => 'sectionend',
			),
			// indexes
			'index'                            => array(
				'id'   => 'meili_setting_index_title',
				'name' => __( 'Indexes', 'meilisearch-for-woocommerce' ),
				'type' => 'title',
				'desc' => __( 'Define the names of your Meilisearch indexes', 'meilisearch-for-woocommerce' )
			),
			'products'                         => array(
				'id'   => 'meili_setting_index_products',
				'name' => __( 'Products', 'meilisearch-for-woocommerce' ),
				'type' => 'text',
				'desc' => __( 'Name of the index containing the product data.', 'meilisearch-for-woocommerce' )
			),
			'index_section_end'                => array(
				'id'   => 'meili_setting_index_sectionend',
				'type' => 'sectionend',
			),
			// index_update
			'index_update'                     => array(
				'id'   => 'meili_setting_index_update_title',
				'name' => __( 'Index update behavior', 'meilisearch-for-woocommerce' ),
				'type' => 'title',
				'desc' => __( 'These settings define how the plugin will keep the product data synchronized with Meilisearch.', 'meilisearch-for-woocommerce' )
			),
			'on_create'                        => array(
				'id'   => 'meili_setting_index_update_on_create',
				'name' => __( 'When a product is created', 'meilisearch-for-woocommerce' ),
				'type' => 'checkbox',
				'desc' => __( 'Create a Meilisearch document when new a product has been created.', 'meilisearch-for-woocommerce' ),
			),
			'on_update'                        => array(
				'id'   => 'meili_setting_index_update_on_update',
				'name' => __( 'When a product is updated', 'meilisearch-for-woocommerce' ),
				'type' => 'checkbox',
				'desc' => __( 'Update the Meilisearch document when the corresponding product has been updated.', 'meilisearch-for-woocommerce' ),
			),
			'on_delete'                        => array(
				'id'   => 'meili_setting_index_update_on_delete',
				'name' => __( 'When a product is deleted', 'meilisearch-for-woocommerce' ),
				'type' => 'checkbox',
				'desc' => __( 'Delete the Meilisearch document when the corresponding product has been deleted.', 'meilisearch-for-woocommerce' ),
			),
			'index_update_section_end'         => array(
				'id'   => 'meili_setting_index_update_sectionend',
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