<?php

namespace MeilisearchForWooCommerce\Admin;

defined( 'ABSPATH' ) || exit;

class Assets {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array(
			$this,
			'admin_styles'
		), 20 );
		add_action( 'admin_enqueue_scripts', array(
			$this,
			'admin_scripts'
		), 20 );
	}

	public function admin_styles() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		wp_register_style(
			'meili_admin_css',
			meili_get_admin_css_url( 'meili-admin.min.css' ),
			array(),
			MEILI_VERSION
		);

		wp_register_style(
			'meili_admin_fontawesome',
			meili_get_admin_css_url( 'meili-fontawesome.min.css' ),
			array(),
			'6.2.0'
		);

		if ( in_array( $screen_id, array(
			'product',
			'tools_page_meilisearch'
		) ) ) {
			wp_enqueue_style( 'meili_admin_css' );
			wp_enqueue_style( 'meili_admin_fontawesome' );
		}

	}

	public function admin_scripts() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		wp_register_script(
			'meili_admin_js',
			meili_get_admin_js_url( 'meili-admin.js' ),
			array( 'jquery' ),
			MEILI_VERSION
		);

		if ( in_array( $screen_id, array(
			'product',
		) ) ) {
			wp_enqueue_script( 'meili_admin_js' );

			// Script localization
			wp_localize_script( 'meili_admin_js', 'security', array(
				'synchronize_product' => wp_create_nonce( 'meili_synchronize_product' ),
			) );
		}
	}

}