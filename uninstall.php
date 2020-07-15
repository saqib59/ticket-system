<?php

/**
* Trigger this file on plugin unistall
* @package user_login_register
* 
*/

if (!defined('WP_UNINSTALL_PLUGIN')) {
	die();
}


// Access the database via SQL

global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'login_system'" );

$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );

$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");