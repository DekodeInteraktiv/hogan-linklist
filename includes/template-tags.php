<?php
/**
 * Custom template tags for this plugin
 *
 * @package Hogan
 */

namespace Dekode\Hogan;

/**
 * Output list view
 *
 * @param array $list List layouts.
 */
function the_linklist_items( $list ) {

	switch ( $list['acf_fc_layout'] ) {

		case 'predefined':
			$menu = $list['predefined_list'];
			foreach ( wp_get_nav_menu_items( $menu ) as $link ) {
				printf( '<li><a href="%s">%s</a>%s</li>', esc_url( $link->url ), esc_html( $link->title ), esc_html( $link->description ) );
			}
			break;
		case 'manual':
			foreach ( $list['manual_list'] as $item ) {
				if ( empty( $item['link']['url'] ) ) {
					break;
				}
				$title = empty( $item['link']['title'] ) ? $item['link']['url'] : $item['link']['title'];
				$target = empty( $item['link']['target'] ) ? '' : sprintf( 'target="%s"', $item['link']['target'] );
				printf( '<li><a href="%s" %s>%s</a>%s</li>', esc_url( $item['link']['url'] ), esc_attr( $target ), esc_html( $title ), esc_html( $item['link_description'] ) );
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
add_filter( 'acf/load_field/name=box_predefined_list', __NAMESPACE__ . '\\load_predefined_list_choices' );
