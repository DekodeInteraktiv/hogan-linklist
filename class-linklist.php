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
						'lists' => esc_html__( 'List view', 'hogan-linklist' ),
						'boxes' => esc_html__( 'Box view', 'hogan-linklist' ),
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
								'predefined' => esc_html__( 'Predefined list', 'hogan-linklist' ),
								'manual' => esc_html__( 'Manual list', 'hogan-linklist' ),
							],
							'layout' => 'vertical',
							'return_format' => 'value',
						],
						[
							'key' => $this->field_key . 'predefined_list',
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
							'key' => $this->field_key . 'manual_list',
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
									'key' => $this->field_key . 'manual_link',
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
			parent::load_args_from_layout_content( $content );
		}

		/**
		 * Validate module content before template is loaded.
		 */
		public function validate_args() {
			return ! empty( $this->collection );
		}
	}
}
