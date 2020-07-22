<?php
/**
 * @package ticket_system_custom
 * @version 1.0
 */
namespace Inc\Base;

class Deactivate{

	public static function deactivate(){
		// unregister_post_type( 'customposttype' );
		flush_rewrite_rules();
	}
}