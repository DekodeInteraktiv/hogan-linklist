<?php
/**
 * Helper functions for this plugin
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan\LinkList;

/**
 * Load nav_menu into select field.
 *
 * @param array $field Field array.
 * @return array
 */
function load_predefined_list_choices( array $field ) : array {
	$menus = get_terms( 'nav_menu', [ 'hide_empty' => false ] );

	if ( empty( $menus ) ) {
		return $field;
	}

	foreach ( $menus as $value ) {
		$field['choices'][ $value->term_id ] = $value->name;
	}

	return $field;
}

add_filter( 'acf/load_field/name=predefined_list', __NAMESPACE__ . '\\load_predefined_list_choices' );
