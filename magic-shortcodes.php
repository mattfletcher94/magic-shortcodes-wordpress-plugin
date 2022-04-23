<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Magic_Shortcodes
 *
 * @wordpress-plugin
 * Plugin Name:       Magic Shortcodes - Create your own Shortcodes
 * Description:       Add lightweight and customizable popups to your WordPress site. You can choose to display your popups on specific pages. You can also display the popups at intervals (e.g. once a day, once a week).
 * Version:           1.0.0
 * Author:            Matt Fletcher
 * Author URI:        https://mattfletcher.name
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       magic-shortcodes
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MAGIC_SHORTCODES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-magic-shortcodes-activator.php
 */
function activate_magic_shortcodes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-magic-shortcodes-activator.php';
	Magic_Shortcodes_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-magic-shortcodes-deactivator.php
 */
function deactivate_magic_shortcodes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-magic-shortcodes-deactivator.php';
	Magic_Shortcodes_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_magic_shortcodes' );
register_deactivation_hook( __FILE__, 'deactivate_magic_shortcodes' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-magic-shortcodes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_magic_shortcodes() {

	$plugin = new Magic_Shortcodes();
	$plugin->run();

}
run_magic_shortcodes();
