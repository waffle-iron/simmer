<?php
/**
 * The plugin bootstrap
 *
 * @link http://simmerwp.com
 * @since 1.0.0
 * @package Simmer
 */

/**
 * Plugin Name: Simmer
 * Plugin URI:  http://simmerwp.com
 * Description: A recipe plugin for WordPress.
 * Version:     1.3.0-dev
 * Author:      BWD inc.
 * Author URI:  http://gobwd.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: simmer
 * Domain Path: /languages
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/** Constants **/

/**
 * The base plugin file path (this file).
 *
 * @since 1.0.3
 * @var string SIMMER_PLUGIN_FILE The base plugin file path.
 */
define( 'SIMMER_PLUGIN_FILE', plugin_basename( __FILE__ ) );

/**
 * Load the main Simmer class definition.
 */
require_once( plugin_dir_path( __FILE__ ) . 'core/class-simmer.php' );

// After all other plugins are loaded, instantiate Simmer.
Simmer::get_instance();
