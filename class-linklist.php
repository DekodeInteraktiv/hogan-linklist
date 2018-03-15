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

			$this->label             = __( 'Link lists', 'hogan-linklist' );
			$this->template          = __DIR__ . '/assets/template.php';
			$this->inner_wrapper_tag = 'nav';

			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );

			parent::__construct();
		}

		/**
		 * Enqueue module admin assets
		 *
		 * @return void
		 */
		public function enqueue_admin_assets() {
			$_version = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? time() : false;
			wp_enqueue_style( 'linklist-admin-style', plugins_url( '/assets/admin-style.css', __FILE__ ), [], $_version );
		}

		/**
		 * Field definitions for module.
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields() : array {

			$fields = [
				[
					'key'          => $this->field_key . '_flex',
					'label'        => '',
					'name'         => 'list_flex',
					'type'         => 'flexible_content',
					'button_label' => esc_html__( 'New list', 'hogan-linklist' ),
					'wrapper'      => [
						'class' => 'linklist-layouts',
					],
					'layouts'      => [
						[
							'key'        => $this->field_key . '_flex_manual',
							'name'       => 'manual',
							'label'      => esc_html__( 'Manual', 'hogan-linklist' ),
							'display'    => 'block',
							'sub_fields' => [
								[
									'key'   => $this->field_key . 'manual_list_heading',
									'label' => esc_html__( 'Heading', 'hogan-linklist' ),
									'name'  => 'list_heading',
									'type'  => 'text',
								],
								[
									'key'          => $this->field_key . '_manual_list',
									'label'        => '',
									'name'         => 'manual_list',
									'type'         => 'repeater',
									'min'          => 1,
									'layout'       => 'block',
									'button_label' => esc_html__( 'New link', 'hogan-linklist' ),
									'sub_fields'   => [
										[
											'key'      => $this->field_key . '_manual_link',
											'label'    => esc_html__( 'Set link and text', 'hogan-linklist' ),
											'name'     => 'link',
											'type'     => 'link',
											'return_format' => 'array',
											'required' => 1,
										],
									],
								],
							],
						],
						[
							'key'        => $this->field_key . '_flex_predefined',
							'name'       => 'predefined',
							'label'      => esc_html__( 'Predefined', 'hogan-linklist' ),
							'display'    => 'block',
							'sub_fields' => [
								[
									'key'   => $this->field_key . '_list_heading',
									'label' => esc_html__( 'Heading', 'hogan-linklist' ),
									'name'  => 'list_heading',
									'type'  => 'text',
								],
								[
									'key'           => $this->field_key . '_flex_predefined_list',
									'label'         => esc_html__( 'Select list', 'hogan-linklist' ),
									'name'          => 'predefined_list',
									'type'          => 'select',
									'allow_null'    => 1,
									// Translators: %s: Link to navigation menu.
									'instructions'  => sprintf( __( 'A predefined menu must be created <a href="%s">here</a> in order to show up in this dropdown.', 'hogan-linklist' ), admin_url() . 'nav-menus.php' ),
									'choices'       => [],
									'ui'            => 1,
									'ajax'          => 1,
									'return_format' => 'value',
									'placeholder'   => esc_html__( 'Select', 'hogan-linklist' ),
									'required'      => 1,
								],
							],
						],
						[
							'key'        => $this->field_key . '_flex_dynamic',
							'name'       => 'dynamic',
							'label'      => esc_html__( 'Dynamic selection', 'hogan-linklist' ),
							'display'    => 'block',
							'sub_fields' => [
								[
									'key'   => $this->field_key . '_dynamic_list_heading',
									'label' => esc_html__( 'Heading', 'hogan-linklist' ),
									'name'  => 'list_heading',
									'type'  => 'text',
								],
								[
									'type'          => 'select',
									'key'           => $this->field_key . '_flex_dynamic_list',
									'label'         => __( 'Content Type', 'hogan-linklist' ),
									'name'          => 'dynamic_list_content_type',
									'instructions'  => __( 'Select the content type to build linklist from', 'hogan-linklist' ),
									'required'      => 1,
									'wrapper'       => [
										'width' => '50',
									],
									'choices'       => apply_filters( 'hogan/module/linklist/dynamic_content_post_types', [
										'post' => __( 'Posts', 'hogan-linklist' ),
										'page' => __( 'Pages', 'hogan-linklist' ),
										'tax'  => __( 'Taxonomy', 'hogan-linklist' ),
									], $this ),
									'return_format' => 'value',
								],
								[
									'type'          => 'number',
									'key'           => $this->field_key . '_number_of_items',
									'label'         => __( 'Number of items', 'hogan-linklist' ),
									'name'          => 'number_of_items',
									'instructions'  => __( 'Set the number of items to display', 'hogan-linklist' ),
									'required'      => 1,
									'default_value' => 3,
									'min'           => 1,
									'max'           => 10,
									'step'          => 1,
									'wrapper'       => [
										'width' => '50',
									],
								],
								[
									'type'              => 'select',
									'key'               => $this->field_key . '_taxonomy_terms',
									'label'             => __( 'Select a taxonomy', 'hogan-linklist' ),
									'name'              => 'taxonomy_terms',
									'instructions'      => __( 'Display links to terms in selected taxonomy', 'hogan-linklist' ),
									'conditional_logic' => array(
										array(
											array(
												'field'    => $this->field_key . '_flex_dynamic_list',
												'operator' => '==',
												'value'    => 'tax',
											),
										),
									),
									'return_format'     => 'value',
									'choices'           => apply_filters( 'hogan/module/linklist/dynamic_content_taxonomies', [], $this, 'tax' ),
								],
							],
						],
					],
				],
			];

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

			$this->lists = is_array( $raw_content['list_flex'] ) ? $raw_content['list_flex'] : [];

			parent::load_args_from_layout_content( $raw_content, $counter );
		}

		/**
		 * Validate module content before template is loaded.
		 *
		 * @return bool Whether validation of the module is successful / filled with content.
		 */
		public function validate_args() : bool {
			return ! empty( $this->lists );
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
							'href'   => $link->url,
							'target' => $link->target,
							'title'  => $link->title,
						];
					}
					break;
				case 'manual':
					foreach ( $list['manual_list'] as $item ) {

						if ( empty( $item['link']['url'] ) ) {
							break;
						}

						$items[] = [
							'href'   => $item['link']['url'],
							'target' => $item['link']['target'],
							'title'  => hogan_get_link_title( $item['link'] ),
						];
					}
					break;
				case 'dynamic':
					if ( 'tax' === $list['dynamic_list_content_type'] ) {

						$terms = get_terms( array(
							'taxonomy' => $list['taxonomy_terms'],
							'number'   => $list['number_of_items'],
						) );

						foreach ( $terms as $item ) {
							$items[] = [
								'href'   => get_term_link( $item ),
								'target' => '',
								'title'  => $item->name,
							];
						}

						write_log( $terms );

					} else {
						$links_query = new \WP_Query( apply_filters( 'hogan/module/linklist/dynamic_content_query', [
							'fields'         => 'ids',
							'post_type'      => $list['dynamic_list_content_type'],
							'post_status'    => 'publish',
							'posts_per_page' => $list['number_of_items'],
						] ) );

						if ( $links_query->have_posts() ) {

							foreach ( $links_query->posts as $post_id ) {

								$items[] = [
									'href'   => get_permalink( $post_id ),
									'target' => '',
									'title'  => get_the_title( $post_id ),
								];

							}
						}
					}
					break;
				default:
					break;
			}

			return $items;
		}
	}
}
