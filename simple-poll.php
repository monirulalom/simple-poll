<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://monirulalom.com
 * @since             1.0.0
 * @package           Simple_Poll
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Poll
 * Plugin URI:        https://github.com/monirulalom/simple-poll
 * Description:       A plugin to add Yes/No poll to your WordPress site.
 * Version:           1.0.0
 * Author:            Md. Monirul Alom
 * Author URI:        https://monirulalom.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-poll
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
define( 'SIMPLE_POLL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-poll-activator.php
 */
function activate_simple_poll() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-poll-activator.php';
	Simple_Poll_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-poll-deactivator.php
 */
function deactivate_simple_poll() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-poll-deactivator.php';
	Simple_Poll_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_poll' );
register_deactivation_hook( __FILE__, 'deactivate_simple_poll' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-poll.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simple_poll() {

	$plugin = new Simple_Poll();
	$plugin->run();

}
run_simple_poll();
