<?php
/**
 * @package ticket_system_custom
 */

namespace Inc\Base;
use Inc\Base\BaseController;
use Inc\Base\Activate;

class Enqueue extends BaseController{

	public function register(){
		add_action('admin_enqueue_scripts',array($this, 'enqueue'));
		add_action('wp_enqueue_scripts',array($this, 'ticket_system_scripts'));
		add_action('init',
		    function ( ) {
		        Activate::registerCustomPostType();
		    }
		);
		add_action('init',
		    function ( ) {
		        Activate::addUserRoles();
		    }
		);
		add_action('init',
		    function ( ) {
		        Activate::createSqlTables();
		    }
		);
		add_action('init',
		    function ( ) {
		        Activate::addUserRoles();
		    }
		);

	}

	function enqueue($hook){
		 wp_enqueue_style('my_plugin_css',$this->plugin_url.'/assets/main-style.css');
		   		$menu_pages[0] = 'ticket-system_page_ticket-services';
	            /*$menu_pages[1] = 'toplevel_page_myplugin_myplugin-admin';
	            $menu_pages[2] = 'admin_page_wnm_fund_set';*/
	            foreach($menu_pages as $menu_slug){
	                 if ( $menu_slug == $hook ) {
	                    wp_enqueue_style( 'bootstrap-admin', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
	                 }
	            }
		/* wp_enqueue_style('admin-css','https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');*/
		wp_enqueue_script('admin-script',$this->plugin_url.'/assets/admin-script.js','','',true);
   		wp_localize_script('admin-script', 'the_ajax_script', array('ajaxurl' => admin_url('admin-ajax.php')));

	}

	function ticket_system_scripts($hook){

		$pages = array(
	        0 => 'ticket-system-create-ticket',
	        1 => 'ticket-sytem-dashboard',
	        2 => 'ticket-sytem-login',
	        3 => 'ticket-system-register',
	        4 => 'ticket-system-view-ticket'
	    );
        foreach ($pages as $index => $page_slug) {
        if (is_page($pages[$index])) {
        	wp_enqueue_style('wait-me-css',$this->plugin_url.'/assets/css/waitme.css');
			wp_enqueue_script('wait-me-js',$this->plugin_url.'/assets/js/waitme.js','','',true);
        	wp_enqueue_style('main-css',$this->plugin_url.'/assets/css/main-css.css');
	   		wp_enqueue_script( 'jquery-validate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js','','',true);
	   		wp_enqueue_script( 'sweet-alert', 'https://cdn.jsdelivr.net/npm/sweetalert2@9','','',true);
			wp_enqueue_script('main-script',$this->plugin_url.'/assets/main-script.js','','',true);
	   		wp_localize_script('main-script', 'the_ajax_script', array('ajaxurl' => admin_url('admin-ajax.php')));
        }
    }

   }
}
?>