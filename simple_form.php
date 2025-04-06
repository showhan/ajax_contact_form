<?php

/**
 * Simple Form
 *
 * Plugin Name: Simple Form
 * Plugin URI:
 * Description: A form plugin
 * Version:     0.0.1
 * Author:      Showhan Ahmed
 * Author URI:  http://showhan.net
 * Text Domain: SF
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );

// Plugin Defines
define( "SF_FILE", __FILE__ );
define( "SF_DIRECTORY", dirname(__FILE__) );
define( "SF_TEXT_DOMAIN", 'SF' );
define( "SF_DIRECTORY_BASENAME", plugin_basename( SF_FILE ) );
define( "SF_DIRECTORY_PATH", plugin_dir_path( SF_FILE ) );
define( "SF_DIRECTORY_URL", plugins_url( null, SF_FILE ) );

// Require the main class file
require_once( SF_DIRECTORY . '/includes/main-class.php' );
