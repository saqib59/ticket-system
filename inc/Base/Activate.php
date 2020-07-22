<?php
/**
 * @package user_login_register
 * @version 1.0
 */
namespace inc\Base;

class Activate{

	public static function activate(){	
		flush_rewrite_rules();
	}
	public static function registerCustomPostType(){
		        $supports = array(
        'title', // post title
        'editor', // post content
        // 'author', // post author
        'thumbnail', // featured images
        'excerpt', // post excerpt
        'custom-fields', // custom fields
        'comments', // post comments
        'revisions', // post revisions
        'post-formats', // post formats
    	);

	    $labels = array(
	    'name'              => _x('Tickects', 'plural'),
	    'singular_name'     => _x('Tickets', 'singular'),
	    'menu_name'         => _x('TicketSystem', 'TicketSystem'),
	    'name_admin_bar'    => _x('Tickets', 'admin bar'),
	    'view_item'         => __('View Tickets Property'),
	    'all_items'         => __('All Tickets'),
	    'search_items'      => __('Search Tickets Properties'),
	    'not_found'         => __('No Tickets Found.'),

	    );

	    $args = array(
	    'supports'          => array('thumbnail'),
	    'labels'            => $labels,
	    'public'            => true,
	    'query_var'         => true,
	    'rewrite'           => array('slug' => 'ticket'),
	    'menu_icon'         => 'dashicons-welcome-add-page',
	    'has_archive'       => true,
	    // 'show_in_admin_bar' => true,
	    'show_in_menu' 		=> 'my_plugin',
	    // 'show_in_nav_menus' => true,
	    'hierarchical'      => false,
	    'map_meta_cap'      => true,
	    'capabilities'      => array(
	                'create_posts' => true
	            )
	    );
	   

		register_post_type('tickets', $args);
		$args_taxonomy = array(
	        'name'              => _x('Status', 'plural'),
	        'menu_name' => __('News Categories', 'TicketSystem'),
	        'public'       => true,
	        'rewrite'      => false,
	        'hierarchical' => true
	    );

	    register_taxonomy('status',array('tickets'), array(
	        'hierarchical' => true,
	        'labels' 	=> $args_taxonomy,
		    'public'    => true,
	        'show_ui' 	=> true,
	        // 'show_in_menu' 		=> 'my_plugin',
	        'show_admin_column' => true,
	        'query_var' => true,
	        'rewrite' => array( 'slug' => 'tickets' ),
	      )
	);

	}
	public static function addUserRoles(){
		global $wp_roles;
		// $wp_roles = new WP_Roles();
		$current_roles = $wp_roles->get_names();
		if (!in_array('ticket-system-user', $current_roles) || !in_array('ticket-system-tech', $current_roles)) {
				add_role('ticket-system-user','Ticket System User');
    			add_role('ticket-system-tech','Ticket System Technician');			
		}
	}
	public static function createSqlTables(){

		global $wpdb;
		$table_name = $wpdb->prefix . "ticket_services";

		// $my_products_db_version = '1.0.0';
		$charset_collate = $wpdb->get_charset_collate();
/*$x = $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" );
				var_dump($x);exit();*/

			if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) != $table_name ) {
			    $sql = "CREATE TABLE $table_name (
			            ID mediumint(9) NOT NULL AUTO_INCREMENT,
			            `service_name` text NOT NULL,
			            created_at TIMESTAMP,
			            PRIMARY KEY  (ID)
			    )    $charset_collate;";

			    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			    dbDelta( $sql );
			    // add_option( 'my_db_version', $my_products_db_version );
			}
		}
}

