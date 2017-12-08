<?php
/**
 * LinkList module class.
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Hogan\\LinkList' ) && class_exists( '\\Dekode\\Hogan\\Module' ) ) {

	/**
	 * LinkList module class.
	 *
	 * @extends Modules base class.
	 */
	class LinkList extends Module {

		/**
		 * List type
		 *
		 * @var string $type
		 */
		public $type;

		/**
		 * List collection
		 *
		 * @var array $lists
		 */
		public $lists;

		/**
		 * Module constructor.
		 */
		public function __construct() {

			$this->label = __( 'Link lists', 'hogan-linklist' );
			$this->template = __DIR__ . '/assets/template.php';

			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );

			parent::__construct();
		}

		/**
		 * Enqueue module assets
		 *
		 * @return void
		 */
		public function enqueue_assets() {
			$_version = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? time() : false;
			wp_enqueue_style( 'linklist-admin-style', plugins_url( '/assets/admin-style.css', __FILE__ ), [], $_version );
		}

		/**
		 * Field definitions for module.
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields() : array {

			$fields = [];

			// Heading field can be disabled using filter hogan/module/linklist/heading/enabled (true/false).
			hogan_append_heading_field( $fields, $this );

			array_push(
				$fields,
				[
					'key' => $this->field_key . '_flex',
					'label' => '',
					'name' => 'list_flex',
					'type' => 'flexible_content',
					'button_label' => esc_html__( 'Add list', 'hogan-linklist' ),
					'wrapper' => [
						'class' => 'linklist-layouts',
					],
					'layouts' => [
						[
							'key' => $this->field_key . '_flex_manual',
							'name' => 'manual',
							'label' => esc_html__( 'Manual', 'hogan-linklist' ),
							'display' => 'block',
							'sub_fields' => [
								[
									'key' => $this->field_key . 'manual_list_heading',
									'label' => esc_html__( 'Heading', 'hogan-linklist' ),
									'name' => 'list_heading',
									'type' => 'text',
								],
								[
									'key' => $this->field_key . '_manual_list',
									'label' => 'Lenker',
									'name' => 'manual_list',
									'type' => 'repeater',
									'layout' => 'block',
									'button_label' => esc_html__( 'New link', 'hogan-linklist' ),
									'sub_fields' => [
										[
											'key' => $this->field_key . '_manual_link',
											'label' => esc_html__( 'Select link and set text', 'hogan-linklist' ),
											'name' => 'link',
											'type' => 'link',
											'return_format' => 'array',
											'wrapper' => [
												'width' => '50',
											],
										],
										[
											'key' => $this->field_key . '_manual_link_description',
											'label' => esc_html__( 'Short description', 'hogan-linklist' ),
											'name' => 'link_description',
											'type' => 'text',
											'wrapper' => [
												'width' => '50',
											],
										],
									],
								],
							],
						],
						[
							'key' => $this->field_key . '_flex_predefined',
							'name' => 'predefined',
							'label' => esc_html__( 'Predefined', 'hogan-linklist' ),
							'display' => 'block',
							'sub_fields' => [
								[
									'key' => $this->field_key . '_list_heading',
									'label' => esc_html__( 'Heading', 'hogan-linklist' ),
									'name' => 'list_heading',
									'type' => 'text',
								],
								[
									'key' => $this->field_key . '_flex_predefined_list',
									'label' => esc_html__( 'Select list', 'hogan-linklist' ),
									'name' => 'predefined_list',
									'type' => 'select',
									'allow_null' => 1,
									'instructions' => esc_html__( 'Define list under "Menu".', 'hogan-linklist' ),
									'choices' => [],
									'ui' => 1,
									'ajax' => 1,
									'return_format' => 'value',
									'placeholder' => esc_html__( 'Select', 'hogan-linklist' ),
								],
							],
						],
					],
				],
				[
					'key' => $this->field_key . '_type',
					'label' => esc_html__( 'List view type', 'hogan-linklist' ),
					'name' => 'list_type',
					'type' => 'button_group',
					'instructions' => '',
					'required' => 0,
					'choices' => [
						'lists' => '<i class="dashicons dashicons-list-view"></i> <span>' . esc_html__(  'Compact', 'hogan-linklist' ) . '</span>',
						'boxes' => '<i class="dashicons dashicons-exerpt-view"></i> <span>' . esc_html__(  'Wide', 'hogan-linklist' ) . '</span>',
					],
					'layout' => 'horizontal',
					'return_format' => 'value',
				]
			);
			return $fields;
		}

		/**
		 * Map raw fields from acf to object variable.
		 *
		 * @param array $raw_content Content values.
		 * @param int   $counter Module location in page layout.
		 * @return void
		 */
		public function load_args_from_layout_content( array $raw_content, int $counter = 0 ) {

			$this->type = $raw_content['list_type'] ?? '';
			$this->lists = is_array( $raw_content['list_flex'] ) ? $raw_content['list_flex'] : [];

			add_filter( 'hogan/module/linklist/inner_wrapper_tag', function() {
				return 'nav';
			} );

			parent::load_args_from_layout_content( $raw_content, $counter );
		}

		/**
		 * Validate module content before template is loaded.
		 *
		 * @return bool Whether validation of the module is successful / filled with content.
		 */
		public function validate_args() : bool {
			return ( ! empty( $this->lists ) && ! empty( $this->type ) );
		}

		/**
		 * Get list items.
		 *
		 * @param array $list The list.
		 * @return array Two dimensional array with keys href, target, title and description.
		 */
		public function get_list_items( array $list ) : array {

			$items = [];

			switch ( $list['acf_fc_layout'] ) {

				case 'predefined':
					$menu = $list['predefined_list'];
					foreach ( wp_get_nav_menu_items( $menu ) as $link ) {
						$items[] = [
							'href' => $link->url,
							'target' => '',
							'title' => $link->title,
							'description' => $link->description,
						];
					}
					break;
				case 'manual':
					foreach ( $list['manual_list'] as $item ) {

						if ( empty( $item['link']['url'] ) ) {
							break;
						}

						$items[] = [
							'href' => $item['link']['url'],
							'target' => $item['link']['target'],
							'title' => empty( $item['link']['title'] ) ? $item['link']['url'] : $item['link']['title'],
							'description' => $item['link_description'],
						];
					}
					break;
				default:
					break;
			}

			return $items;
		}
	}
}
