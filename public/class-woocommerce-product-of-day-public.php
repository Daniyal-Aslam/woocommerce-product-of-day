<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wooninjas.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Of_Day
 * @subpackage Woocommerce_Product_Of_Day/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woocommerce_Product_Of_Day
 * @subpackage Woocommerce_Product_Of_Day/public
 * @author     WooNinjas <support@wooninjas.com>
 */
class Woocommerce_Product_Of_Day_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Product_Of_Day_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Product_Of_Day_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-product-of-day-public.css', array(), $this->version, 'all' ); 

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Product_Of_Day_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Product_Of_Day_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woocommerce-product-of-day-public.js', array( 'jquery' ), $this->version, false );

	}


	public function add_html() {

		$wn_potd_general_settings = get_option('wn_potd_general_settings');
	
		if (isset($wn_potd_general_settings['wn_product_of_day_allow']) && $wn_potd_general_settings['wn_product_of_day_allow']) {
	
			$wn_product_of_day_title = isset($wn_potd_general_settings['wn_product_of_day_title']) && !empty($wn_potd_general_settings['wn_product_of_day_title']) ? $wn_potd_general_settings['wn_product_of_day_title'] : 'Product of the Day';
	
	?>
	<div class="float-container">
		<a href="#" class="icon one">Product of the Day</a>
	
		<?php 
		// Get the selected product IDs from settings
		$wn_potd_feature_settings = get_option('wn_potd_feature_settings');
		$wn_product_of_day_selected_products = isset($wn_potd_feature_settings['wn_product_of_day_selected_product']) && !empty($wn_potd_feature_settings['wn_product_of_day_selected_product']) ? $wn_potd_feature_settings['wn_product_of_day_selected_product'] : '';
	
		// Check if multiple products are selected
		if (!empty($wn_product_of_day_selected_products) && is_array($wn_product_of_day_selected_products)) {
			foreach ($wn_product_of_day_selected_products as $product_id) {
				$product_id = intval($product_id);
				$productx = wc_get_product($product_id);
	
				if (is_object($productx)) {
					include_once(plugin_dir_path(__FILE__) . 'partials/woocommerce-product-of-day-public-display.php');
				}
			}
		}
		?>
	</div>
	<?php
		}
	}
	

}
