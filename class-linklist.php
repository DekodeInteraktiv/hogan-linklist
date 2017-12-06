<?php
/**
 * Link list module class
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
		 * @var array $collection
		 */
		public $collection;

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
					'key' => $this->field_key . '_type',
					'label' => esc_html__( 'Layout', 'hogan-linklist' ),
					'name' => 'list_type',
					'type' => 'button_group',
					'instructions' => '',
					'required' => 0,
					'choices' => [
						'lists' => '<i class="dashicons dashicons-list-view"></i>',
						'boxes' => '<i class="dashicons dashicons-exerpt-view"></i>',
					],
					'layout' => 'horizontal',
					'return_format' => 'value',
				],
				[
					'key' => $this->field_key . '_flex',
					'label' => '',
					'name' => 'list_flex',
					'type' => 'flexible_content',
					'conditional_logic' => [
						[
							[
								'field' => $this->field_key . '_type',
								'operator' => '==',
								'value' => 'lists',
							],
						],
					],
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
									'name' => 'lenker',
									'type' => 'repeater',
									'layout' => 'block',
									'button_label' => esc_html__( 'New link', 'hogan-linklist' ),
									'sub_fields' => [
										[
											'key' => $this->field_key . '_manual_link',
											'label' => '',
											'name' => 'link',
											'type' => 'link',
											'return_format' => 'array',
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
					'button_label' => esc_html__( 'Add list', 'hogan-linklist' ),
				],
				[
					'key' => $this->field_key . '_boxes_content_options',
					'label' => '',
					'name' => 'boxes_content',
					'type' => 'button_group',
					'wrapper' => [
						'width' => '20',
					],
					'conditional_logic' => [
						[
							[
								'field' => $this->field_key . '_type',
								'operator' => '==',
								'value' => 'boxes',
							],
						],
					],
					'choices' => [
						'manual' => esc_html__( 'Manual list', 'hogan-linklist' ),
						'predefined' => esc_html__( 'Predefined list', 'hogan-linklist' ),
					],
					'layout' => 'vertical',
					'return_format' => 'value',
				],
				[
					'key' => $this->field_key . '_boxes_list',
					'label' => '',
					'name' => 'boxes_list',
					'type' => 'repeater',
					'wrapper' => [
						'width' => '80',
					],
					'conditional_logic' => [
						[
							[
								'field' => $this->field_key . '_type',
								'operator' => '==',
								'value' => 'boxes',
							],
							[
								'field' => $this->field_key . '_boxes_content_options',
								'operator' => '==',
								'value' => 'manual',
							],
						],
					],
					'layout' => 'block',
					'button_label' => esc_html__( 'New link', 'hogan-linklist' ),
					'sub_fields' => [
						[
							'key' => $this->field_key . '_box_link',
							'label' => '',
							'name' => 'box_link',
							'type' => 'link',
							'return_format' => 'array',
						],
						[
							'key' => $this->field_key . '_box_link_description',
							'label' => esc_html__( 'Description', 'hogan-linklist' ),
							'name' => 'box_link_description',
							'type' => 'text',
						],
					],
				],
				[
					'key' => $this->field_key . '_boxes_predefined_list',
					'label' => esc_html__( 'Select list', 'hogan-linklist' ),
					'name' => 'box_predefined_list',
					'type' => 'select',
					'instructions' => esc_html__( 'Create list under "Menu".', 'hogan-linklist' ),
					'conditional_logic' => [
						[
							[
								'field' => $this->field_key . '_type',
								'operator' => '==',
								'value' => 'boxes',
							],
							[
								'field' => $this->field_key . '_boxes_content_options',
								'operator' => '==',
								'value' => 'predefined',
							],
						],
					],
					'wrapper' => [
						'width' => '80',
					],
					'choices' => [],
					'allow_null' => '1',
					'ui' => 1,
					'ajax' => 1,
					'return_format' => 'value',
					'placeholder' => esc_html__( 'Select', 'hogan-linklist' ),
				]
			);
			return $fields;
		}

		/**
		 * Map fields to object variable.
		 *
		 * @param array $content The content value.
		 *
		 * @return bool Whether validation of the module is successful / filled with content.
		 */
		public function load_args_from_layout_content( array $raw_content, int $counter = 0 ) {

			$this->type = $raw_content['list_type'] ?? null;
			$this->collection =  $raw_content['list_flex'] ?? '';
			$this->boxes = null;
			parent::load_args_from_layout_content( $raw_content, $counter );
		}

		/**
		 * Validate module content before template is loaded.
		 */
		public function validate_args() : bool {
			return ! empty( $this->collection );
		}
	}
}
