(function ($) {
    "use strict";

    console.info('Meilisearch Admin JavaScript loaded.');

    $(document).ready(() => {
        console.info('Meilisearch Admin document ready.');

        const simpleProductTab = {
            synchronizeNowButton: $('.msfwc-simple-product-synchronize-now')
        }

        simpleProductTab.synchronizeNowButton.click((e) => {
            const productId = e?.target?.dataset?.productId || null;

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'msfwc_synchronize_product',
                    nonce: security.synchronize_product,
                    productId,
                },
                dataType: 'json',
                success: (data) => {
                    console.log('Meilisearch ajax request success', data);
                },
                error: (error) => {
                    console.error('Meilisearch ajax request success', error);
                },
                complete: () => {
                    console.info('Meilisearch ajax request complete');
                }
            })
        })
    });
})(jQuery);