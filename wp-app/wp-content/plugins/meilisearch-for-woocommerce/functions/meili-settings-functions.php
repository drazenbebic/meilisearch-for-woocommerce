<?php

use MeilisearchForWooCommerce\Setup;

/**
 * Identifies whether a product should be skipped during the index update.
 *
 * @param int $product_id
 *
 * @return bool
 */
function meili_product_skip_on_update( int $product_id ): bool {
	return get_post_meta( $product_id, 'meili_skip_on_update', true ) === '1';
}

/**
 * Identifies whether a product should be skipped during index deletion.
 *
 * @param int $product_id
 *
 * @return bool
 */
function meili_product_skip_on_delete( int $product_id ): bool {
	return get_post_meta( $product_id, 'meili_skip_on_delete', true ) === '1';
}

/**
 * Returns the Meilisearch instance URL.
 *
 * @return string|null
 */
function meili_get_meilisearch_instance_url(): ?string {
	return get_option( 'meili_setting_meilisearch_instance_url', null );
}

/**
 * Returns the Meilisearch instance API key.
 *
 * @return string|null
 */
function meili_get_meilisearch_instance_api_key(): ?string {
	return get_option( 'meili_setting_meilisearch_instance_api_key', null );
}

/**
 * Returns the Meilisearch products index name.
 *
 * @return string
 */
function meili_get_product_index_name(): string {
	return get_option( 'meili_setting_index_products', Setup::PRODUCTS_INDEX_DEFAULT );
}

/**
 * Returns a bool on whether the Meilisearch instance is fully configured.
 *
 * @return bool
 */
function meili_is_meilisearch_instance_configured(): bool {
	return meili_get_meilisearch_instance_url() && meili_get_meilisearch_instance_api_key();
}

/**
 * Returns a bool for whether a product should be synced when it's created.
 *
 * @return bool
 */
function meili_product_sync_on_create(): bool {
	return get_option( 'meili_setting_product_sync_on_create', false ) === 'yes';
}

/**
 * Returns a bool for whether a product should be synced when it's updated.
 *
 * @return bool
 */
function meili_product_sync_on_update(): bool {
	return get_option( 'meili_setting_product_sync_on_update', false ) === 'yes';
}

/**
 *
 * Returns a bool for whether a product should be synced when it's deleted.
 *
 * @return bool
 */
function meili_product_sync_on_delete(): bool {
	return get_option( 'meili_setting_product_sync_on_delete', false ) === 'yes';
}

/**
 * Returns a list of product properties to keep in sync with Meilisearch.
 *
 * @return array
 */
function meili_get_product_sync_fields(): array {
	return get_option( 'meili_setting_product_sync_fields', array(
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