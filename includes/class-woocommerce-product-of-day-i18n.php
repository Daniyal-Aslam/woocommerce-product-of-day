<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wooninjas.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Of_Day
 * @subpackage Woocommerce_Product_Of_Day/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Product_Of_Day
 * @subpackage Woocommerce_Product_Of_Day/includes
 * @author     WooNinjas <support@wooninjas.com>
 */
class Woocommerce_Product_Of_Day_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce-product-of-day',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
