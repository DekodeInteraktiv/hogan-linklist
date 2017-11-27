<?php
/**
 * Template for Link list module
 *
 * $this is an instace of the LinkList object. Ex. use: $this->content to output value.
 *
 * @package Hogan
 */

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof LinkList ) || empty( $this->type ) ) {
	return; // Exit if accessed directly.
}

if ( ! empty( $this->heading ) ) : ?>
	<h2 class="heading"><?php echo esc_html( $this->heading ); ?></h2>
<?php
endif;

if ( 'lists' === $this->type && ! empty( $this->collection ) ) :

	foreach ( $this->collection as $list ) :

		if ( ! empty( $list['list_heading'] ) ) {
			printf( '<h3>%s</h3>', esc_html( $list['list_heading'] ) );
		}
		the_linklist_items( $list );

	endforeach;

elseif ( 'boxes' === $this->type ) :
	the_linklist_boxes( $this->boxes );
endif;
