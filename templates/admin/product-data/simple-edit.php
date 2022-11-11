<?php
/**
 * Available variables
 *
 * @var ModelInterface|WP_Error $document
 * @var int $product_id
 */

use MeilisearchForWooCommerce\Interfaces\ModelInterface;

?>
<div class="msfwc-product-data-container">
	<?php if ( is_wp_error( $document ) ): ?>

		<?php if ( $document->get_error_code() === 404 ): ?>

            <p><?php esc_html_e( 'The product has not been synchronized yet.', 'meilisearch-for-woocommerce' ); ?></p>
            <p>
                <button data-product-id="<?php echo esc_attr( $product_id ); ?>"
                        type="button"
                        class="msfwc-simple-product-synchronize-now button button-primary">
					<?php esc_html_e( 'Synchronize now', 'meilisearch-for-woocommerce' ); ?>
                </button>
            </p>

		<?php else: ?>

            <p><?php esc_html_e( 'The product data could not be retrieved.', 'meilisearch-for-woocommerce' ); ?></p>

		<?php endif; ?>

	<?php else: ?>

		<?php msfwc_var_dump_pre( $document ); ?>

        <p>
            <button data-product-id="<?php echo esc_attr( $product_id ); ?>"
                    type="button"
                    class="msfwc-simple-product-synchronize-now button button-primary">
				<?php esc_html_e( 'Synchronize now', 'meilisearch-for-woocommerce' ); ?>
            </button>
        </p>

	<?php endif; ?>
</div>