<?php


define('Easy_PATH', dirname(__FILE__));
$plugin = plugin_basename(__FILE__);
define('Easy_URL', plugin_dir_url($plugin));

require 'includes/class_main.php';
require 'includes/easy_booking_menu.php';
require 'includes/class_ajax.php';
require 'includes/Soachat.php';
require 'includes/custom_chat_action.php';




// Custom tmeplate
add_filter( 'page_template', 'wpa3396_page_template' );
function wpa3396_page_template( $page_template ){
    if ( is_page( 'global-chat' ) ) {
        $page_template = Easy_PATH. '/template/booking-main.php';
    }
    return $page_template;
}


// Styling and scripts
add_action('easy_booking', 'lms_scripts_styles');
function lms_scripts_styles(){
    echo '<link rel="stylesheet" href="'.Easy_URL.'assets/css/bootstrap.css">';
}



/**********************/
add_filter('bulk_actions-users', function($actions) {
    $actions['soachat'] = __('Add to Soachat', 'my-namespace');
    return $actions;
});

add_filter('handle_bulk_actions-users', function($redirect, $action, $ids) {
    if (get_option('chat_type') == 1){
        $video = 0;
    }else{
        $video = 1;
    }

    $soachat = new Soachat();
    foreach ($ids as $id) {
        $user = get_userdata($id);
        $soachat::addUser($id, $user->data->display_name, null, $video);
        add_user_meta($id, 'is_soa_chat', 1 , true);
    }
    $redirect_to = add_query_arg( 'soachat_bulk', 'Users are added into Soachat platform', $redirect );
    return $redirect_to;
}, 10, 3);

add_action( 'admin_notices', 'my_bulk_action_admin_notice' );
function my_bulk_action_admin_notice() {
    if ( ! empty( $_REQUEST['soachat_bulk'] ) ) {
        $emailed_count = $_REQUEST['soachat_bulk'];
        printf( '<div id="message" class="updated fade">' .
            _n( '%s',
                '%s',
                $emailed_count,
                'email_to_eric'
            ) . '</div>', $emailed_count );
    }
}








