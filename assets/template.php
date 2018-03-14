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

$container_classes = hogan_classnames( apply_filters( 'hogan/module/linklist/container_classes', [ 'hogan-linklist-container', $this->type ], $this ) );
?>

<ul class="<?php echo esc_attr( $container_classes ); ?>">
	<?php
	$list_counter = 0;
	foreach ( $this->lists as $list ) :

		$items = $this->get_list_items( $list );

		if ( empty( $items ) ) {
			continue;
		}

		$container_li_classes = hogan_classnames( apply_filters( 'hogan/module/linklist/container_li_classes', [ 'hogan-linklist-inner' ], $this, $list, $items, $list_counter ) );
		$list_classes         = hogan_classnames( apply_filters( 'hogan/module/linklist/list_classes', [ 'hogan-linklist-items' ], $this, $list, $items, $list_counter ) );
		$list_li_classes      = hogan_classnames( apply_filters( 'hogan/module/linklist/list_li_classes', [ 'hogan-linklist-item' ], $this, $list, $items, $list_counter ) );

		?>
		<li class="<?php echo esc_attr( $container_li_classes ); ?>">
			<?php if ( ! empty( $list['list_heading'] ) ) : ?>
				<h3 class="hogan-linklist-title"><?php echo esc_html( $list['list_heading'] ); ?></h3>
			<?php endif; ?>

			<ul class="<?php echo esc_attr( $list_classes ); ?>">
				<?php
				foreach ( $items as $item ) {
					printf( '<li class="%s">', esc_attr( $list_li_classes ) );
					printf( '<a%s>',
						hogan_attributes( [
							'href'   => $item['href'],
							'target' => $item['target'],
							'rel'    => '_blank' === $item['target'] ? 'noopener noreferrer' : '',
						] )
					);

					/**
					 * Fires before link text has been added.
					 *
					 * @param array    $item Link item.
					 * @param LinkList $this Current module.
					 */
					do_action( 'hogan_linklist_before_linktext', $item, $this );

					echo esc_html( $item['title'] );

					/**
					 * Fires after link text has been added.
					 *
					 * @param array    $item Link item.
					 * @param LinkList $this Current module.
					 */
					do_action( 'hogan_linklist_after_linktext', $item, $this );

					echo '</a>';
					echo '</li>';
				}
				?>
			</ul>
		</li>
	<?php
	$list_counter++;
	endforeach;
	?>
</ul>
