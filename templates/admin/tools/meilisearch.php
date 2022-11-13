<?php

/**
 * Available variables
 */

?>

<div class="wrap">
    <h1><?php esc_html_e( 'Meilisearch tools', 'meilisearch-for-woocommerce' ); ?></h1>

    <div class="card">
        <h2 class="title">
			<?php esc_html_e( 'Product synchronization', 'meilisearch-for-woocommerce' ); ?>
        </h2>
        <p><?php esc_html_e( 'This action allows you to synchronize the entirety of your WooCommerce product database with Meilisearch.', 'meilisearch-for-woocommerce' ); ?></p>
        <p><?php esc_html_e( 'The synchronization process will run in the background. Depending on how many products you have, this could take a while to complete.', 'meilisearch-for-woocommerce' ); ?></p>

        <form action="<?php msfwc_admin_post_url(); ?>"
              method="post">
            <input type="hidden"
                   name="action"
                   value="meili_sync_all_products"/>
			<?php wp_nonce_field( 'meili_sync_all_products' ); ?>
			<?php submit_button( esc_html__( 'Synchronize now', 'meilisearch-for-woocommerce' ) ); ?>
        </form>
    </div>

    <div class="card">
        <h2 class="title"><?php esc_html_e( 'Delete all documents', 'meilisearch-for-woocommerce' ); ?></h2>
        <p><?php esc_html_e( 'This action will delete all documents from the Meilisearch instance, it will NOT delete the WooCommerce products. Use with caution.', 'meilisearch-for-woocommerce' ); ?></p>

        <form action="<?php msfwc_admin_post_url(); ?>"
              method="post">
            <input type="hidden"
                   name="action"
                   value="meili_delete_all_documents"/>
			<?php wp_nonce_field( 'meili_delete_all_documents' ); ?>
			<?php submit_button( esc_html__(
				'Remove all documents',
				'meilisearch-for-woocommerce'
			) ); ?>
        </form>
    </div>
</div>
