<?php

defined( 'ABSPATH' ) || exit;

/**
 * Returns a single document from Meilisearch
 *
 * @param string        $index  Meilisearch index
 * @param int           $id     The document ID
 * @param string[]|null $fields Optional: Fields to return. Returns all fields if omitted
 *
 * @return array|WP_Error
 */
function meili_document_get( string $index, int $id, ?array $fields ) {
	return meili()->api()->get_document( $index, $id, $fields );
}

/**
 * Returns multiple documents from Meilisearch
 *
 * @param string        $index  Meilisearch index
 * @param int|null      $limit  Optional: Number of documents which will be returned
 * @param int|null      $offset Optional: Offset from which the documents will be returned
 * @param string[]|null $fields Optional: Fields to return. Returns all fields if omitted
 *
 * @return array|WP_Error
 */
function meili_documents_get(
	string $index,
	?int $limit = null,
	?int $offset = null,
	?array $fields = array()
) {
	return meili()->api()->get_documents( $index, $limit, $offset, $fields );
}

/**
 * Updates an existing or creates a new Meilisearch document.
 *
 * @param string $index Meilisearch index
 * @param array  $data  Key/Value pairs containing the document data.
 *
 * @return array|WP_Error
 */
function meili_document_upsert( string $index, array $data ) {
	return meili()->api()->upsert_documents( $index, $data );
}

/**
 * Deletes all Meilisearch documents from an index.
 *
 * @param string $index Meilisearch index
 *
 * @return array|WP_Error
 */
function meili_documents_delete_all( string $index ) {
	return meili()->api()->delete_all_documents( $index );
}