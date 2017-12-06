<?php
/**
 * Template for Link list module
 *
 * $this is an instace of the LinkList object.
 *
 * Available properties:
 * $this->heading (string) Module heading.
 * $this->lists (array) Lists with items.
 * $this->type (string) List look -> Options: 'lists' or 'boxes'
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof LinkList ) ) {
	return; // Exit if accessed directly.
}

$container_classes = apply_filters( 'hogan/module/linklist/container_classes', [ 'hogan-linklist-container', $this->type ], $this );
$list_classes = apply_filters( 'hogan/module/linklist/list_classes', [], $this );

?>

<?php if ( ! empty( $this->heading ) ) : ?>
	<h2 class="heading"><?php echo esc_html( $this->heading ); ?></h2>
<?php endif; ?>

<ul class="<?php echo esc_attr( implode( ' ', $container_classes ) ); ?>">
	<?php
	foreach ( $this->lists as $list ) :

		$items = $this->get_list_items( $list );

		if ( empty( $items ) ) {
			continue;
		}
		?>

		<?php if ( ! empty( $list['list_heading'] ) ) : ?>
			<h3><?php echo esc_html( $list['list_heading'] ); ?></h3>
		<?php endif; ?>

		<ul class="<?php echo esc_attr( implode( ' ', $list_classes ) ); ?>">
			<?php foreach ( $items as $item ) : ?>
				<li>
					<a href="<?php echo esc_url( $item['href'] ); ?>" target="<?php echo esc_attr( $item['target'] ); ?>">
						<?php echo esc_html( $item['title'] ); ?>

						<?php if ( ! empty( $item['description'] ) ) : ?>
							<span class="description"><?php echo esc_html( $item['description'] ); ?></span>
						<?php endif; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endforeach; ?>
</ul>
