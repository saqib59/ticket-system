<?php
 
/**
 * @package user_login_register
 * @version 1.0
 */
namespace Inc;
    
final class Init{
	 
	/**
	 * Store All the classes inside an array
	 * @return array full list of classes
	 */

	public static function get_services(){

		return array(
			Pages\Admin::class,
			Base\Enqueue::class,
			Base\SettingsLinks::class,
			CustomFields\MyCustomFields::class,
		);
	}

	/**
	 * Loop through the classes, initialize them, and call the register() if it exists
	 * @return
	 */
 

	public static function register_services(){

		foreach (self::get_services() as $class)  {
			$service = self::instantiate( $class );
			if (method_exists($service, 'register') ) {
				$service->register();

			}
		}
	}

	/**
	 * Initialize the class through the classes, initialize them, and call the register() if it exists
	 * @param  class from the services array
	 * @return class instance new instance of the class
	 */

	private static function instantiate ( $class ){
		$service = new $class();
		
		return $service;
	}

}

// use \inc\Activate; 
// use \inc\Deactivate; 
// use \inc\Admin\AdminPages;
// class main_class{
// 	//public
// 	// can be accessed everywhere

// 	//protected
// 	// can be accessed only within the class itself or extensions of this class

// 	//private
// 	// can be accessed only within the class itself

// 	public $plugin;

// 		/*CLASS CONSTRUCTOR*/
// 	function __construct(){
// 		$this->create_post_type();
// 		$this->plugin = plugin_basename(__FILE__);
// 	}
// 	function register(){
// 		add_action('admin_enqueue_scripts',array($this, 'enqueue'));

// 		add_action('admin_menu',array($this, 'add_admin_pages') );

// 		add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link') );

// 	}

// 	public function settings_link( $links ){
// 		//add custom settings link

// 		$settings_link = '<a href= "admin.php?page=my_plugin">Settings</a>';
// 		array_push($links,$settings_link);
// 		return $links;
// 	}

// 	public function add_admin_pages(){

// 		add_menu_page('Login/Register', 'Login/Register', 'manage_options', 'my_plugin' , array($this, 'admin_index') ,'
// 		dashicons-store',null);

// 	}
// 	public function admin_index(){

// 		require_once plugin_dir_path(__FILE__).'templates/admin.php';

// 	}

// 	protected function create_post_type(){
// 		add_action('init',array($this,'custom_post_type'));
// 	}

// 	function enqueue(){
// 		 wp_enqueue_style('my_plugin_css',plugins_url('/assets/main-style.css', __FILE__));
// 		 wp_enqueue_script('my_plugin_js',plugins_url('/assets/myscript.js', __FILE__));
// 	}
// 	function activate(){
// 		Activate::activate();
// 	}

// 	function custom_post_type(){
// 		register_post_type('login_system',['public' => true, 'label' => 'Login/Register']);
// 	}

// }

// 	if (class_exists('main_class')) {

// 		$main_class = new main_class();
// 		$main_class->register();
// 	}

// 	//activation
// 	register_activation_hook( __FILE__ , array('login_register_activate','activate'));



// 	//deactivation
// 	register_deactivation_hook( __FILE__ , array('Deactivate','deactivate'));


?>