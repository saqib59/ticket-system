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
	public function adminSharedFiles(){
		return require_once("$this->plugin_path/templates/Admin/SharedFiles.php");
	}
	public function adminToUserShareFiles(){
		return require_once("$this->plugin_path/templates/Admin/adminToUserShareFiles.php");
	}
	public function isActiveFunctionality($input){
		return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
		return (isset($input)? true :false );
	}
	public function adminSectionManager($input){
		echo "";
	}

	public function checkboxField($args){
		$name = $args['label_for'];
		$class = $args['class'];
		$checkbox = get_option($name);
		echo '<label class="'.$class. '"><input type="checkbox" name="'.$name. '" value="1" id="'.$name. '" '.($checkbox ? 'checked' : '').' >
		<span class="slider round"></span>
			</label>';
	}
	
}