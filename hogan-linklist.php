<?php
/**
 * Plugin Name: Hogan Module: Link list
 * Plugin URI: https://github.com/dekodeinteraktiv/hogan-linklist
 * GitHub Plugin URI: https://github.com/dekodeinteraktiv/hogan-linklist
 * Description: Link List Module for Hogan
 * Version: 1.1.5
 * Author: Dekode
 * Author URI: https://dekode.no
 * License: GPL-3.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * Text Domain: hogan-linklist
 * Domain Path: /languages/
 *
 * @package Hogan
 * @author Dekode
 */

declare( strict_types = 1 );
namespace Dekode\Hogan\LinkList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\\hogan_linklist_load_textdomain' );
add_action( 'hogan/include_modules', __NAMESPACE__ . '\\hogan_linklist_register_module', 10, 1 );

/**
 * Register module text domain
 */
function hogan_linklist_load_textdomain() {
	load_plugin_textdomain( 'hogan-linklist', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register module in Hogan
 *
 * @param \Dekode\Hogan\Core $core Hogan Core instance.
 * @return void
 */
function hogan_linklist_register_module( \Dekode\Hogan\Core $core ) {
	require_once 'class-linklist.php';
	require_once 'includes/helper-functions.php';
	$core->register_module( new \Dekode\Hogan\LinkList() );
}
