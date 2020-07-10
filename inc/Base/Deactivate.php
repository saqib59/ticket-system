<?php
/**
 * @package user_login_register
 * @version 1.0
 */
namespace Inc\Base;

class Deactivate{

	public static function deactivate(){
		// unregister_post_type( 'customposttype' );
		flush_rewrite_rules();
	}
}