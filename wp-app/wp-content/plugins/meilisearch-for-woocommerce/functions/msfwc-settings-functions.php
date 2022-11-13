<?php

use MeilisearchForWooCommerce\Setup;

/**
 * Returns the Meilisearch instance URL.
 *
 * @return string|null
 */
function msfwc_get_meilisearch_instance_url(): ?string {
	return get_option( 'msfwc_setting_meilisearch_instance_url', null );
}

/**
 * Returns the Meilisearch instance API key.
 *
 * @return string|null
 */
function msfwc_get_meilisearch_instance_api_key(): ?string {
	return get_option( 'msfwc_setting_meilisearch_instance_api_key', null );
}

/**
 * Returns the Meilisearch products index name.
 *
 * @return string
 */
function msfwc_get_product_index_name(): string {
	return get_option( 'msfwc_setting_index_products', Setup::PRODUCTS_INDEX_DEFAULT );
}

/**
 * Returns a bool on whether the Meilisearch instance is fully configured.
 *
 * @return bool
 */
function msfwc_is_meilisearch_instance_configured(): bool {
	return msfwc_get_meilisearch_instance_url() && msfwc_get_meilisearch_instance_api_key();
}

/**
 * Returns a bool for whether a product should be synced when it's created.
 *
 * @return bool
 */
function msfwc_product_sync_on_create(): bool {
	return get_option( 'msfwc_setting_product_sync_on_create', false ) === 'yes';
}

/**
 * Returns a bool for whether a product should be synced when it's updated.
 *
 * @return bool
 */
function msfwc_product_sync_on_update(): bool {
	return get_option( 'msfwc_setting_product_sync_on_update', false ) === 'yes';
}

/**
 *
 * Returns a bool for whether a product should be synced when it's deleted.
 *
 * @return bool
 */
function msfwc_product_sync_on_delete(): bool {
	return get_option( 'msfwc_setting_product_sync_on_delete', false ) === 'yes';
}

/**
 * Returns a list of product properties to keep in sync with Meilisearch.
 *
 * @return array
 */
function msfwc_get_product_sync_fields(): array {
	return get_option( 'msfwc_product_sync_fields', array(
		array(
			'type'  => 'property',
			'value' => 'id'
		),
		array(
			'type'  => 'property',
			'value' => 'name'
		),
		array(
			'type'  => 'property',
			'value' => 'slug'
		),
		array(
			'type'  => 'property',
			'value' => 'sku'
		),
		array(
			'type'  => 'price',
			'value' => 'regular_price'
		),
		array(
			'type'  => 'price',
			'value' => 'sale_price'
		),
		array(
			'type' => 'image'
		)
	) );
}