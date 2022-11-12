<?php

namespace MeilisearchForWooCommerce\Integrations;

defined( 'ABSPATH' ) || exit;

class WooCommerce {

	public function __construct() {
		$this->bootstrap();
	}

	private function bootstrap() {
		new WooCommerce\Admin\Menu();
		new WooCommerce\Product();
		new WooCommerce\ProductData();
		new WooCommerce\Settings();
	}

}