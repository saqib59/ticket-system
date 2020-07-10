<?php
/**
 * 
 */

namespace inc\Pages;
use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;

class Admin extends BaseController
{
	public $settings;
	public $pages = array();
	public $subpages = array();

	public function __construct(){
		$this->settings = new SettingsApi();


		$this->pages = array(
				array(
					'page_title'	=>'ticket_system_custom', 
					'menu_title'	=>'Ticket System', 
					'capability'	=>'manage_options', 
					'menu_slug'		=>'my_plugin' ,
					'callback'		=> function(){echo "<h1>Admin</h1>";},
					'icon_url'		=>'dashicons-store',
					'position'		=> 110,
			)
		);

		$this->subpages = array(
					array(
						'parent_slug'	=> 'my_plugin', 
						'page_title'	=> 'Manage Services', 
						'menu_title'	=> 'Services', 
						'capability'	=> 'manage_options', 
						'menu_slug'		=> 'plugin_services', 
						'callback'		=> function(){echo "<h1>Services</h1>";}
				),
				
				
				// 	array(
				// 		'parent_slug'	=> 'my_plugin', 
				// 		'page_title'	=> 'Custom Taxonomies', 
				// 		'menu_title'	=> 'CPT', 
				// 		'capability'	=> 'manage_options', 
				// 		'menu_slug'		=> 'plugin_txon', 
				// 		'callback'		=> function(){echo "<h1>Custom Taxonomies</h1>";}
				// ),
				// 	array(
				// 		'parent_slug'	=> 'my_plugin', 
				// 		'page_title'	=> 'Custom Taxonomies', 
				// 		'menu_title'	=> 'CPT', 
				// 		'capability'	=> 'manage_options', 
				// 		'menu_slug'		=> 'plugin_txon', 
				// 		'callback'		=> function(){echo "<h1>Custom Taxonomies</h1>";}
				// ),
				// 	array(
				// 		'parent_slug'	=> 'my_plugin', 
				// 		'page_title'	=> 'Custom Taxonomies', 
				// 		'menu_title'	=> 'CPT', 
				// 		'capability'	=> 'manage_options', 
				// 		'menu_slug'		=> 'plugin_txon', 
				// 		'callback'		=> function(){echo "<h1>Custom Taxonomies</h1>";}
				// )
		); 
	}

	public function register(){

		$this->settings->addPages($this->pages)->withSubPage('Dashboard')->addSubPages($this->subpages)->register();

		// add_action('admin_menu',array($this, 'add_admin_pages') );
	}

	// public function add_admin_pages(){

	// 	add_menu_page('Login/Register', 'Login/Register', 'manage_options', 'my_plugin' , array($this, 'admin_index') ,'
	// 	dashicons-store',null);

	// }
	// public function admin_index(){

	// 	require_once $this->plugin_path.'templates/admin.php';

	// }
}
?>