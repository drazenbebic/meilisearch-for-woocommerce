<?php

namespace MeilisearchForWooCommerce\Integrations\WooCommerce\Admin;

defined( 'ABSPATH' ) || exit;

class Menu {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	public function admin_menu() {
		$hook = add_management_page(
			esc_html__( 'Meilisearch', 'meilisearch-for-woocommerce' ),
			esc_html__( 'Meilisearch', 'meilisearch-for-woocommerce' ),
			'manage_options',
			'meilisearch',
			array( $this, 'admin_page' )
		);

		add_action( "load-$hook", array( $this, 'admin_page_load' ) );
	}

	public function admin_page() {
		msfwc_get_template( 'admin/tools/meilisearch.php' );
	}

	public function admin_page_load() {
	}

}