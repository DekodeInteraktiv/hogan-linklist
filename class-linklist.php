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
		 * Module constructor.
		 */
		public function __construct() {

			$this->label = __( 'Link list', 'hogan-linklist' );
			$this->template = __DIR__ . '/template.php';

			parent::__construct();
		}

		/**
		 * Field definitions for module.
		 */
		public function get_fields() {

			$fields = [];

			// Heading field can be disabled using filter hogan/module/linklist/heading/enabled (true/false).
			hogan_append_heading_field( $fields, $this );

			// @todo:	$fields[] = [];

			return $fields;
		}

		/**
		 * Map fields to object variable.
		 *
		 * @param array $content The content value.
		 */
		public function load_args_from_layout_content( $content ) {

			$this->heading = $content['heading'] ?? null;
			// @todo: add fields.

			parent::load_args_from_layout_content( $content );
		}

		/**
		 * Validate module content before template is loaded.
		 */
		public function validate_args() {
			return true; // @todo validate fields.
		}
	}
}
