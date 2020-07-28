<?php 
/**
 * @package user_ticket_system
 * @version 1.0
 *
*/
namespace Inc\Api;

use Inc\Base\BaseController;
class SettingsApi{
	
	public $admin_pages = array();
	public $admin_subpages = array();
	public $frontend_pages = array();
	public $settings = array();
	public $sections = array();
	public $fields = array();

	public function register(){
		if (!empty($this->admin_pages)) {
			add_action('admin_menu',array($this, 'addAdminMenu')); 
		}
		if (!empty($this->frontend_pages)) {
			 add_action('init',array($this, 'addFrontEndPages')); 
			 add_action('get_header',array($this, 'redirectHomeIfLogOut')); 
			 add_action('get_header',array($this, 'redirectHomeIfLogIn')); 
		}
		if (!empty($this->settings)) {
			add_action('admin_init',array($this, 'registerCustomFields')); 
		}
	}

	public function addPages(array $pages){

		$this->admin_pages = $pages;

		return $this;
	}
	public function addFrontPages(array $pages){

		$this->frontend_pages = $pages;

		return $this;
	}
	public function withSubPage(string $title = null){

		if (empty($this->admin_pages)) { 

			return $this;
		} 

		$admin_page = $this->admin_pages[0]; 

		$subpage = array(
				array(
					'parent_slug'	=> $admin_page['menu_slug'], 
					'page_title'	=> $admin_page['page_title'], 
					'menu_title'	=> ($title)? $title: $admin_page['menu_title'],
					'capability'	=> $admin_page['capability'], 
					'menu_slug'		=> $admin_page['menu_slug'], 
					'callback'		=> $admin_page['callback'],
					'position'		=> $admin_page['position'],
			)
		); 

		$this->admin_subpages = $subpage;
  
		return $this;

	}

	public function addSubPages(array $pages){

		$this->admin_subpages = array_merge($this->admin_subpages,$pages);
		return $this;
		
	}
	public function addFrontEndPages(){	

		foreach ($this->frontend_pages as $fpage) {
			$check_availability = get_page_by_path($fpage['post_name'],OBJECT);
			if (!isset($check_availability)) {
			wp_insert_post(array(
    				'post_title' => $fpage['post_title'],
    				'post_name' => $fpage['post_name'],
    				'post_content' => $fpage['post_content'],
    				'post_status' => $fpage['post_status'],
    				'post_author' => $fpage['post_author'],
    				'post_type' => $fpage['post_type'],
		) );
			}


			// add_menu_page(,$page['post_name'],$page['post_content'],$page['post_status'],$page['post_author'],$page['post_type']);
		}

	}

	public function addAdminMenu(){	

		foreach ($this->admin_pages as $page) {

			add_menu_page($page['page_title'],$page['menu_title'],$page['capability'],$page['menu_slug'],$page['callback'],$page['icon_url'],$page['position']);
		}

		foreach ($this->admin_subpages as $page) {
		
			add_submenu_page($page['parent_slug'],$page['page_title'],$page['menu_title'],$page['capability'],$page['menu_slug'],$page['callback'],$page['position']);
		}


	}

	public function setSettings(array $settings){

		$this->settings = $settings;

		return $this;
	}
	public function setSections(array $sections){

		$this->sections = $sections;

		return $this;
	}
	public function setFields(array $fields){

		$this->fields = $fields;

		return $this;
	}

	public function registerCustomFields(){
		foreach ($this->settings as $setting) {
		//register setting
		register_setting( $setting["option_group"], $setting["option_name"], (isset($setting["callback"])?$setting["callback"]: '') );
	}
		foreach ($this->sections as $section) {

		//add settings section
		add_settings_section( $section["id"], $section["title"], (isset($section["callback"])?$section["callback"]: ''), $section["page"] );
	}
		foreach ($this->fields as $field) {

		//add settings field
		add_settings_field( $field["id"], $field["title"], (isset($field["callback"])?$field["callback"]: ''), $field["page"] ,  $field["section"], (isset($field["args"])?$field["args"]: '') );
	}

  }

  public function redirectHomeIfLogOut(){
  		$current_user_id = get_current_user_id();
	    $pages = array(
	        0 => 'ticket-system-create-ticket',
	        1 => 'ticket-system-dashboard',
	        2 => 'ticket-system-view-ticket',
	        3 => 'ticket-system-files',
	        // 4 => 'view-challange'
	    );
        foreach ($pages as $index => $page_slug) {
        if (is_page($pages[$index]) && $current_user_id == 0) {
            wp_redirect(home_url());
        }
    }
  }
  public function redirectHomeIfLogIn(){
  		 $current_user_id = get_current_user_id();
	    $pages = array(
	        0 => 'ticket-system-register',
	        1 => 'ticket-system-login'
	    );
        foreach ($pages as $index => $page_slug) {
        if (is_page($pages[$index]) && $current_user_id != 0) {
            wp_redirect(home_url());
        }
    }			
  }
}
?>