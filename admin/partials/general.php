<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wooninjas.com/
 * @since      1.0.0
 *
 * @package    Wn_Learndash_Feedback
 * @subpackage Wn_Learndash_Feedback/admin/partials
 */

$wn_potd_general_settings=get_option('wn_potd_general_settings');

$wn_product_of_day_title=isset($wn_potd_general_settings['wn_product_of_day_title'])&& !empty($wn_potd_general_settings['wn_product_of_day_title'])?$wn_potd_general_settings['wn_product_of_day_title']:'Product of the Day';

$wn_product_of_day_description=isset($wn_potd_general_settings['wn_product_of_day_description'])&& !empty($wn_potd_general_settings['wn_product_of_day_description'])?$wn_potd_general_settings['wn_product_of_day_description']:'Product of the Day Description!';
$product_of_day_allow =" ";
if( is_array( $wn_potd_general_settings ) && isset( $wn_potd_general_settings['wn_product_of_day_allow'] ) ){
   $product_of_day_allow =  $wn_potd_general_settings['wn_product_of_day_allow'];
}
// $feedback_allow_email_feedback =" ";
// if( is_array( $wn_potd_general_settings ) && isset( $wn_potd_general_settings['wn_feedback_allow_email_notification'] ) ){
//    $feedback_allow_email_feedback = $wn_potd_general_settings['wn_feedback_allow_email_notification'];
// }

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wn_potd_settings_wrap">
	 <form method="post" action="">
        <h2><?php _e( 'General Settings' ); ?></h2>
        <table class="setting-table-wrapper form-table" cellpadding="5" cellspacing="5">
            <tbody>
                <tr valign="top">
                    <th scope="row" class="titledesc">
                        <label for="wn_product_of_day_allow"><?php _e( 'Enable Product of the Day' ); ?> </label>
                        
                    </th>
                    <td class="forminp forminp-checkbox">
                        <fieldset>
                            <legend class="screen-reader-text"><span>Enable Product of the Day</span></legend> <label for="wn_product_of_day_allow">
                           <input type="checkbox" id="wn_product_of_day_allow" <?php echo $product_of_day_allow == 'on' ? 'checked="checked"' : ''; ?>name="wn_product_of_day_allow" />&nbsp;<?php _e( 'Yes' ); ?>
                        </label> <p class="description"><?php _e( 'Enable the Product of the Day option' ); ?></p></fieldset>
                    </td>
                </tr>
                <!-- <tr valign="top">
                    <th scope="row" class="titledesc">
                        <label for="wn_feedback_allow_email_notification"><?php //_e( 'Enable Admin Email Notifications' ); ?> </label>
                        
                    </th>
                    <td class="forminp forminp-checkbox">
                        <fieldset>
                            <legend class="screen-reader-text"><span>Enable on All Courses</span></legend> <label for="wn_feedback_allow_email_notification">
                           <input type="checkbox" id="wn_feedback_allow_email_notification" <?php //echo $feedback_allow_email_feedback == 'on' ? 'checked="checked"' : ''; ?>name="wn_feedback_allow_email_notification" />&nbsp;<?php //_e( 'Yes' ); ?>
                        </label> <p class="description"><?php //_e( 'Enable the Email Notifications for Admin when someone leaves a Feedback on any course.' ); ?></p></fieldset>
                    </td>
                </tr> -->
             <tr valign="top" class="forminp forminp-textarea">
                <th scope="row" class="titledesc"><label class="fa_toogle"><?php _e('Title'); ?>
                <i class="fas fa-question" data-tip="<?php echo sprintf( __('This title will be displayed on the Pop'));?>"></i>
            </label>
            <p class="description"> This title will be displayed on the Pop</p>
        </th>
                <td>
					<?php wp_editor( html_entity_decode($wn_product_of_day_title), "wn_product_of_day_title", $settings = array('textarea_rows' => 2,'media_buttons'=>false,'quicktags' => false,'tinymce'=> array('toolbar1'=> 'bold,italic,underline,separator,separator,link,unlink,undo,redo',))); ?>
                    
                </td>
            </tr>

         

             <tr valign="top" class="forminp forminp-textarea" style="display: none;">
                <th scope="row" class="titledesc"><label><?php _e('Description'); ?><i class="fas fa-question" data-tip="<?php echo sprintf( __('This description will be displayed on the Pop'));?>"></i></label></th>
                <td >
                    <?php wp_editor( html_entity_decode($wn_product_of_day_description), "wn_product_of_day_description", $settings = array('textarea_rows' => 2,'media_buttons'=>false,'quicktags' => false,'tinymce'=> array('toolbar1'=> 'bold,italic,underline,separator,separator,link,unlink,undo,redo'),'width' => 500)); 
                    ?>
                   
                </td>
            </tr>

            </tbody>
        </table>

        <div class="submit">
            <input type="submit" name="wn_potd_save_general_settings" class="button-primary wn-feedback-addon-btn" value="<?php _e( 'Update Settings' ); ?>">
        </div>
        <?php wp_nonce_field( 'wn_potd_general_settings', 'wn_potd_general_settings' ); ?>
    </form>
</div>
