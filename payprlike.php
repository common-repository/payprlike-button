<?php
/**
 * @package PayPRLike
 */
/*
Plugin Name: PayPRLike Button
Plugin URI: http://payprlike.com/
Description:  Create PayPRLike Button on your blog
Version: 1.0
Author: Artsintez Media
Author URI: http://artsintez.md/
Text Domain: payprlike
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'PAYPRLIKE_VERSION', '1.0' );
define( 'PAYPRLIKE__MINIMUM_WP_VERSION', '3.0' );
define( 'PAYPRLIKE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PAYPRLIKE__PLUGIN_URL', plugin_dir_url( __FILE__ ) );

register_activation_hook( __FILE__, array( 'PayPRLike', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'PayPRLike', 'plugin_deactivation' ) );

require_once( PAYPRLIKE__PLUGIN_DIR . 'class.payprlike.php' );
require_once( PAYPRLIKE__PLUGIN_DIR . 'class.payprlike-widget.php' );

add_action( 'init', array( 'PayPRLike', 'init' ) );

if ( is_admin() ) {
	require_once( PAYPRLIKE__PLUGIN_DIR . 'class.payprlike-admin.php' );
	add_action( 'init', array( 'PayPRLike_Admin', 'init' ) );
}