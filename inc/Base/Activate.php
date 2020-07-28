<?php
/**
 * @package ticket_system_custom
 * @version 1.0
 */
namespace inc\Base;

class Activate extends BaseController{

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
		$table_name_1 = $wpdb->prefix . "ticket_services";
		$table_name_2 = $wpdb->prefix . "ticket_files";

		$charset_collate = $wpdb->get_charset_collate();

			if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name_1}'" ) != $table_name_1 ) {
			    $sql = "CREATE TABLE $table_name_1 (
			            ID mediumint(9) NOT NULL AUTO_INCREMENT,
			            `service_name` text NOT NULL,
			            created_at TIMESTAMP,
			            PRIMARY KEY  (ID)
			    )    $charset_collate;";

			    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			    dbDelta( $sql );
			    // add_option( 'my_db_version', $my_products_db_version );
			}

			if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name_2}'" ) != $table_name_2 ) {
			    $sql2 = "CREATE TABLE $table_name_2 (
			            ID BIGINT(20) NOT NULL AUTO_INCREMENT,
			            user_id BIGINT(20) NOT NULL,
			            file_name VARCHAR(225),
						 file_extension VARCHAR(225),
						 file_size VARCHAR(50),
						 file_location VARCHAR(225),
						 new_file_status TINYINT,
						 created_at TIMESTAMP,
						 updated_at TIMESTAMP,
						 status TINYINT,
						 sender_id BIGINT(20),
						 receiver_id BIGINT(20),
						 PRIMARY KEY (ID)
			    )    $charset_collate;";

			    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			    dbDelta( $sql2 );
			    // add_option( 'my_db_version', $my_products_db_version );
			}
		}
		public  function chatInclude(){
			require_once $this->plugin_path.'chat/ease_booking_main.php';

		}
}

