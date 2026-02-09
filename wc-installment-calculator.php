<?php
/**
 * @link     https://www.letsgodev.com/
 * @since    1.0.0
 * @package  wc-installment-calculator
 * 
 * Plugin Name:          Installment Calculator For WooCommerce
 * Plugin URI:           https://blog.letsgodev.com/
 * Description:          This plugin allows add a installment calculator to the shop
 * Version:              1.0.1
 * Author:               Lets Go Dev
 * Author URI:           https://www.letsgodev.com/
 * Developer:            Alexander Gonzales
 * Developer URI:        https://vcard.gonzalesc.org/
 * License:              GPL-3.0+
 * License URI:          https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:          wc-installment-calculator
 * Requires Plugins:     woocommerce
 * Requires PHP:         7.4
 * WP stable tag:        6.8.0
 * WP requires at least: 6.8.0
 * WP tested up to:      6.9
 * WC requires at least: 10.3.9
 * WC tested up to:      10.4.3
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'ICALCULATOR_FILE', __FILE__ );
define( 'ICALCULATOR_DIR', plugin_dir_path( __FILE__ ) );
define( 'ICALCULATOR_URL', plugin_dir_url( __FILE__ ) );
define( 'ICALCULATOR_BASE', plugin_basename( __FILE__ ) );


// External Libraries
require_once ICALCULATOR_DIR . 'vendor/autoload.php';

// Initialize Installment Calculator
function icalculator_init() {
	return \iCalculator\Core\iCalculator::getInstance();
}

icalculator_init();

