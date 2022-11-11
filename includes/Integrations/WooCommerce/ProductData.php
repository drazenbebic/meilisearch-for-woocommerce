<?php

namespace MeilisearchForWooCommerce\Integrations\WooCommerce;

use WP_Post;

defined( 'ABSPATH' ) || exit;

class ProductData {

	/**
	 * @var string
	 */
	protected string $tab_name = 'meilisearch_tab';

	/**
	 * @var string
	 */
	protected string $tab_target = 'meilisearch_product_data';

	public function __construct() {
		add_action( 'admin_head', array( $this, 'style_tab' ), 10, 1 );
		add_filter( 'woocommerce_product_data_tabs', array(
			$this,
			'simple_product_tab'
		), 10, 1 );
		add_action( 'woocommerce_product_data_panels', array(
			$this,
			'simple_product_data_panel'
		), 10, 1 );
		add_action( 'save_post_product', array(
			$this,
			'simple_product_save'
		), 10, 1 );
		add_action( 'woocommerce_product_after_variable_attributes', array(
			$this,
			'variable_product_data_panel'
		), 10, 3 );
		add_action( 'woocommerce_save_product_variation', array(
			$this,
			'variable_product_save'
		), 10, 2 );
	}

	/**
	 * Adds an icon to the new data tab.
	 *
	 * @see https://docs.woocommerce.com/document/utilising-the-woocommerce-icon-font-in-your-extensions/
	 * @see https://developer.wordpress.org/resource/dashicons/
	 */
	public function style_tab() {
		echo sprintf(
			'<style>#woocommerce-product-data ul.wc-tabs li.%s_options a:before { font-family: %s; content: "%s"; }</style>',
			$this->tab_name,
			'dashicons',
			'\f179'
		);
	}

	/**
	 * Adds a product data tab for simple WooCommerce products.
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	public function simple_product_tab( array $tabs ): array {
		$tabs[ $this->tab_name ] = array(
			'label'    => __( 'Meilisearch', 'meilisearch-for-woocommerce' ),
			'target'   => $this->tab_target,
			'class'    => array( 'show_if_simple', 'show_if_external' ),
			'priority' => 21
		);

		return $tabs;
	}


	/**
	 * Displays the new fields inside the new product data tab.
	 */
	public function simple_product_data_panel() {
		global $post;

		$screen = get_current_screen();

		echo sprintf(
			'<div id="%s" class="panel woocommerce_options_panel"><div class="options_group">',
			$this->tab_target
		);

		if ( $screen->action === '' ) {
			$document = msfwc()->api()->get_document(
				'products',
				$post->ID
			);

			msfwc_get_template(
				'admin/product-data/simple-edit.php',
				array(
					'document'   => $document,
					'product_id' => $post->ID
				)
			);
		}

		do_action( 'msfwc_simple_product_data_panel', $post );

		echo '</div></div>';
	}

	/**
	 * Hook which triggers when the WooCommerce Product is being saved or updated.
	 *
	 * @param int $post_id
	 */
	public function simple_product_save( int $post_id ) {
		// Edit flag isn't set
		if ( ! isset( $_POST['msfwc_edit_flag'] ) ) {
			return;
		}

		do_action( 'msfwc_simple_product_save', $post_id );
	}

	/**
	 * Adds the new product data fields to variable WooCommerce Products.
	 *
	 * @param int $loop
	 * @param array $variation_data
	 * @param WP_Post $variation
	 */
	public function variable_product_data_panel( int $loop, array $variation_data, WP_Post $variation ) {
		echo sprintf(
			'<p class="form-row form-row-full"><strong>%s</strong></p>',
			__( 'Meilisearch for WooCommerce', 'meilisearch-for-woocommerce' )
		);

		echo '<input type="hidden" name="msfwc_edit_flag" value="true" />';

		do_action( 'msfwc_variable_product_data_panel', $loop, $variation_data, $variation );
	}

	/**
	 * Saves the data from the product variation fields.
	 *
	 * @param int $variation_id
	 * @param int $i
	 */
	public function variable_product_save( int $variation_id, int $i ) {
		do_action( 'msfwc_variable_product_save', $variation_id, $i );
	}

}