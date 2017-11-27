<?php
/**
 * Link list module class
 *
 * @package Hogan
 */

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
		 * LinkList heading
		 *
		 * @var string $heading
		 */
		public $heading;

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

			parent::__construct();
		}

		/**
		 * Field definitions for module.
		 */
		public function get_fields() {

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
					'key' => $this->field_key . '_collection',
					'label' => esc_html__( 'Content', 'hogan-linklist' ),
					'name' => 'list_collection',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => [
						[
							[
								'field' => $this->field_key . '_type',
								'operator' => '==',
								'value' => 'lists',
							],
						],
					],
					'layout' => 'block',
					'button_label' => esc_html__( 'New list', 'hogan-linklist' ),
					'sub_fields' => [
						[
							'key' => $this->field_key . '_list_heading',
							'label' => esc_html__( 'Heading', 'hogan-linklist' ),
							'name' => 'list_heading',
							'type' => 'text',
						],
						[
							'key' => $this->field_key . '_list_content_options',
							'label' => '',
							'name' => 'list_content',
							'type' => 'button_group',
							'wrapper' => [
								'width' => '20',
							],
							'choices' => [
								'manual' => esc_html__( 'Manual list', 'hogan-linklist' ),
								'predefined' => esc_html__( 'Predefined list', 'hogan-linklist' ),
							],
							'layout' => 'vertical',
							'return_format' => 'value',
						],
						[
							'key' => $this->field_key . '_predefined_list',
							'label' => esc_html__( 'Select list', 'hogan-linklist' ),
							'name' => 'predefined_list',
							'type' => 'select',
							'instructions' => esc_html__( 'Define list under "Menu".', 'hogan-linklist' ),
							'conditional_logic' => [
								[
									[
										'field' => $this->field_key . '_list_content_options',
										'operator' => '==',
										'value' => 'predefined',
									],
								],
							],
							'wrapper' => [
								'width' => '80',
							],
							'choices' => [],
							'ui' => 1,
							'ajax' => 1,
							'return_format' => 'value',
							'placeholder' => esc_html__( 'Select', 'hogan-linklist' ),
						],
						[
							'key' => $this->field_key . '_manual_list',
							'label' => '',
							'name' => 'manual_list',
							'type' => 'repeater',
							'conditional_logic' => [
								[
									[
										'field' => $this->field_key . '_list_content_options',
										'operator' => '==',
										'value' => 'manual',
									],
								],
							],
							'wrapper' => [
								'width' => '80',
							],
							'layout' => 'block',
							'button_label' => esc_html__( 'Add link', 'hogan-linklist' ),
							'sub_fields' => [
								[
									'key' => $this->field_key . '_manual_link',
									'label' => '',
									'name' => 'link',
									'type' => 'link',
									'conditional_logic' => [
										[
											[
												'field' => $this->field_key . '_list_content_options',
												'operator' => '==',
												'value' => 'manual',
											],
										],
									],
									'return_format' => 'array',
								],
							],
						],
					],
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
					'button_label' => esc_html__( 'Add link', 'hogan-linklist' ),
					'sub_fields' => [
						[
							'key' => $this->field_key . '_box_link',
							'label' => '',
							'name' => 'link',
							'type' => 'link',
							'return_format' => 'array',
						],
						[
							'key' => $this->field_key . '_box_link_description',
							'label' => esc_html__( 'Description', 'hogan-linklist' ),
							'name' => 'link_description',
							'type' => 'text',
						],
					],
				],
				[
					'key' => $this->field_key . '_boxes_predefined_list',
					'label' => esc_html__( 'Select list', 'hogan-linklist' ),
					'name' => 'box_predefined_list',
					'type' => 'select',
					'instructions' => esc_html__( 'Define list under "Menu".', 'hogan-linklist' ),
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
		 */
		public function load_args_from_layout_content( $content ) {

			$this->heading = $content['heading'] ?? null;
			$this->type = $content['list_type'] ?? null;
			$this->collection = $content['list_collection'] ?? null;
			$this->boxes = [
				'content_type' => $content['boxes_content'] ?? null,
				'content' => 'predefined' === $content['boxes_content'] ? $content['box_predefined_list'] : $content['boxes_list'],
			];

			parent::load_args_from_layout_content( $content );
		}

		/**
		 * Validate module content before template is loaded.
		 */
		public function validate_args() {
			return ! empty( $this->collection ) || ! empty( $this->boxes );
		}
	}
}
