<?php

namespace MeilisearchForWooCommerce\Abstracts;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use WP_Error;

defined( 'ABSPATH' ) || exit;

abstract class AbstractMeilisearchApi {

	/**
	 * @var Client
	 */
	protected Client $client;

	/**
	 * Prepares the Meilisearch instance.
	 */
	public function __construct() {
		$token = meili_get_meilisearch_instance_api_key();

		$this->client = new Client(
			array(
				'base_uri' => meili_get_meilisearch_instance_url(),
				'headers'  => array(
					'Authorization' => "Bearer $token"
				)
			)
		);
	}

	public function prepare() {

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

}