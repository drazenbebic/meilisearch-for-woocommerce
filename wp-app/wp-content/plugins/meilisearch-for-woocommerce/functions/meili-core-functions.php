<?php
/**
 * Meilisearch for WooCommerce Core Functions
 *
 * General core functions available on both the front-end and admin.
 */

defined( 'ABSPATH' ) || exit;


/**
 * @param mixed $var
 * @param bool $exit
 *
 * @return void
 */
function meili_var_dump_pre( $var, bool $exit = true ): void {
	echo "<pre>";
	print_r( $var );
	echo "</pre>";

	if ( $exit ) {
		exit;
	}
}

/**
 * Outputs the admin-post.php URL. Useful for admin_post hooks.
 *
 * @return void
 */
function meili_admin_post_url() {
	echo esc_url( admin_url( 'admin-post.php' ) );
}

/**
 * Provides a backwards-compatible solution for the array_key_first() method.
 *
 * @param array $array
 *
 * @return int|string|null
 */
function meili_array_key_first( array $array ) {
	if ( function_exists( 'array_key_first' ) ) {
		return array_key_first( $array );
	}

	reset( $array );

	return key( $array );
}


/**
 * Inserts a new key/value after the key in the array.
 *
 * @param string $needle
 * @param array $haystack
 * @param string $new_key
 * @param string $new_value
 *
 * @return array
 */
function meili_array_insert_after(
	string $needle,
	array  $haystack,
	string $new_key,
	string $new_value
): array {
	if ( array_key_exists( $needle, $haystack ) ) {
		$new_array = array();

		foreach ( $haystack as $key => $value ) {
			$new_array[ $key ] = $value;

			if ( $key === $needle ) {
				$new_array[ $new_key ] = $new_value;
			}
		}

		return $new_array;
	}

	return $haystack;
}

/**
 * @param string $template_name
 * @param array $args
 * @param string $template_path
 * @param string $default_path
 *
 * @return void
 */
function meili_get_template(
	string $template_name,
	array  $args = array(),
	string $template_path = '',
	string $default_path = MEILI_TEMPLATES_DIR
) {
	wc_get_template( $template_name, $args, $template_path, $default_path );
}

/**
 * @param string $template_name
 * @param array $args
 * @param string $template_path
 * @param string $default_path
 *
 * @return string
 */
function meili_get_template_html(
	string $template_name,
	array  $args = array(),
	string $template_path = '',
	string $default_path = MEILI_TEMPLATES_DIR
): string {
	return wc_get_template_html(
		$template_name,
		$args,
		$template_path,
		$default_path
	);
}

/**
 * @param string $file_name
 *
 * @return string
 */
function meili_get_js_url( string $file_name ): string {
	return apply_filters( 'meili_get_js_url', MEILI_JS_URL . $file_name );
}

/**
 * @param string $file_name
 *
 * @return string
 */
function meili_get_admin_js_url( string $file_name ): string {
	return apply_filters( 'meili_get_admin_js_url', MEILI_ADMIN_JS_URL . $file_name );
}

/**
 * @param string $file_name
 *
 * @return string
 */
function meili_get_css_url( string $file_name ): string {
	return apply_filters( 'meili_get_css_url', MEILI_CSS_URL . $file_name );
}

/**
 * @param string $file_name
 *
 * @return string
 */
function meili_get_admin_css_url( string $file_name ): string {
	return apply_filters( 'meili_get_admin_css_url', MEILI_ADMIN_CSS_URL . $file_name );
}

/**
 * @param string $file_name
 *
 * @return string
 */
function meili_get_img_url( string $file_name ): string {
	return apply_filters( 'meili_get_img_url', MEILI_IMG_URL . $file_name );
}

/**
 * @param string $file_name
 *
 * @return string
 */
function meili_get_admin_img_url( string $file_name ): string {
	return apply_filters( 'meili_get_admin_img_url', MEILI_ADMIN_IMG_URL . $file_name );
}

/**
 * Returns the current page from the GET parameters, if it's plugin-related.
 *
 * @param string $default
 *
 * @return string
 */
function meili_get_plugin_page( string $default = '' ): string {
	if ( ! isset( $_GET['page'] ) ) {
		return $default;
	}

	$page = sanitize_text_field( $_GET['page'] );

	if ( false === strpos( $page, 'meili' ) ) {
		return $default;
	}

	return $page;
}

/**
 * Returns the string value of the "action" GET parameter.
 *
 * @param string $default
 *
 * @return string
 */
function meili_get_current_action( string $default = '' ): string {
	$action = $default;

	if ( ! isset( $_GET['action'] ) || ! is_string( $_GET['action'] ) ) {
		return $action;
	}

	return sanitize_text_field( $_GET['action'] );
}

/**
 * Returns a UTC DateTime object for the given date time string.
 *
 * @param string $date_time_string
 *
 * @return DateTime
 * @throws Exception
 */
function meili_get_utc_date_time( string $date_time_string ): DateTime {
	return new DateTime( $date_time_string, new DateTimeZone( 'UTC' ) );
}

/**
 * Maps the WooCommerce product fields to the Meilisearch document.
 *
 * @param WC_Product $product
 *
 * @return array
 */
function meili_map_product_fields( WC_Product $product ): array {
	$fields       = meili_get_product_index_fields();
	$data         = array();
	$product_data = $product->get_data();

	foreach ( $fields as $field ) {
		switch ( $field['type'] ) {
			case 'property':
				if ( array_key_exists( $field['value'], $product_data ) ) {
					$data[ $field['value'] ] = $product_data[ $field['value'] ] ?: null;
				}
				break;
			case 'price':
				$price                   = floatval( $product_data[ $field['value'] ] );
				$data[ $field['value'] ] = $price;
				break;
			case 'image':
				$image         = wp_get_attachment_image_url( $product->get_image_id() );
				$data['image'] = $image ?: null;
				break;
		}
	}

	return $data;
}