<?php
/*
Plugin Name: Ignyte TimeLine
Plugin URI: http://www.ignytebrands.com/
Description: TimeLine History Plugin
Author: Naren
Version: 1.0
*/
define( 'IGNYTE_TIMELINE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'IGNYTE_TIMELINE_PLUGIN_NAME', trim( dirname( IGNYTE_TIMELINE_PLUGIN_BASENAME ), '/' ) );
define( 'IGNYTE_TIMELINE_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'IGNYTE_TIMELINE_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

include_once(IGNYTE_TIMELINE_PLUGIN_DIR.'/timeline-custom-post.php');
include_once(IGNYTE_TIMELINE_PLUGIN_DIR.'/timeline-shortcode.php');
 
/* TODO:
	Need to hook this up with the Locations, locations should be a selectable checkbox in the admin, kinda like a taxonomy, they want checkboxes
*/