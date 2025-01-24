<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wooninjas.com/
 * @since             1.0.0
 * @package           Woocommerce_Product_Of_Day
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Product of Day
 * Plugin URI:        https://wooninjas.com/
 * Description:       It allows admin to setup the product of the day, which is going to be displayed through pop-up to visitors.
 * Version:           1.0.0
 * Author:            WooNinjas
 * Author URI:        https://wooninjas.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-product-of-day
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}



/**
 * Set plugin FILE to access it globally
 */
define('WOOCOMMERCE_PRODUCT_OF_DAY_FILE', __FILE__);



/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WOOCOMMERCE_PRODUCT_OF_DAY_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-product-of-day-activator.php
 */
function activate_woocommerce_product_of_day()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-woocommerce-product-of-day-activator.php';
    Woocommerce_Product_Of_Day_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-product-of-day-deactivator.php
 */
function deactivate_woocommerce_product_of_day()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-woocommerce-product-of-day-deactivator.php';
    Woocommerce_Product_Of_Day_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_woocommerce_product_of_day');
register_deactivation_hook(__FILE__, 'deactivate_woocommerce_product_of_day');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-woocommerce-product-of-day.php';

require_once plugin_dir_path(__FILE__) . 'api/methods.php';

require_once plugin_dir_path(__FILE__) . 'api/routes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_product_of_day()
{

    $plugin = new Woocommerce_Product_Of_Day();
    $plugin->run();
}


function woocommerce_product_of_day_require_dependency()
{

    // Check if WooCommerce is enabled
    if (file_exists(ABSPATH . 'wp-admin/includes/plugin.php')) {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    if (! class_exists('WooCommerce')) {
        unset($_GET['activate']);  //unset this to hide default Plugin activated. notice
        deactivate_plugins(plugin_basename(__FILE__), true);
        $class = 'notice is-dismissible error notice-rating';
        $message = __('WooCommerce Product of Day requires <a href="https://www.woocommerce.com">WooCommerce</a> plugin to be activated.', 'woocommerce-variation-addon');
        printf("<div id='message' class='%s'> <p>%s</p></div>", $class, $message);
    }
}




function woocommerce_product_of_day_load()
{

    if (! class_exists('WooCommerce')) {
        add_action('admin_notices', 'woocommerce_product_of_day_require_dependency');
        return false;
    } else {
        run_woocommerce_product_of_day();
    }
}

add_action('plugins_loaded', 'woocommerce_product_of_day_load');




