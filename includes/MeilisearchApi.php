<?php

namespace MeilisearchForWooCommerce;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use WP_Error;

defined( 'ABSPATH' ) || exit;

class MeilisearchApi {

	/**
	 * @var Client
	 */
	protected Client $client;

	public function __construct() {
		$token = msfwc_get_meilisearch_instance_api_key();

		$this->client = new Client(
			array(
				'base_uri' => msfwc_get_meilisearch_instance_url(),
				'headers'  => array(
					'Authorization' => "Bearer $token"
				)
			)
		);
	}

	/**
	 * @param string $index
	 * @param int $id
	 * @param string[] $fields
	 *
	 * @return array|WP_Error
	 */
	public function get_document( string $index, int $id, ?array $fields = null ) {
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
	 * @param ResponseInterface $response
	 *
	 * @return array|WP_Error
	 */
	public function response( ResponseInterface $response ) {
		$status   = $response->getStatusCode();
		$contents = $response->getBody()->getContents();

		if ( $status >= 200 && $status < 300 ) {
			$response = json_decode( $contents, true );
		} else {
			$response = new WP_Error( $response->getStatusCode(), $contents );
		}

		return $response;
	}

	/**
	 * @param string $index
	 * @param int|null $limit
	 * @param int|null $offset
	 * @param array|null $fields
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
	 * @param string $index
	 * @param array $data
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
}