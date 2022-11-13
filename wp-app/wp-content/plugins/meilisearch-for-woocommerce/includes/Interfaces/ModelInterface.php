<?php

namespace MeilisearchForWooCommerce\Interfaces;

defined('ABSPATH') || exit;

interface ModelInterface {

	/**
	 * Returns the objects' properties as an array.
	 *
	 * @return array
	 */
	public function to_array(): array;

}