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
			$links = $list['predefined_list'];
			break;
		case 'list':
			foreach ( $list['custom_list'] as $link ) {
				printf( '<li><a href="%s">%s</a></li>', esc_url( get_the_permalink( $link ) ), get_the_title( $link ) );
			}
			break;
		case 'manual':
			foreach ( $list['manual_list'] as $link ) {
				$title = empty( $link['link']['title'] ) ? '<tittel mangler>' : $link['link']['title'];
				printf( '<li><a href="%s">%s</a></li>', esc_url( $link['link']['url'] ), esc_html( $title ) );
			}
			break;

		default:
			break;
	}
}
