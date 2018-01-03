<?php
/**
 * Template for Link list module
 *
 * $this is an instace of the LinkList object.
 *
 * Available properties:
 * $this->heading (string) Module heading.
 * $this->lists (array) Lists with items.
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof LinkList ) ) {
	return; // Exit if accessed directly.
}

$container_classes = apply_filters( 'hogan/module/linklist/container_classes', [ 'hogan-linklist-container', $this->type ], $this );
?>

<?php if ( ! empty( $this->heading ) ) : ?>
	<h2 class="hogan-heading"><?php echo esc_html( $this->heading ); ?></h2>
<?php endif; ?>

<ul class="<?php echo esc_attr( implode( ' ', $container_classes ) ); ?>">
	<?php
	$list_counter = 0;
	foreach ( $this->lists as $list ) :

		$items = $this->get_list_items( $list );

		if ( empty( $items ) ) {
			continue;
		}

		$container_li_classes = apply_filters( 'hogan/module/linklist/container_li_classes', [], $this, $list, $items, $list_counter );
		$list_classes = apply_filters( 'hogan/module/linklist/list_classes', [], $this, $list, $items, $list_counter );
		$list_li_classes = apply_filters( 'hogan/module/linklist/list_li_classes', [], $this, $list, $items, $list_counter );

		?>
		<li class="<?php echo esc_attr( implode( ' ', $container_li_classes ) ); ?>">
			<?php if ( ! empty( $list['list_heading'] ) ) : ?>
				<h3><?php echo esc_html( $list['list_heading'] ); ?></h3>
			<?php endif; ?>

			<ul class="<?php echo esc_attr( implode( ' ', $list_classes ) ); ?>">
				<?php $item_counter = 0; foreach ( $items as $item ) : ?>
					<li class="<?php echo esc_attr( implode( ' ', $list_li_classes ) ); ?>">
						<?php $unique_item_id = 'link-list-item-' . $this->counter . '-' . $list_counter . '-' . $item_counter; ?>

						<a href="<?php echo esc_url( $item['href'] ); ?>"
							<?php if ( ! empty( $item['target'] ) ) : ?>
								target="<?php echo esc_attr( $item['target'] ); ?>"
							<?php endif; ?>
							<?php if ( '_blank' === $item['target'] ) : ?>
								rel="noopener noreferrer"
							<?php endif; ?>
							>
							<?php echo esc_html( $item['title'] ); ?>
						</a>
					</li>
				<?php
				$item_counter++;
				endforeach;
				?>
			</ul>
		</li>
	<?php
	$list_counter++;
	endforeach;
	?>
</ul>
