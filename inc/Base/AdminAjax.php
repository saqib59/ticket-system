<?php
/**
 * @package ticket_system_custom
 * @version 1.0
 */
namespace Inc\Base;

use Inc\Base\MainAjax;
class AdminAjax extends MainAjax{
	function __construct(){
		//add_service_to_admin
		add_action('wp_ajax_add_service_to_admin', array($this,'ticketSystemAddService'));
		add_action('wp_ajax_nopriv_add_service_to_admin', array($this,'ticketSystemAddService'));
        //Send files to selected users
        add_action('wp_ajax_send_files_selected', array($this,'ticketSystemShareFiles'));
        add_action('wp_ajax_nopriv_send_files_selected', array($this,'ticketSystemShareFiles'));
        //delete_service_from_admin
        add_action('wp_ajax_delete_file_from_admin', array($this,'ticketSystemDeleteFiles'));
        add_action('wp_ajax_nopriv_delete_file_from_admin', array($this,'ticketSystemDeleteFiles'));
        //delete_service_from_admin
        add_action('wp_ajax_delete_service_from_admin', array($this,'ticketSystemDeleteService'));
        add_action('wp_ajax_nopriv_delete_service_from_admin', array($this,'ticketSystemDeleteService'));
	}

    function ticketSystemAddService(){
         global $wpdb;
        if( empty($_POST['service_name'] ) ){
             $response = array(
                        "message" =>"Please Ener Service Name",
                        "error" => true
                    );
        }
        else{
            $data = array(
                'service_name' => $_POST['service_name']
            );
            $format = array('%s','%d');
            $wpdb->insert($wpdb->prefix.'ticket_services',$data,$format);
             $response = array(
                        "message" =>"New Service Inserted",
                        "error" => false
                    );
        }
            return $this->responseJson($response);
    }

    function ticketSystemShareFiles(){
        //$_FILES['file']['error']
    $selected_users = $_POST['selected_users'];
    if(!isset($selected_users) || empty($selected_users)){
        $err['error']  = 'Selected Users are not set.';
        $err['status'] = false;
    }
    else{
        date_default_timezone_set("America/New_York");
        $user_ids =  explode(",",$selected_users);  // string to array
        //$errors = 0;
        $countfiles        = count($_FILES['admin-system-files']['name']);
        $admin_files = $_FILES['admin-system-files'];
        $check_file_exists = $admin_files['name'][0];
        if (empty($check_file_exists)) {
            $err['error']  = 'Kindly Select a file';
            $err['status'] = false;
            
            //$errors += 1;

            /*echo json_encode($err);
            wp_die()*/;
        }
        if ($countfiles > 10) {

            $err['error']  = "Can't select files more than 10. You selected $countfiles  files.";
            $err['status'] = false;
            //$errors += 1;
            /*echo json_encode($err);
            wp_die();*/
        }

        if(count($user_ids) > 0){
            //$users_ids = array();
            $uu = 0;
            $files_names = array();
            foreach ($user_ids as $key => $value) {
                $uu++;
                $current_user_id = get_current_user_id();
                $user_id = trim($value);
                $user_info = get_userdata($user_id);
                $user_email = $user_info->user_email;
                $folder_location = ABSPATH . 'wp-content/uploads/user_system_admin';
                $folder_created  = wp_mkdir_p($folder_location);
                if ($folder_created == true) {
                    date_default_timezone_set("America/New_York");
                    //if($uu == 1){
                    for ($file_looping = 0; $file_looping < $countfiles; $file_looping++) {
                        
                        $original_name      = $admin_files['name'][$file_looping];
                        $attach_unique_name = $user_id.'_'.time();
                        $new_name           = $attach_unique_name.'_'.$original_name;
                        // Now we'll move the temporary file to this plugin's uploads directory.
                
                        $source             = $admin_files['tmp_name'][$file_looping];
                        $destination        = $folder_location.'/'.$new_name;

                        $file_status        = move_uploaded_file($source, $destination);
                        if($file_status == true){
                            $files_names[] = $destination;
                        }

                        if($uu > 1){
                                copy($_SESSION['all_files_names'][$file_looping],$destination);
                        
                        }
                        $path_parts         = pathinfo($original_name);
                        //file extension
                        $fileExtension      = $path_parts['extension'];
                        $file_date          = date("Y-m-d h:i:s");
                    
                        global $wpdb;

                        $tablename          = $wpdb->prefix.'ticket_files';
                        $staus_table_insert = $wpdb->insert($tablename, array(
                                'user_id'           => $user_id,
                                'file_name'         => $new_name,
                                'file_extension'    => $fileExtension,
                                'file_size'         => $admin_files['size'][$file_looping],
                                'file_location'     => 'user_system_admin',
                                'created_at'        => $file_date,
                                'status'            => 1,
                                'sender_id'         => 1001,
                                'receiver_id'       => $user_id,
                                'new_file_status'   => 0
                        ), array(
                            '%d',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%d',
                            '%d',
                            '%d',
                            '%d'
                        ));

                    }

                        $_SESSION['all_files_names'] = $files_names;
                }
                else{
                    $err['error']  = "Error in creating folder";
                    $err['status'] = false;
                   
                }
                
                /*ob_start();
                include(get_stylesheet_directory() .'/inc/file-email.php');
                $email_content = ob_get_contents();
                ob_end_clean();
                $headers = array('Content-Type: text/html; charset=UTF-8');
                wp_mail($user_email, "New File Shared", $email_content, $headers);*/
                
            }
                    
            $err['error']  = "File's Successfully sent to selected users ";
            $err['redirect_url'] = home_url().'/wp-admin/admin.php?page=files-users';
            $err['status'] = true;
        } 
        else {
            $err['error']  = 'File is not sent to any selected user';
            $err['status']  = false;
            
        }
                
    }
            
    // $err['error']  = "File's Successfully sent to selected users ";
    // $err['extra'] = 'working properly';
    // $err['status'] = false;

            return $this->responseJson($err);
    }
  
    function ticketSystemDeleteFiles(){
                   global $wpdb;
        if (empty($_POST['file_id'])) {
                    $response = array(
                        "message" =>"File Does not exists",
                        "error" => true
                    );
        }
        else{
            $wpdb->query(
                  "DELETE  FROM ".$wpdb->prefix."ticket_files
                   WHERE id = ".$_POST['file_id'].""
            );
             $response = array(
                        "message" =>"File Deleted!",
                        "error" => false
                    );
        }
            return $this->responseJson($response);

    }

    function ticketSystemDeleteService(){
           global $wpdb;
        if (empty($_POST['service_id'])) {
                    $response = array(
                        "message" =>"Service Does not exists",
                        "error" => true
                    );
        }
        else{
            $wpdb->query(
                  "DELETE  FROM ".$wpdb->prefix."ticket_services
                   WHERE ID = ".$_POST['service_id'].""
            );
            
             $response = array(
                        "message" =>"Service Deleted!",
                        "error" => false
                    );
        }
            return $this->responseJson($response);

    }
	
}