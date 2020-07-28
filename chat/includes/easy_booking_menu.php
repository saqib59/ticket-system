<?php 
function easy_boooking_menu(){
	require Easy_PATH.'/template/booking_inquiries.php';
}
function easy_boooking_chat_window(){
    require Easy_PATH.'/template/admin_chat_window.php';
}

add_action('admin_menu', function(){
	add_submenu_page( 'my_plugin', 'Chat Settings', 'Chat Settings', 'manage_options', 'ticket-system-chat-settings','easy_boooking_menu',4);
	add_submenu_page('my_plugin','Chat Window', 'Chat Window', 'manage_options', 'easy_boooking_chat_window', 'easy_boooking_chat_window',4);
});

