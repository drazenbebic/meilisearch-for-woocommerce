<?php

namespace MeilisearchForWooCommerce\Integrations\WooCommerce;

use WC_Product;
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
		add_action( 'woocommerce_update_product', array(
			$this,
			'product_update'
		), 10, 2 );
		add_action( 'woocommerce_new_product', array(
			$this,
			'product_create'
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

		// Display the "Not configured" template.
		if ( ! meili_is_meilisearch_instance_configured() ) {
			meili_get_template( 'admin/product-data/not-configured.php' );

			return;
		}

		echo sprintf(
			'<div id="%s" class="panel woocommerce_options_panel"><div class="options_group">',
			$this->tab_target
		);

		echo '<input type="hidden" name="meili_edit_flag" value="true" />';

		$document = meili()->api()->get_document(
			meili_get_product_index_name(),
			$post->ID
		);

		// Index status
		meili_get_template( '/admin/product-data/simple.php', array(
			'document' => $document
		) );

		echo '</div><div class="options_group">';

		// Skip on update checkbox
		woocommerce_wp_checkbox( array(
			'id'          => 'meili_skip_on_update',
			'label'       => esc_html__(
				'Skip on update',
				'meilisearch-for-woocommerce'
			),
			'description' => esc_html__(
				'Skip this product when the index is updated.',
				'meilisearch-for-woocommerce'
			),
			'value'       => meili_product_skip_on_update(
				$post->ID
			),
			'cbvalue'     => 1,
			'desc_tip'    => false
		) );

		// Skip on delete checkbox
		woocommerce_wp_checkbox( array(
			'id'          => 'meili_skip_on_delete',
			'label'       => esc_html__(
				'Skip on delete',
				'meilisearch-for-woocommerce'
			),
			'description' => esc_html__(
				'Skip this product when the index is deleted.',
				'meilisearch-for-woocommerce'
			),
			'value'       => meili_product_skip_on_delete( $post->ID ),
			'cbvalue'     => 1,
			'desc_tip'    => false
		) );

		do_action( 'meili_simple_product_data_panel', $post->ID );

		echo '</div></div>';
	}

	/**
	 * Hook which triggers when the WooCommerce Product is being saved or updated.
	 *
	 * @param int $post_id
	 */
	public function simple_product_save( int $post_id ) {
		// Meilisearch isn't fully configured.
		if ( ! meili_is_meilisearch_instance_configured() ) {
			return;
		}

		// Edit flag isn't set
		if ( ! isset( $_POST['meili_edit_flag'] ) ) {
			return;
		}

		// Update skip on update flag, according to checkbox.
		if ( isset( $_POST['meili_skip_on_update'] ) ) {
			update_post_meta( $post_id, 'meili_skip_on_update', 1 );
		} else {
			update_post_meta( $post_id, 'meili_skip_on_update', 0 );
		}

		// Update skip on update flag, according to checkbox.
		if ( isset( $_POST['meili_skip_on_delete'] ) ) {
			update_post_meta( $post_id, 'meili_skip_on_delete', 1 );
		} else {
			update_post_meta( $post_id, 'meili_skip_on_delete', 0 );
		}

		// Update the document when "Index now" is clicked.
		if ( isset( $_POST['meili_index_now'] ) ) {
			$document = meili_product_upsert( $post_id );

			if ( is_wp_error( $document ) ) {
				// TODO: Display error notification
			} else {
				// TODO: Display success notification
			}
		}

		do_action( 'meili_simple_product_save', $post_id );
	}

	/**
	 * Triggers when a product is updated.
	 *
	 * @param int        $product_id
	 * @param WC_Product $product
	 */
	public function product_update( int $product_id, WC_Product $product ) {
		// Meilisearch isn't fully configured.
		if ( ! meili_is_meilisearch_instance_configured() ) {
			return;
		}

		// Update the Meilisearch document if "Index on update" is on. Skip if
		// the document has already been updated before.
		if ( meili_index_update_on_update() ) {
			$document = meili_product_upsert( $product );

			if ( is_wp_error( $document ) ) {
				// TODO: Display error notification
			} else {
				// TODO: Display success notification
			}
		}

		do_action( 'meili_wc_product_update', $product_id );
	}

	/**
	 * Triggers when a product is created.
	 *
	 * @param int        $product_id
	 * @param WC_Product $product
	 *
	 * @return void
	 */
	public function product_create( int $product_id, WC_Product $product ) {
		// Meilisearch isn't fully configured.
		if ( ! meili_is_meilisearch_instance_configured() ) {
			return;
		}

		if ( meili_index_update_on_create() ) {
			$document = meili_product_upsert( $product );

			if ( is_wp_error( $document ) ) {
				// TODO: Display error notification
			} else {
				// TODO: Display success notification
			}
		}

		do_action( 'meili_wc_product_create', $product_id );
	}

	/**
	 * Adds the new product data fields to variable WooCommerce Products.
	 *
	 * @param int     $loop
	 * @param array   $variation_data
	 * @param WP_Post $variation
	 */
	public function variable_product_data_panel(
		int $loop,
		array $variation_data,
		WP_Post $variation
	) {
		echo sprintf(
			'<p class="form-row form-row-full"><strong>%s</strong></p>',
			__( 'Meilisearch for WooCommerce', 'meilisearch-for-woocommerce' )
		);

		echo '<input type="hidden" name="meili_edit_flag" value="true" />';

		do_action(
			'meili_variable_product_data_panel',
			$loop,
			$variation_data,
			$variation
		);
	}

	/**
	 * Saves the data from the product variation fields.
	 *
	 * @param int $variation_id
	 * @param int $i
	 */
	public function variable_product_save( int $variation_id, int $i ) {
		do_action( 'meili_variable_product_save', $variation_id, $i );
	}

}