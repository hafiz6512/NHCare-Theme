<?php
/*
Plugin Name: Ignyte Provider Directory
Plugin URI: http://www.ignytebrands.com/
Description: Provider Directory Functionality
Author: Javier Monrove, Eric Elliot
Version: 1.2.10
*/
define( 'IGNYTE_PROVIDER_DIRECTORY_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'IGNYTE_PROVIDER_DIRECTORY_PLUGIN_NAME', trim( dirname( IGNYTE_PROVIDER_DIRECTORY_PLUGIN_BASENAME ), '/' ) );
define( 'IGNYTE_PROVIDER_DIRECTORY_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'IGNYTE_PROVIDER_DIRECTORY_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

include_once(IGNYTE_PROVIDER_DIRECTORY_PLUGIN_DIR.'/includes/custom_post.php');
include_once(IGNYTE_PROVIDER_DIRECTORY_PLUGIN_DIR.'/includes/shortcodes.php');
