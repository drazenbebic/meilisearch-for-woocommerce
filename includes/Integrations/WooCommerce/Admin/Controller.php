<?php

namespace MeilisearchForWooCommerce\Integrations\WooCommerce\Admin;

use MeilisearchForWooCommerce\Enums\IndexEnum;

defined( 'ABSPATH' ) || exit;

class Controller {

	public function __construct() {
		add_action( 'admin_post_meili_sync_all_products', array(
			$this,
			'admin_post_sync_all_products'
		) );

		add_action( 'admin_post_meili_delete_all_documents', array(
			$this,
			'admin_post_delete_all_documents'
		) );
	}

	/**
	 * Starts a sync process which will upsert all product data to the
	 * meilisearch product index.
	 *
	 * @return void
	 */
	public function admin_post_sync_all_products() {
		check_admin_referer( 'meili_sync_all_products' );

		// TODO: Implement the method
		msfwc_var_dump_pre( $_POST );
	}

	/**
	 * Deletes all documents from an index.
	 *
	 * @return void
	 */
	public function admin_post_delete_all_documents() {
		check_admin_referer( 'meili_delete_all_documents' );

		$documents = meili()
			->api()
			->delete_all_documents( IndexEnum::WC_PRODUCTS );

		if ( is_wp_error( $documents ) ) {
			// TODO: Add error notification
			msfwc_var_dump_pre( $documents );
		}

		// TODO: Add success notification
		// TODO: Write redirect helper
		wp_safe_redirect( esc_url( get_admin_url() . 'tools.php?page=meilisearch' ) );
		exit();
	}

}