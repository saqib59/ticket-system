<?php
/**
 * 
 */

namespace Inc\Base;
use Inc\Base\BaseController;
use Inc\Base\Activate;

class Enqueue extends BaseController{
	
	public function register(){
		add_action('admin_enqueue_scripts',array($this, 'enqueue'));
		add_action('init',
		    function ( ) {
		        Activate::registerCustomPostType();
		    }
		);
	}

		function enqueue(){
		 wp_enqueue_style('my_plugin_css',$this->plugin_url.'assets/main-style.css');
		 wp_enqueue_script('my_plugin_js',$this->plugin_url.'assets/myscript.js');
	}
}
?>