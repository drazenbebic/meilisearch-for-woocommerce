<?php

namespace MeilisearchForWooCommerce\Admin;

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

		$document = meili()->api()->upsert_documents(
			msfwc_get_product_index_name(),
			array(
				msfwc_map_product_fields( $product )
			) );

		if ( is_wp_error( $document ) ) {
			wp_send_json( array(
				'success' => false,
				'message' => $document->get_error_message(),
			), $document->get_error_code() );
		}

		ob_clean();
		msfwc_get_template(
			'admin/product-data/simple-edit.php',
			array(
				'document'   => $document,
				'product_id' => $productId
			)
		);
		$template = ob_get_contents();

		wp_send_json( array(
			'success' => true,
			'message' => 'Product synchronized successfully.',
			'data'    => array(
				'document' => $document,
				'template' => $template
			)
		), 200 );
	}

}