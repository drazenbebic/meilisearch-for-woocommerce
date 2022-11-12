<?php

namespace MeilisearchForWooCommerce\Integrations\WooCommerce;

use MeilisearchForWooCommerce\Enums\IndexEnum;
use WP_Post;

defined( 'ABSPATH' ) || exit;

class Product {

	public function __construct() {
		add_action( 'save_post_product', array(
			$this,
			'on_save_product'
		), 10, 3 );

		add_action( 'woocommerce_before_delete_product', array(
			$this,
			'on_delete_product'
		) );
	}

	/**
	 * This will synchronize the WooCommerce product with its corresponding
	 * Meilisearch document, if configured. Triggers when a product has been
	 * saved.
	 *
	 * @param int $product_id
	 * @param WP_Post $post
	 * @param bool $update
	 *
	 * @return void
	 */
	public function on_save_product(
		int $product_id,
		WP_Post $post,
		bool $update
	) {
		if ( ! $update && $post->post_status !== 'auto-draft' ) {
			msfwc_var_dump_pre( $post );
			msfwc_var_dump_pre( 'nao', true );
		}

		// Skip if this is an update and sync on update is off.
		if ( $update && ! msfwc_product_sync_on_update() ) {
			return;
		}

		// Skip if this is a new product and sync on create is off.
		if ( $post->post_status === 'publish' && ! $update && ! msfwc_product_sync_on_create() ) {
			msfwc_var_dump_pre( $post->post_status );
			exit( 'cyka blyat' );

			return;
		}

		$product = wc_get_product( $product_id );

		if ( ! $product ) {
			return;
		}

		$document = msfwc()
			->api()
			->upsert_documents(
				IndexEnum::WC_PRODUCTS,
				array(
					msfwc_map_product_fields( $product )
				)
			);

		if ( is_wp_error( $document ) ) {
			// TODO: Add error notification.
		}

		// TODO: Add success notification

		do_action(
			'msfwc_event_post_document_upsert',
			IndexEnum::WC_PRODUCTS,
			$product,
			$document
		);
	}

	public function on_delete_product() {

	}

}