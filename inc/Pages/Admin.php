<?php
/**
 * @package user_ticket_system
 * @version 1.0
 *
*/

namespace inc\Pages;

use Inc\Base\Activate;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Base\ShortCodesUser;
use Inc\Api\CallBacks\AdminCallBacks;


class Admin extends BaseController
{
	public $settings;
	public $callbacks;
	public $pages = array();
	public $subpages = array();
	public $front_end_pages = array();

	public function register(){

		$this->settings = new SettingsApi();
		$this->callbacks = new AdminCallBacks();
		$this->setPages();
		$this->setSubPages();

		$this->setFrontEndPages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages($this->pages)->withSubPage('Settings')->addSubPages($this->subpages)->register();
		$this->settings->addFrontPages($this->front_end_pages)->register();
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
						'page_title'	=> 'Manage Status', 
						'menu_title'	=> 'Status', 
						'capability'	=> 'manage_options', 
						'menu_slug'		=> 'edit-tags.php?taxonomy=status&post_type=tickets', 
						'callback'		=> false,
						'position'		=> 1,
				),
					array(
						'parent_slug'	=> 'my_plugin', 
						'page_title'	=> 'Manage Services', 
						'menu_title'	=> 'Services', 
						'capability'	=> 'manage_options', 
						'menu_slug'		=> 'ticket-services', 
						'callback' 		=> array($this->callbacks, 'adminManageServices'),
						'position'		=> 2,
				),
					array(
						'parent_slug'	=> 'my_plugin', 
						'page_title'	=> 'File Sharing', 
						'menu_title'	=> 'File Sharing', 
						'capability'	=> 'manage_options', 
						'menu_slug'		=> 'ticket-file-sharing', 
						'callback' 		=> array($this->callbacks, 'adminToUserShareFiles'),
						'position'		=> 3,
				),
					/*array(
						'parent_slug'	=> 'my_plugin', 
						'page_title'	=> 'Shared Files', 
						'menu_title'	=> 'Shared Files', 
						'capability'	=> 'manage_options', 
						'menu_slug'		=> 'ticket-file-shared', 
						'callback' 		=> array($this->callbacks, 'adminSharedFiles'),
						'position'		=> 4,
				),*/
			); 
	}
	public function setFrontEndPages(){
			$this->front_end_pages = array(
				array(
					'post_title'	=>'Ticket System Login', 
					'post_name'		=>'ticket-system-login', 
					'post_content'	=>'[ticket_system_login]', 
					'post_status'	=>'publish' ,
					'post_author'	=> '1',
					'post_type'		=>'page',
			),
				array(
					'post_title'	=>'Ticket System Register', 
					'post_name'		=>'ticket-system-register', 
					'post_content'	=>'[ticket_system_register]', 
					'post_status'	=>'publish' ,
					'post_author'	=> '1',
					'post_type'		=>'page',
			),
				array(
					'post_title'	=>'Ticket System Dashboard', 
					'post_name'		=>'ticket-system-dashboard', 
					'post_content'	=>'[ticket_system_dashboard]', 
					'post_status'	=>'publish' ,
					'post_author'	=> '1',
					'post_type'		=>'page',
			),
				array(
					'post_title'	=>'Ticket System Create Ticket', 
					'post_name'		=>'ticket-system-create-ticket', 
					'post_content'	=>'[ticket_system_create_ticket]', 
					'post_status'	=>'publish' ,
					'post_author'	=> '1',
					'post_type'		=>'page',
			),
				array(
					'post_title'	=>'Ticket System View Ticket', 
					'post_name'		=>'ticket-system-view-ticket', 
					'post_content'	=>'[ticket_system_view_ticket]', 
					'post_status'	=>'publish' ,
					'post_author'	=> '1',
					'post_type'		=>'page',
			),
				array(
					'post_title'	=>'Ticket System File Sharing', 
					'post_name'		=>'ticket-system-files', 
					'post_content'	=>'[ticket_system_file_sharing]', 
					'post_status'	=>'publish' ,
					'post_author'	=> '1',
					'post_type'		=>'page',
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