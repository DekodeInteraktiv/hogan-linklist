<?php
/**
 * Helper functions for this plugin
 *
 * @package Hogan
 */

namespace Dekode\Hogan\LinkList;

/**
 * Load nav_menu into select field.
 *
 * @param array $field Field array.
 */
function load_predefined_list_choices( $field ) {
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

	if ( empty( $menus ) ) {
		return $field;
	}

	foreach ( $menus as $value ) {
		$field['choices'][ $value->term_id ] = $value->name;
	}

	return $field;
}
add_filter( 'acf/load_field/name=predefined_list', __NAMESPACE__ . '\\load_predefined_list_choices' );

/**
 * Hook custom post types into acf link field.
 *
 * @param array $query The query.
 */
function add_custom_post_types_to_link_field( $query ) {

  	$query['post_type'] = apply_filters( 'hogan/module/linklist/post_types_in_link_field', [ 'post', 'page' ] );
    return $query;
}

add_filter( 'wp_link_query_args', __NAMESPACE__ . '\\add_custom_post_types_to_link_field' );
