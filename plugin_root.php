<?php
/*
Plugin Name: Seraphinite Alternative Slugs Manager
Plugin URI: http://wordpress.org/plugins/seraphinite-old-slugs-mgr
Description: Avoid URL redirection errors by managing old and alternative slugs to improve SEO.
Text Domain: seraphinite-old-slugs-mgr
Domain Path: /languages
Version: 1.4
Author: Seraphinite Solutions
Author URI: https://www.s-sols.com
License: GPLv2 or later (if another license is not provided)
Requires PHP: 5.4
Requires at least: 4.5





 */




























if( defined( 'SERAPH_OSM_VER' ) )
	return;

define( 'SERAPH_OSM_VER', '1.4' );

include( __DIR__ . '/main.php' );

// #######################################################################

register_activation_hook( __FILE__, 'seraph_osm\\Plugin::OnActivate' );
register_deactivation_hook( __FILE__, 'seraph_osm\\Plugin::OnDeactivate' );
//register_uninstall_hook( __FILE__, 'seraph_osm\\Plugin::OnUninstall' );

// #######################################################################
// #######################################################################
