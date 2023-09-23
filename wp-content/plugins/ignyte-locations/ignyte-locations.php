<?php
/*
Plugin Name: Ignyte locations
Plugin URI: http://www.ignytebrands.com/
Description: Location Custom post type and Map Filtering
Author: Javier Monrove, Eric Elliot
Version: 1.2.10
*/
define( 'IGNYTE_LOCATIONS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'IGNYTE_LOCATIONS_PLUGIN_NAME', trim( dirname( IGNYTE_LOCATIONS_PLUGIN_BASENAME ), '/' ) );
define( 'IGNYTE_LOCATIONS_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'IGNYTE_LOCATIONS_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

include_once(IGNYTE_LOCATIONS_PLUGIN_DIR.'/location-custom-post.php');

include_once(IGNYTE_LOCATIONS_PLUGIN_DIR.'/location-shortcodes.php');

