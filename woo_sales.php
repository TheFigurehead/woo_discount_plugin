<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.linkedin.com/in/shkapenko-oleksii/
 * @since             1.0.0
 * @package           Woo_sales
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Sales
 * Plugin URI:        https://github.com/TheFigurehead/
 * Description:       Plugin to set discount for different conditions.
 * Version:           1.0.0
 * Author:            Alex
 * Author URI:        https://www.linkedin.com/in/shkapenko-oleksii/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo_sales
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
define( 'WOO_SALES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo_sales-activator.php
 */
function activate_woo_sales() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo_sales-activator.php';
	Woo_sales_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo_sales-deactivator.php
 */
function deactivate_woo_sales() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo_sales-deactivator.php';
	Woo_sales_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_sales' );
register_deactivation_hook( __FILE__, 'deactivate_woo_sales' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo_sales.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_sales() {

	
	if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
		add_action( 'admin_notices', function(){
			?>
			<div class="notice notice-error is-dismissible">
				<p>WooCommerce is not found.<strong>Please, activate it to use Woo Sales plugin.</strong>.</p>
			</div>
			<?php
		} );
	}else{
		$plugin = new Woo_sales();
		$plugin->run();
	}

}
run_woo_sales();
