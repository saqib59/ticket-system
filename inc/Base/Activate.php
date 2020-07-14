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
	/*public static function registerCustomTaxonomy(){

	 $args_taxonomy = array(
	        'name'              => _x('Status', 'plural'),
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
	
	}*/
}

