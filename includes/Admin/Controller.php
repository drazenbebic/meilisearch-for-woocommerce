<?php

namespace MeilisearchForWooCommerce\Admin;

use MeilisearchForWooCommerce\Enums\IndexEnum;

defined( 'ABSPATH' ) || exit;

class Controller {

	public function __construct() {
		add_action( 'wp_ajax_msfwc_synchronize_product', array(
			$this,
			'synchronize_product'
		), 10 );
	}

	public function synchronize_product() {
		check_ajax_referer( 'msfwc_synchronize_product', 'nonce' );

		$productId = (int) $_POST['productId'];

		if ( ! $productId ) {
			wp_send_json( array(
				'success' => false,
				'message' => 'The product ID is invalid.'
			), 400 );
		}

		$product = wc_get_product( $productId );

		if ( ! $product ) {
			wp_send_json( array(
				'success' => false,
				'message' => 'The product could not be found.'
			), 404 );
		}

		$document = msfwc()->api()->upsert_documents(
			IndexEnum::WC_PRODUCTS,
			array(
				msfwc_map_product_fields( $product )
			) );

		if ( is_wp_error( $document ) ) {
			wp_send_json( array(
				'success' => false,
				'message' => $document->get_error_message(),
			), $document->get_error_code() );
		}

		wp_send_json( array(
			'success' => true,
			'message' => 'Product synchronized successfully.',
			'data'    => $document
		), 200 );
	}

}