<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wooninjas.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Of_Day
 * @subpackage Woocommerce_Product_Of_Day/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for enqueuing the admin-specific React app.
 *
 * @package    Woocommerce_Product_Of_Day
 * @subpackage Woocommerce_Product_Of_Day/admin
 * @author     WooNinjas <support@wooninjas.com>
 */
class Woocommerce_Product_Of_Day_Admin {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the menu and enqueue scripts/styles for the admin React app.
     */
    public function admin_menu() {
        add_menu_page(
            __('Product of the Day', 'woocommerce-product-of-day'),
            __('Product of the Day', 'woocommerce-product-of-day'),
            'manage_options',
            $this->plugin_name,
            [$this, 'render_react_app'],
            'dashicons-welcome-widgets-menus',
            90
        );
    }

    /**
     * Enqueue scripts and styles for the admin React app.
     */
    public function enqueue_scripts($hook) {
        if ($hook === 'toplevel_page_' . $this->plugin_name) {
            wp_enqueue_script('react', 'https://unpkg.com/react@17/umd/react.development.js');
            wp_enqueue_script('react-dom', 'https://unpkg.com/react-dom@17/umd/react-dom.development.js');

            wp_enqueue_script(
                'woocommerce-product-of-day-react-app',
                plugin_dir_url(__FILE__) . 'build/main.js',
                ['react', 'react-dom', 'wp-element'],
                $this->version,
                true
            );

            wp_enqueue_style(
                'woocommerce-product-of-day-react-app',
                plugin_dir_url(__FILE__) . 'build/main.css ',
                [],
                $this->version
            );

            wp_localize_script(
                'woocommerce-product-of-day-react-app',
                'wpApiSettings',
                [
                    'root' => esc_url_raw(rest_url()),
                    'nonce' => wp_create_nonce('wp_rest'),
                ]
            );
        }
    }

    /**
     * Render the React app container.
     */
    public function render_react_app() {
        echo '<div id="woocommerce-product-of-day-app"></div>';
    }

    /**
     * AJAX handler to fetch general settings.
     */
    public function ajax_get_general_settings() {
        wp_send_json(get_option('wn_potd_general_settings', []));
    }

    /**
     * AJAX handler to save general settings.
     */
    public function ajax_save_general_settings() {
        if (isset($_POST['settings'])) {
            update_option('wn_potd_general_settings', $_POST['settings']);
            wp_send_json_success(__('Settings updated successfully!', 'woocommerce-product-of-day'));
        } else {
            wp_send_json_error(__('Invalid data received.', 'woocommerce-product-of-day'));
        }
    }

    /**
     * AJAX handler to load WooCommerce products.
     */
    public function ajax_load_products() {
        $search = isset($_REQUEST['search']) ? sanitize_text_field($_REQUEST['search']) : '';
        $page = isset($_REQUEST['page']) ? absint($_REQUEST['page']) : 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;

        $args = [
            'post_type' => 'product',
            'post_status' => 'publish',
            's' => $search,
            'posts_per_page' => $per_page,
            'offset' => $offset,
        ];

        $query = new WP_Query($args);
        $products = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $products[] = [
                    'id' => get_the_ID(),
                    'text' => get_the_title(),
                ];
            }
        }
        wp_reset_postdata();

        wp_send_json([
            'data' => $products,
            'total_count' => $query->found_posts,
        ]);
    }

    /**
     * Add plugin action links.
     */
    public function plugin_action_links($links) {
        $settings_link = '<a href="' . admin_url('admin.php?page=' . $this->plugin_name) . '">' . __('Settings', 'woocommerce-product-of-day') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    /**
     * Add branding to admin footer.
     */
    public function admin_footer_text($footer_text) {
        if (isset($_GET['page']) && $_GET['page'] === $this->plugin_name) {
            return __('Powered by <a href="https://wooninjas.com" target="_blank">WooNinjas</a>', 'woocommerce-product-of-day');
        }
        return $footer_text;
    }
}
