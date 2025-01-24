<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wooninjas.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Of_Day
 * @subpackage Woocommerce_Product_Of_Day/admin/partials
 */

$wn_potd_feature_settings=get_option('wn_potd_feature_settings');

$wn_product_of_day_selected_product = isset($wn_potd_feature_settings['wn_product_of_day_selected_product'])&& !empty($wn_potd_feature_settings['wn_product_of_day_selected_product'])?$wn_potd_feature_settings['wn_product_of_day_selected_product']:'';

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wn_potd_settings_wrap">
     <form method="post" action="">
        <h2><?php _e( 'Feature Settings' ); ?></h2>
        <table class="setting-table-wrapper form-table" cellpadding="5" cellspacing="5">
            <tbody>
              
            <tr valign="top" class="forminp forminp-textarea">
                <th scope="row" class="titledesc">
                    <label class="fa_toogle">
                        <?php _e('Select Products of The Day'); ?>
                        <span class="fas fa-question" data-tip="<?php echo sprintf(__('Selected products will show as Products of the Day.')); ?>"></span>
                    </label>
                    <p class="description">Selected products will show as Products of the Day.</p>
                </th>
                <td>
                    <?php 
                    $selected_products = !empty($wn_product_of_day_selected_product) ? (array) $wn_product_of_day_selected_product : [];
                    echo '<select name="wn_product_of_day_selected_product[]" class="wn_product_of_day_selected_product" id="wn_product_of_day_selected_product" multiple>';
                    
                    foreach ($selected_products as $product_id) {
                        echo '<option value="' . intval($product_id) . '" selected="selected">' . get_the_title($product_id) . '</option>';
                    }

                    echo '</select>';
                    ?>
                </td>
            </tr>


            </tbody>
        </table>

        <div class="submit">
            <input type="submit" name="wn_potd_save_features_settings" class="button-primary wn-feedback-addon-btn" value="<?php _e( 'Update Settings' ); ?>">
        </div>
        <?php wp_nonce_field( 'wn_potd_features_settings', 'wn_potd_features_settings' ); ?>
    </form>
</div>
