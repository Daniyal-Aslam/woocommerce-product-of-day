<?php


if (!defined('ABSPATH')) {
    exit;
}

// Callback to get general settings
function wn_potd_get_general_settings()
{
    if ($GLOBALS['user_id'] == 0) {
        return rest_ensure_response(array(
            'code'    => 'rest_forbidden',
            'message' => __('You must be logged in to access this resource.', 'wn_potd'),
            'data'    => array('status' => 401),
        ));
    }

    $settings = get_option('wn_potd_general_settings', array());
    return rest_ensure_response($settings);
}

// Callback to update general settings
function wn_potd_update_general_settings($request)
{
    if ($GLOBALS['user_id'] == 0) {
        return rest_ensure_response(array(
            'code'    => 'rest_forbidden',
            'message' => __('You must be logged in to access this resource.', 'wn_potd'),
            'data'    => array('status' => 401),
        ));
    }
    $params = $request->get_json_params();

    $settings = array(
        'wn_product_of_day_title' => isset($params['wn_product_of_day_title']) ? sanitize_text_field($params['wn_product_of_day_title']) : '',
        'wn_product_of_day_description' => isset($params['wn_product_of_day_description']) ? sanitize_textarea_field($params['wn_product_of_day_description']) : '',
        'wn_product_of_day_allow' => isset($params['wn_product_of_day_allow']) && $params['wn_product_of_day_allow'] === 'on' ? 'on' : '',
    );

    update_option('wn_potd_general_settings', $settings);

    return rest_ensure_response(array(
        'success' => true,
        'message' => 'Settings updated successfully.',
        'data' => $settings,
    ));
}

// Callback to get feature settings
function wn_potd_get_feature_settings()
{
    if ($GLOBALS['user_id'] == 0) {
        return rest_ensure_response(array(
            'code'    => 'rest_forbidden',
            'message' => __('You must be logged in to access this resource.', 'wn_potd'),
            'data'    => array('status' => 401),
        ));
    }
    $settings = get_option('wn_potd_feature_settings', array());
    return rest_ensure_response($settings);
}

// Callback to save feature settings
function wn_potd_save_feature_settings($request)
{
    if ($GLOBALS['user_id'] == 0) {
        return rest_ensure_response(array(
            'code'    => 'rest_forbidden',
            'message' => __('You must be logged in to access this resource.', 'wn_potd'),
            'data'    => array('status' => 401),
        ));
    }
    $params = $request->get_json_params();

    $product_ids = isset($params['wn_product_of_day_selected_product']) ? (array) $params['wn_product_of_day_selected_product'] : array();
    $valid_product_ids = array();

    foreach ($product_ids as $product_id) {
        if (get_post_type(intval($product_id)) === 'product') {
            $valid_product_ids[] = intval($product_id);
        }
    }

    if (empty($valid_product_ids)) {
        return new WP_Error(
            'invalid_product_ids',
            __('No valid product IDs provided.', 'woocommerce-product-of-day'),
            array('status' => 400)
        );
    }

    $feature_settings = array(
        'wn_product_of_day_selected_product' => $valid_product_ids,
    );

    update_option('wn_potd_feature_settings', $feature_settings);

    return rest_ensure_response(array(
        'success' => true,
        'message' => __('Feature settings saved successfully.', 'woocommerce-product-of-day'),
        'data' => $feature_settings,
    ));
}
function wn_potd_get_all_products()
{
    if ($GLOBALS['user_id'] == 0) {
        return rest_ensure_response(array(
            'code'    => 'rest_forbidden',
            'message' => __('You must be logged in to access this resource.', 'wn_potd'),
            'data'    => array('status' => 401),
        ));
    }
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    );
    $products = get_posts($args);
    $product_list = array();
    foreach ($products as $product) {
        $wc_product = wc_get_product($product->ID);
        if ($wc_product) {
            $product_list[] = array(
                'id'   => $wc_product->get_id(),
                'name' => $wc_product->get_name(),
            );
        }
    }
    if (empty($product_list)) {
        return new WP_Error(
            'no_products',
            __('No products found.', 'wn_potd'),
            array('status' => 404)
        );
    }
    return rest_ensure_response($product_list);
}