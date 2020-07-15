<?php
/**
 * 
 */

namespace inc\Pages;

use Inc\Base\Activate;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\CallBacks\AdminCallBacks;


class Admin extends BaseController
{
	public $settings;
	public $callbacks;
	public $pages = array();
	public $subpages = array();

	public function register(){

		$this->settings = new SettingsApi();
		$this->callbacks = new AdminCallBacks();
		$this->setPages();
		$this->setSubPages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages($this->pages)->withSubPage('Settings')->addSubPages($this->subpages)->register();

		// add_action('admin_menu',array($this, 'add_admin_pages') );
	}

	public function setPages(){
			$this->pages = array(
				array(
					'page_title'	=>'ticket_system_custom', 
					'menu_title'	=>'Ticket System', 
					'capability'	=>'manage_options', 
					'menu_slug'		=>'my_plugin' ,
					'callback'		=> array($this->callbacks, 'adminDashboard'),
					'icon_url'		=>'dashicons-store',
					'position'		=> 109,
			)
		);
	}
	public function setSubPages(){
				$this->subpages = array(
					array(
						'parent_slug'	=> 'my_plugin', 
						'page_title'	=> 'Manage Services', 
						'menu_title'	=> 'Services', 
						'capability'	=> 'manage_options', 
						'menu_slug'		=> 'edit-tags.php?taxonomy=status&post_type=tickets', 
						'callback'		=> false,
						'position'		=> 1,
				),
			); 
	}
	public function setSettings(){
		$args	 = array(
					array(
						'option_group'	=> 'ticket_options_group', 
						'option_name'	=> 'text_name', 
						'callback'		=> array($this->callbacks, 'ticketOptionsGroup'),
				),
			); 
		$this->settings->setSettings($args);

	}
	public function setSections(){
		$args	 = array(
					array(
						'id'			=> 'ticket_admin_index', 
						'title'			=> 'Settings', 
						'callback'		=> array($this->callbacks, 'ticketAdminSection'),
						'page'			=> 'my_plugin',

				),
			); 
		$this->settings->setSections($args);

	}
	public function setFields(){
		$args	 = array(
					array(
						'id'			=> 'text_name', 
						'title'			=> 'Text Example', 
						'callback'		=> array($this->callbacks, 'ticketTextExample'),
						'page'			=> 'my_plugin',
						'section'		=> 'ticket_admin_index',
						'args'			=> array(
							'label_for' => 'text_example',
							'class' 	=> 'example-class'
						),

				),
			); 
		$this->settings->setFields($args);

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