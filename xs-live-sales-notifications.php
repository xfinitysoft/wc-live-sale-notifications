<?php
/**
 * Plugin Name:Live Sale Notifications
 * Description:  Xfinity Soft woocommerce live sales notifications 
 * Version: 2.0.4
 * Author: XfinitySoft
 * Requires at least:   4.4.0
 * Tested up to:        6.0.0
 * WC requires at least: 4.0
 * WC tested up to:      6.0
 * Author URI: https://xfinitysoft.com
*/

/* Loading the text doamins for plugin */
load_plugin_textdomain( 'xslsn-live-sale-notification', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 

/* File is used to include the backend options for plugin */
require_once(plugin_dir_path(__FILE__)."xslsn-includes/xslsn-options.php");

/* These options are shown on the front end */
require_once(plugin_dir_path(__FILE__)."xslsn-includes/xslsn-frontendpopup.php");

function xslsn_register_default_settings(){
    $default_settings = Array(
        "xslsn-enable-notification" =>"on",
        "xslsn-enable-notification-mobile" =>"on",
        "xslsn-highlight-color" => "#f20d0d",
        "xslsn-text-color" =>"#ede8e8",
        "xslsn-background-color" =>"#000000",
        "xslsn-imagepadding" =>"5",
        "xslsn-template-style" =>"xslsn_style1",
        "xslsn-position" =>"xslsn_position_left",
        "xslsn-template-position" =>"xslsn_position_topright",
        "xslsn-custom-rounded-corner" =>"",
        "xslsn-timeclose" =>"0",
        "xslsn-closeiconcolor" =>"#ffffff",
        "xslsn-imageredirect" =>"on",
        "xslsn-linktarget" =>"on",
        "xslsn_desing_customcss" =>"",
        "xslsn-message-purchased" =>"{custom} {product} form {city} {state} {country} {time_ago}",
        "xslsn-message-custom" =>"{number} see people",
        "xslsn-message-minnumber" =>"1",
        "xslsn-message-maxnumber" =>"100",
        "xslsn_products_billing" =>"0",
        "xslsn-products-outofstock" =>"on",
        "xslsn-products-limit" =>"10",
        "xslsn-products-virtualfirstname" =>" ",
        "xslsn-products-virtualtime" =>"10",
        "xslsn-products-address" =>"xslsn-auto-detect",
        "xslsn-products-virtualcity" =>"",
        "xslsn-products-virtualcountry" =>"",
        "xslsn-products-ordertime" =>"365",
        "xslsn-products-ordertime-type" =>"xslsn_days",
        "xslsn-products-orderstatus" => Array
            (
                "0" =>"wc-pending",
                "1" =>"wc-processing",
                "2" =>"wc-on-hold",
                "3" =>"wc-completed",
                "4" =>"wc-cancelled",
                "5" =>"wc-refunded",
            ),

        "xslsn-products-imagesize" =>"xslsn_shop_thumbnail",
        "xslsn-productsdetails-runsingleproduct" =>"on",
        "xslsn-productsdetails-notificationshow" =>"0",
    );
    $setting = get_option('xslsn-live-sale-notification',true);
    if(!is_array($setting) || empty($setting )){
        update_option('xslsn-live-sale-notification',$default_settings);
    }
}
register_activation_hook( __FILE__, 'xslsn_register_default_settings');
