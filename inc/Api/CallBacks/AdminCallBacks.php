<?php 
/**
 * @package ticket_system_custom
 * @version 1.0
 *
*/

namespace Inc\Api\CallBacks;
use Inc\Base\BaseController;

class AdminCallBacks extends BaseController{
	public function adminDashboard(){
		return require_once("$this->plugin_path/templates/admin.php");
	}
	public function ticketOptionsGroup($input){
		return $input;
	}
	public function ticketAdminSection($input){
		return $input;
	}
	public function ticketTextExample($input){
		$value = esc_attr(get_option( 'text_example' ));
		echo "<input type='text' class='regular-text' name='text_example' value='".$value."' placeholder='Write'>";
	}
	public function adminManageServices(){
		return require_once("$this->plugin_path/templates/Admin/ManageServices.php");
	}
}