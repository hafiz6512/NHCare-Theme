<?php
/*
Plugin Name: Ignyte FAQs
Plugin URI: http://www.ignytebrands.com/
Description: FAQs Custom post type
Author: Javier Monrove, Eric Elliot
Version: 1.0
*/
define( 'IGNYTE_FAQS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'IGNYTE_FAQS_PLUGIN_NAME', trim( dirname( IGNYTE_FAQS_PLUGIN_BASENAME ), '/' ) );
define( 'IGNYTE_FAQS_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'IGNYTE_FAQS_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

include_once(IGNYTE_FAQS_PLUGIN_DIR.'/faqs-custom-post.php');
include_once(IGNYTE_FAQS_PLUGIN_DIR.'/faqs-shortcode.php');
 
/* TODO:
	Need to hook this up with the Locations, locations should be a selectable checkbox in the admin, kinda like a taxonomy, they want checkboxes
*/