<?php

defined( 'ABSPATH' ) || exit;

/**
 * Returns a single document from Meilisearch
 *
 * @param int           $id     The document ID
 * @param string[]|null $fields Optional: Fields to return. Returns all fields if omitted
 *
 * @return array|WP_Error
 */
function meili_product_get( int $id, ?array $fields ) {
	return meili_document_get( meili_get_product_index_name(), $id, $fields );
}

/**
 * Returns multiple documents from Meilisearch
 *
 * @param int|null      $limit  Optional: Number of documents which will be returned
 * @param int|null      $offset Optional: Offset from which the documents will be returned
 * @param string[]|null $fields Optional: Fields to return. Returns all fields if omitted
 *
 * @return array|WP_Error
 */
function meili_products_get(
	?int $limit = null,
	?int $offset = null,
	?array $fields = array()
) {
	return meili_documents_get(
		meili_get_product_index_name(),
		$limit,
		$offset,
		$fields
	);
}

/**
 * Updates an existing or creates a new Meilisearch document.
 *
 * @param WC_Product|int $the_product WooCommerce product or product ID.
 *
 * @return array|WP_Error
 */
function meili_product_upsert( $the_product ) {
	$product = wc_get_product( $the_product );
	$data    = meili_map_product_fields( $product );

	return meili_document_upsert( meili_get_product_index_name(), $data );
}

/**
 * Deletes all Meilisearch documents from the products index.
 *
 * @return array|WP_Error
 */
function meili_products_delete_all() {
	return meili_documents_delete_all( meili_get_product_index_name() );
}