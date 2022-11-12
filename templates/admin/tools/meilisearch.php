<?php

/**
 * Available variables
 */

?>

<div class="wrap">
    <h1><?php esc_html_e( 'Meilisearch tools', 'meilisearch-for-woocommerce' ); ?></h1>

    <div class="msfwc-tools-meilisearch">

        <div class="container">

            <div class="tile">
                <h2><?php esc_html_e( 'Product synchronization', 'meilisearch-for-woocommerce' ); ?></h2>
                <p><?php esc_html_e( 'This action allows you to synchronize the entirety of your product database with Meilisearch. Depending on how many products you have, this step could take a while to complete. It will run in the background, provided that you have configured WP_CRON or your site has enough traffic to keep triggering the scheduled tasks.', 'meilisearch-for-woocommerce' ); ?></p>

                <form action="<?php esc_url( 'admin-post.php' ); ?>"
                      method="post">
					<?php submit_button( esc_html__( 'Synchronize now', 'meilisearch-for-woocommerce' ) ); ?>
                </form>
            </div>
            <div class="tile">
                <h2><?php esc_html_e( 'Index cleanup', 'meilisearch-for-woocommerce' ); ?></h2>
                <p><?php esc_html_e( 'This action will delete all documents from the Meilisearch instance, it will NOT delete the WooCommerce products. Use with caution.', 'meilisearch-for-woocommerce' ); ?></p>

                <form action="<?php esc_url( 'admin-post.php' ); ?>"
                      method="post">
					<?php submit_button( esc_html__( 'Empty the index', 'meilisearch-for-woocommerce' ) ); ?>
                </form>
            </div>

        </div>

    </div>
</div>
