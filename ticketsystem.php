<?php
/**
 * @package Ticket_system
 * @version 1.0
 */
/*
Plugin Name: Ticket System Custom
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: This plugin will generate a ticket system functionality.
Version: 1.0
Author URI: http://ma.tt/
*/

defined('ABSPATH') or die('You cant access this file' ); 
	if (file_exists(dirname(__FILE__).'/vendor/autoload.php' ) ) {

		require_once dirname(__FILE__).'/vendor/autoload.php' ;
	}

	use Inc\Base\Activate;
	use Inc\Base\Deactivate;

	function activate_ticket_plugin(){
		Activate::activate();
	}

	function deactivate_ticket_plugin(){
		Deactivate::deactivate();
	}

	register_activation_hook(__FILE__,'activate_ticket_plugin');
	register_deactivation_hook(__FILE__,'deactivate_ticket_plugin');

	if (class_exists( 'Inc\\Init' ) ) {
		inc\Init::register_services();
	}


/*
	$var = '';
	$array = array();

	$var = $array;*/
	
