<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://votingplugin.xyz
 * @since             1.0.0
 * @package           Voting_Plugin_Hrvoje
 *
 * @wordpress-plugin
 * Plugin Name:       Voting Plugin
 * Plugin URI:        https://votingplugin.xyz
 * Description:       Simple voting plugin
 * Version:           1.0.0
 * Author:            Hrvoje Antunović
 * Author URI:        https://votingplugin.xyz/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       voting-plugin-hrvoje
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
define( 'VOTING_PLUGIN_HRVOJE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-voting-plugin-hrvoje-activator.php
 */
function activate_voting_plugin_hrvoje() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-voting-plugin-hrvoje-activator.php';
	Voting_Plugin_Hrvoje_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-voting-plugin-hrvoje-deactivator.php
 */
function deactivate_voting_plugin_hrvoje() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-voting-plugin-hrvoje-deactivator.php';
	Voting_Plugin_Hrvoje_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_voting_plugin_hrvoje' );
register_deactivation_hook( __FILE__, 'deactivate_voting_plugin_hrvoje' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-voting-plugin-hrvoje.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_voting_plugin_hrvoje() {

	$plugin = new Voting_Plugin_Hrvoje();
	$plugin->run();

}
run_voting_plugin_hrvoje();
