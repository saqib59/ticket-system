<?php
/**
 * @package ticket_system_custom
 */

namespace Inc\Base;
use Inc\Base\BaseController;

class ShortCodesUser extends BaseController{
	public $path;
	public function __construct(){
	add_shortcode( 'ticket_system_dashboard', array($this,'frontendDashboard'));	
	add_shortcode( 'ticket_system_login', array($this,'frontendUserLogin'));	
		parent::__construct();//explicit call to parent constructor
		
	}
	public function frontendDashboard(){
		 ob_start();
		require_once($this->plugin_path."/templates/frontendDashboard.php");
		return ob_get_clean();
        
	}
	public function frontendUserLogin(){
		 ob_start();
		require_once($this->plugin_path."/templates/frontendUserLogin.php");
		return ob_get_clean();
        
	}
}

/*$obj = new ShortCodesUser();
$obj->frontendDashboard();*/
