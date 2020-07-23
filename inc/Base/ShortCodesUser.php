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
	add_shortcode( 'ticket_system_register', array($this,'frontendUserRegister'));	
	add_shortcode( 'ticket_system_create_ticket', array($this,'frontendUserCreateTicket'));	
	add_shortcode( 'ticket_system_view_ticket', array($this,'frontendUserViewTicket'));	
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
	public function frontendUserRegister(){
		 ob_start();
		require_once($this->plugin_path."/templates/frontendUserRegister.php");
		return ob_get_clean();
        
	}
	public function frontendUserCreateTicket(){
		 ob_start();
		require_once($this->plugin_path."/templates/frontendUserCreateTicket.php");
		return ob_get_clean();
        
	}
	public function frontendUserViewTicket(){
		 ob_start();
		require_once($this->plugin_path."/templates/frontendUserViewTicket.php");
		return ob_get_clean();
        
	}
	
}

/*$obj = new ShortCodesUser();
$obj->frontendDashboard();*/
