<?php
/*
Plugin Name: PMPro Customizations by Nicholas
Plugin URI: https://www.paidmembershipspro.com/wp/pmpro-customizations/
Description: Customizations for my PMPro for DIA
Version: .1
Author: Nicholas
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