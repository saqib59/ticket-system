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
		parent::__construct();//explicit call to parent constructor
		$this->path = $this->plugin_path;
		
	}
	public function frontendDashboard(){
		echo "asdasd";
	var_dump($this->path);
	exit();	
/*		 ob_start();
		require_once($this->plugin_path."/templates/frontendDashboard.php");
		return ob_get_clean();*/
        
	}
}