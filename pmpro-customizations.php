<?php
/*
Plugin Name: PMPro Customizations by Nicholas
Plugin URI: https://www.paidmembershipspro.com/wp/pmpro-customizations/
Description: Customizations for DIA PMPro
Version: .2
Author(s): Nicholas, Tomasz
Author URI: https://www.tion.solutions
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

