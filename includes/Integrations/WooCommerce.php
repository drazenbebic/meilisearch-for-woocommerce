<?php

namespace MeilisearchForWooCommerce\Integrations;

defined( 'ABSPATH' ) || exit;

class WooCommerce {

	public function __construct() {
		$this->bootstrap();
	}

	private function bootstrap() {
		new WooCommerce\ProductData();
		new WooCommerce\Settings();
	}

}