<?php
/**
 * Template for Link list module
 *
 * $this is an instace of the LinkList object. Ex. use: $this->content to output value.
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
