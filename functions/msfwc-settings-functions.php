<?php

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