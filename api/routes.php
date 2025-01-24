<?php

if (!defined('ABSPATH')) {
    exit;
}

 
add_action('rest_api_init', function () {

    $GLOBALS['user_id'] = get_current_user_id();

    register_rest_route('wn_potd/v1', '/general-settings', array(
        'methods' => 'GET',
        'callback' => 'wn_potd_get_general_settings',
        'permission_callback' => '__return_true',
    ));

    register_rest_route('wn_potd/v1', '/general-settings', array(
        'methods' => 'POST',
        'callback' => 'wn_potd_update_general_settings',
        'permission_callback' => '__return_true',
        'args' => array(
            'wn_product_of_day_title' => array(
                'required' => false,
                'type' => 'string',
            ),
            'wn_product_of_day_description' => array(
                'required' => false,
                'type' => 'string',
            ),
            'wn_product_of_day_allow' => array(
                'required' => false,
                'type' => 'string ',
            ),
        ),
    ));

    register_rest_route('wn_potd/v1', '/feature-settings', array(
        'methods' => 'GET',
        'callback' => 'wn_potd_get_feature_settings',
              'permission_callback' => '__return_true',
    ));

    register_rest_route('wn_potd/v1', '/feature-settings', array(
        'methods' => 'POST',
        'callback' => 'wn_potd_save_feature_settings',
              'permission_callback' => '__return_true',
        'args' => array(
            'wn_product_of_day_selected_product' => array(
                'required' => false,
                'type' => 'array',
                'items' => array(
                    'type' => 'integer',
                ),
            ),
        ),
    ));

    register_rest_route('wn_potd/v1', '/products', array(
        'methods'             => 'GET',
        'callback'            => 'wn_potd_get_all_products',
        'permission_callback' => '__return_true',
    ));
});
