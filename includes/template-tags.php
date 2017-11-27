<?php
/**
 * Custom template tags for this plugin
 *
 * @package Hogan
 */

namespace Dekode\Hogan;

/**
 * Print li's for link list
 *
 * @param array $list List items.
 */
function the_linklist_items( $list ) {
	switch ( $list['list_content'] ) {

		case 'predefined':
			$menu = $list['predefined_list'];
			foreach ( wp_get_nav_menu_items( $menu ) as $link ) {
				printf( '<li><a href="%s">%s</a></li>', esc_url( $link->url ), esc_html( $link->title ) );
			}
			break;
		case 'manual':
			foreach ( $list['manual_list'] as $link ) {
				$title = empty( $link['link']['title'] ) ? $link['link']['url'] : $link['link']['title'];
				$target = empty( $link['link']['target'] ) ? '' : sprintf( 'target="%s"', $link['link']['target'] );
				printf( '<li><a href="%s" %s>%s</a></li>', esc_url( $link['link']['url'] ), esc_attr( $target ), esc_html( $title ) );
			}
			break;

		default:
			break;
	}
}

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
