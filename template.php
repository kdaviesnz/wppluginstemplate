<?php
/**
Plugin Name: Template
Plugin URI:
Description:
Version: 0.0.0-alpha
Author: Kevin Davies
Author URI:
License: GPLv2 or later
 *
 * @package kdaviesnz/template
 */

declare( strict_types = 1 );

set_time_limit( 0 );

// Change this for production release.
error_reporting( E_ALL );

if ( file_exists( 'vendor/autoload.php' ) ) {
	require_once( 'vendor/autoload.php' );
}

require_once( 'src/itemplate.php' );
require_once( 'src/template.php' );
require_once( 'src/itemplateview.php' );
require_once( 'src/templateview.php' );
require_once( 'src/itemplatemodel.php' );
require_once( 'src/templatemodel.php' );

$template = new \kdaviesnz\template\Template();

/*
 Note: plugins_loaded hook is fired after the Wordpress files including the user's activated plugins are loaded
but before pluggable functions and Wordpress starts executing anything. It's the earliest plugin we can use
and hence our starting point.
 */
add_action( 'plugins_loaded', $template->onPluginsLoaded() );

register_activation_hook( __FILE__, $template->onActivation() );

register_deactivation_hook( __FILE__, $template->onDeactivation() );

