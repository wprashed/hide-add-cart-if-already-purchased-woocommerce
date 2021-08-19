<?php

/**
 *
 * @link              wprashed.com
 * @since             1.0.0
 * @package           Hcap
 *
 * @wordpress-plugin
 * Plugin Name:       Hide Add Cart If Already Purchased - WooCommerce
 * Plugin URI:        wprashed.com/plugin
 * Description:       Hide Add Cart If Customer Already Purchased The Products
 * Version:           1.0.0
 * Author:            Md Rashed Hossain
 * Author URI:        wprashed.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hcap
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'HCAP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-hcap-activator.php
 */
function activate_hcap() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hcap-activator.php';
	Hcap_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-hcap-deactivator.php
 */
function deactivate_hcap() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hcap-deactivator.php';
	Hcap_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_hcap' );
register_deactivation_hook( __FILE__, 'deactivate_hcap' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-hcap.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_hcap() {

	$plugin = new Hcap();
	$plugin->run();

}

add_filter( 'woocommerce_is_purchasable', 'hcap_hide_add_cart_if_already_purchased', 9999, 2 );
 
function hcap_hide_add_cart_if_already_purchased( $is_purchasable, $product ) {
   if ( wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) {
      $is_purchasable = false;
   }
   return $is_purchasable;
}

run_hcap();
