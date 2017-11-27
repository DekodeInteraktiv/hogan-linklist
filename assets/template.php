<?php
/**
 * Template for Link list module
 *
 * $this is an instace of the LinkList object. Ex. use: $this->content to output value.
 *
 * TODO: output for boxes
 * TODO: output for predefined list
 *
 * @package Hogan
 */

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof LinkList ) ) {
	return; // Exit if accessed directly.
}

?>

<?php if ( ! empty( $this->heading ) ) : ?>
	<h2 class="heading"><?php echo esc_html( $this->heading ); ?></h2>
<?php endif; ?>

<?php
if ( ! empty( $this->type ) && 'lists' === $this->type ) :

	foreach ( $this->collection as $list ) :

		if ( ! empty( $this->heading ) ) {
			printf( '<h3 class="heading">%s</h3>', esc_html( $list['list_heading'] ) );
		}
		echo '<ul>';
		the_linklist_items( $list );
		echo '</ul>';

	endforeach;
endif;
