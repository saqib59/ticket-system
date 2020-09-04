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
		add_action('parent_file',array($this, 'menu_highlight'));
     
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
		        $ob = new Activate();
		        $ob->chatInclude();
		    }
		);

	}

	function enqueue($hook){
		// var_dump($hook);exit();
		 wp_enqueue_style('my_plugin_css',$this->plugin_url.'assets/css/admin-style.css');
		   		$menu_pages[0] = 'ticket-system_page_ticket-services';
	            $menu_pages[1] = 'ticket-system_page_ticket-file-shared';
	            $menu_pages[2] = 'ticket-system_page_ticket-file-sharing';
	            foreach($menu_pages as $menu_slug){
	                 if ( $menu_slug == $hook ) {
        				wp_enqueue_script( 'bootstrap-js-admin', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js','','',true);
	                    /*wp_enqueue_style( 'bootstrap-admin', 'http://localhost/Saqib/evangelist/wp-content/plugins/wordpress-general-api/assets/css/bootstrap.css');*/
        				wp_enqueue_style('bootstrap-admin',$this->plugin_url.'/assets/css/bootstrap.css');

   						wp_enqueue_style( 'datatable', 'https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css');

						wp_enqueue_script( 'datatable-js', 'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js','','',true);

	                 }
	            }
		/* wp_enqueue_style('admin-css','https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');*/
		wp_enqueue_script('admin-script',$this->plugin_url.'/assets/js/admin-script.js','','',true);
   		wp_localize_script('admin-script', 'the_ajax_script', array('ajaxurl' => admin_url('admin-ajax.php')));

	}

	function ticket_system_scripts($hook){

		$pages = array(
	        0 => 'ticket-system-create-ticket',
	        1 => 'ticket-system-dashboard',
	        2 => 'ticket-system-login',
	        3 => 'ticket-system-register',
	        4 => 'ticket-system-view-ticket',
	        5 => 'ticket-system-files',
	        6 => 'ticket-system-msg-board',
	        7 => 'ticket-system-forgot-pwd'
	    );
        foreach ($pages as $index => $page_slug) {
        if (is_page($pages[$index])) {
        	wp_enqueue_style('wait-me-css',$this->plugin_url.'/assets/css/waitme.css');
			wp_enqueue_script('wait-me-js',$this->plugin_url.'/assets/js/waitme.js','','',true);
        	wp_enqueue_style('main-css',$this->plugin_url.'/assets/css/main-css.css');
	   		wp_enqueue_script( 'jquery-validate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js','','',true);
	   		wp_enqueue_script( 'sweet-alert', 'https://cdn.jsdelivr.net/npm/sweetalert2@9','','',true);
			wp_enqueue_script('main-script',$this->plugin_url.'/assets/js/main-script.js','','',true);
	   		wp_localize_script('main-script', 'the_ajax_script', array('ajaxurl' => admin_url('admin-ajax.php')));
        }
    }

   }
      function menu_highlight( $parent_file ) {
        global $current_screen;

        $taxonomy = $current_screen->taxonomy;
        if ( $taxonomy == 'status' ) {
            $parent_file = 'my_plugin';
        }

        return $parent_file;
    }
}
?>