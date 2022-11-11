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

		//msfwc_var_dump_pre( 'SCREEN_ID:' . $screen_id, true );

		wp_register_style(
			'msfwc_admin_css',
			msfwc_get_admin_css_url( 'msfwc-admin.css' ),
			array(),
			MSFWC_VERSION
		);

		if ( in_array( $screen_id, array(
			'product'
		) ) ) {
			wp_enqueue_style( 'msfwc_admin_css' );
		}

	}

	public function admin_scripts() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		wp_register_script(
			'msfwc_admin',
			msfwc_get_admin_js_url( 'msfwc-admin.js' ),
			array( 'jquery' ),
			MSFWC_VERSION
		);

		if ( in_array( $screen_id, array(
			'product',
		) ) ) {
			wp_enqueue_script( 'msfwc_admin' );

			// Script localization
			wp_localize_script( 'msfwc_admin', 'security', array(
				'synchronize_product' => wp_create_nonce( 'msfwc_synchronize_product' ),
			) );
		}
	}

}