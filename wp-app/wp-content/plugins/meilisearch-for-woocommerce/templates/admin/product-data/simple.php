<?php

/**
 * Available variables
 *
 * @var array|WP_Error $document
 * @var int $product_id
 */

?>

<p class="form-field meili_index_status_field ">
	<label for="meili_index_status">
		<?php esc_html_e( 'Status', 'meilisearch-for-woocommerce' ); ?>
	</label>

	<?php if ( is_wp_error( $document ) ): ?>

		<span class="description" style="margin-left: 0;">
			<i class="meili-text-warning fa-solid fa-circle-exclamation"></i>
			<?php esc_html_e( 'Product is not indexed', 'meilisearch-for-woocommerce' ); ?>
		</span>

	<?php else: ?>

		<span class="description" style="margin-left: 0;">
			<i class="meili-text-success fa-solid fa-circle-check"></i>
			<?php esc_html_e( 'Product is indexed', 'meilisearch-for-woocommerce' ); ?>
		</span>

	<?php endif; ?>

</p>

<p class="form-field">
	<?php wp_nonce_field( 'meili_index_now' ); ?>
	<?php submit_button(
		esc_html__( 'Index now', 'meilisearch-for-woocommerce' ),
		'primary',
		'meili_index_now',
		false
	); ?>
</p>