<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://ringish.me/sem
 * @since             1.0.0
 * @package           Simple_Event_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Event Manager
 * Plugin URI:        http://ringish.me/sem
 * Description:       Manage event and handle registrations .
 * Version:           1.0.0
 * Author:            Simon Ring
 * Author URI:        http://ringish.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sem
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sem-activator.php
 */
function activate_sem() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sem-activator.php';
	SEM_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sem-deactivator.php
 */
function deactivate_sem() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sem-deactivator.php';
	SEM_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sem' );
register_deactivation_hook( __FILE__, 'deactivate_sem' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sem.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sem() {

	$plugin = new SEM();
	$plugin->run();

}
run_sem();
