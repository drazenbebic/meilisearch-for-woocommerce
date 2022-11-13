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

            <h2>
                <i class="fa-solid fa-circle-exclamation"></i>
				<?php esc_html_e( 'This product is not synchronized', 'meilisearch-for-woocommerce' ); ?>
            </h2>
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

        <h2>
            <i class="fa-solid fa-circle-check"></i>
			<?php esc_html_e( 'This product is synchronized', 'meilisearch-for-woocommerce' ); ?>
        </h2>

        <p>
            <button data-product-id="<?php echo esc_attr( $product_id ); ?>"
                    type="button"
                    class="msfwc-simple-product-synchronize-now button button-primary">
				<?php esc_html_e( 'Synchronize now', 'meilisearch-for-woocommerce' ); ?>
            </button>
        </p>

	<?php endif; ?>
</div>