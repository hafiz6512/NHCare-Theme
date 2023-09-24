<?php
/*
Plugin Name: Ignyte Services
Plugin URI: http://www.ignytebrands.com/
Description: Services Custom post type
Author: Javier Monrove, Eric Elliot
Version: 1.2.10
*/
define( 'IGNYTE_SERVICES_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'IGNYTE_SERVICES_PLUGIN_NAME', trim( dirname( IGNYTE_SERVICES_PLUGIN_BASENAME ), '/' ) );
define( 'IGNYTE_SERVICES_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'IGNYTE_SERVICES_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

include_once(IGNYTE_SERVICES_PLUGIN_DIR.'/services-custom-post.php');
include_once(IGNYTE_SERVICES_PLUGIN_DIR.'/services-shortcode.php');

/* TODO:
	Need to hook this up with the Locations, locations should be a selectable checkbox in the admin, kinda like a taxonomy, they want checkboxes
*/