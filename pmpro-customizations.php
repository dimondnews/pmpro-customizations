<?php
/*
Plugin Name: PMPro Customizations
Plugin URI: https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
Description: Customizations for DIA PMPro
Version: .3
Author(s): Nicholas, Tomasz
*/
 
//use my Confirmation Page template
function my_pmpro_pages_shortcode_Confirmation($content)
{
	ob_start();
	include(plugin_dir_path(__FILE__) . "templates/confirmation.php");
	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
}
add_filter("pmpro_pages_shortcode_confirmation", "my_pmpro_pages_shortcode_confirmation");

function my_pmpro_pages_shortcode_checkout($content)
{
	ob_start();
	include(plugin_dir_path(__FILE__) . "templates/checkout.php");
	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
}
add_filter("pmpro_pages_shortcode_checkout", "my_pmpro_pages_shortcode_checkout");

/**
* Filter the settings of email frequency sent when using the Extra Expiration Warning Emails Add On
* https://www.paidmembershipspro.com/add-ons/extra-expiration-warning-emails-add-on/
*
* Update the $settings array to your list of number of days => ''.
* Read the Add On documentation for additional customization using this filter.
*/
function custom_pmproeewe_email_frequency( $settings = array() )
{
	$settings = array(
		0 => '',
		14 => '',
		30 => '',
	);
	return $settings;
}
add_filter( 'pmproeewe_email_frequency_and_templates', 'custom_pmproeewe_email_frequency', 10, 1 );


/**
 * Enqueue additional stylesheet.
 *
 * @return void
 */
function pmproc_preheader() {
    if ( ! is_admin() ) {
        wp_enqueue_style( 'pmproc_stylesheet', plugins_url( 'css/pmpro-customizations.css', __FILE__ ),
            array(), '1.0', 'all' );
    }
}
add_action( 'wp_enqueue_scripts', 'pmproc_preheader', 1 );

/**
 * Add this code to your PMPro Customizations Plugin - https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 * The my_pmpro_renew_membership_shortcode is a custom function creating a renew link for members and expired members.
 * Use the shortcode [pmpro_renew_button] to display the button anywhere on your site where shortcodes are recognized.
 *
 * @return string A link containing the URL string to renew.
 */
function my_pmpro_renew_membership_shortcode() {
    global $wpdb, $current_user, $pmpro_pages;
    // Current user empty (i.e. not logged in)
    if ( empty( $current_user ) ) {
        return;
    }

    $last_level_query = $wpdb->get_results("SELECT * FROM $wpdb->pmpro_memberships_users WHERE user_id = $current_user->ID ORDER BY id DESC LIMIT 1");
    $last_level = pmpro_getLevel( $last_level_query[0]->membership_id );
    $url = add_query_arg( 'level', $last_level->id, get_permalink( $pmpro_pages['checkout'] ) );

    // If the user did not ever have a membership level, show a sign up link
    if( empty( $last_level ) ) {
        return '<a class="pmpro-renew-button" href="' . esc_url( $url ) . '">Sign me up!</a>';
    }

    // Allow re-curring members to change or cancel
    elseif( $last_level->id == 3) {
        $url = get_permalink( $pmpro_pages['account'] );
        return '<a class="pmpro-renew-button" href="' . esc_url( $url ) . '">Update Membership!</a>';
    }

    // Everyone else
    else {
        return '<a class="pmpro-renew-button" href="' . esc_url($url) . '">Renew Membership</a>';
    }
}
add_shortcode( 'pmpro_renew_button', 'my_pmpro_renew_membership_shortcode' );