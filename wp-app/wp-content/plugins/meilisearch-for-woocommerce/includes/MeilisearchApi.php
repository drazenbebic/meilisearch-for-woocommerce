<?php

namespace MeilisearchForWooCommerce;

use Exception;
use GuzzleHttp\RequestOptions;
use MeilisearchForWooCommerce\Abstracts\AbstractMeilisearchApi;
use WP_Error;

defined( 'ABSPATH' ) || exit;

class MeilisearchApi extends AbstractMeilisearchApi {

	/**
	 * Retrieves a single document from the given index.
	 *
	 * @param string   $index
	 * @param int      $id
	 * @param string[] $fields
	 *
	 * @return array|WP_Error
	 */
	public function get_document(
		string $index,
		int $id,
		?array $fields = null
	) {
		try {
			$response = $this->client->get( "/indexes/$index/documents/$id", array(
				'query' => array(
					'fields' => $fields
				)
			) );
		} catch ( Exception $e ) {
			return new WP_Error( $e->getCode(), $e->getMessage() );
		}

		return $this->response( $response );
	}

	/**
	 * Retrieves multiple documents from the given index.
	 *
	 * @param string        $index
	 * @param int|null      $limit
	 * @param int|null      $offset
	 * @param string[]|null $fields
	 *
	 * @return array|WP_Error
	 */
	public function get_documents(
		string $index,
		?int $limit = null,
		?int $offset = null,
		?array $fields = array()
	) {
		$response = $this->client->get( "/indexes/$index/documents", array(
			'query' => array(
				'limit'  => $limit,
				'offset' => $offset,
				'fields' => $fields
			)
		) );

		return $this->response( $response );
	}

	/**
	 * Updates an existing, or inserts a new document into an index.
	 *
	 * @param string $index
	 * @param array  $data
	 *
	 * @return array|WP_Error
	 */
	public function upsert_documents( string $index, array $data ) {
		try {
			$response = $this->client->post( "/indexes/$index/documents", array(
				RequestOptions::JSON => $data
			) );
		} catch ( Exception $e ) {
			return new WP_Error( $e->getCode(), $e->getMessage() );
		}

		return $this->response( $response );
	}

	/**
	 * Deletes all documents from an index.
	 *
	 * @param string $index
	 *
	 * @return array|WP_Error
	 */
	public function delete_all_documents( string $index ) {
		try {
			$response = $this->client->delete( "/indexes/$index/documents" );
		} catch ( Exception $e ) {
			return new WP_Error( $e->getCode(), $e->getMessage() );
		}

		return $this->response( $response );
	}
}