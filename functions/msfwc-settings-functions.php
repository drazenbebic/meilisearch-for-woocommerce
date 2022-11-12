<?php

/**
 * Returns the setting for product downloads.
 *
 * @return bool
 */
function msfwc_sync_on_product_edit(): bool {
	return get_option( 'msfwc_setting_sync_on_product_edit', false ) === 'yes';
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
			'type'  => 'property',
			'value' => 'regular_price'
		),
		array(
			'type' => 'image'
		)
	) );
}