<?php

namespace MeilisearchForWooCommerce\Abstracts;

use MeilisearchForWooCommerce\Interfaces\ModelInterface;

defined('ABSPATH') || exit;

abstract class AbstractModel implements ModelInterface {

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		return get_object_vars($this);
	}

}