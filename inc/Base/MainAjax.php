<?php
/**
 * @package ticket_system_custom
 * @version 1.0
 */
namespace Inc\Base;
use Inc\Base\BaseController;

class MainAjax {
    function __construct(){
        //register user
        add_action('wp_ajax_daily_user_registration_form', array($this,'ticketSystemUserRegister'));
        add_action('wp_ajax_nopriv_daily_user_registration_form', array($this,'ticketSystemUserRegister'));
        //login user
        add_action('wp_ajax_user_login', array($this,'ticketSystemUserlogin'));
        add_action('wp_ajax_nopriv_user_login', array($this,'ticketSystemUserlogin'));
        //create ticket
        add_action('wp_ajax_create_ticket', array($this,'ticketSystemCreateTicket'));
        add_action('wp_ajax_nopriv_create_ticket', array($this,'ticketSystemCreateTicket'));
        //close_ticket
        add_action('wp_ajax_close_ticket', array($this,'ticketSystemCloseTicket'));
        add_action('wp_ajax_nopriv_close_ticket', array($this,'ticketSystemCloseTicket'));
        //files-to-admin
        add_action('wp_ajax_send_files_to_admin', array($this,'ticketSystemSendToAdmin'));
        add_action('wp_ajax_nopriv_send_files_to_admin', array($this,'ticketSystemSendToAdmin'));
        //forgot_password
        add_action('wp_ajax_forgot_password', array($this,'ticketSystemForgotPswd'));
        add_action('wp_ajax_nopriv_forgot_password', array($this,'ticketSystemForgotPswd'));
    }

    function ticketSystemUserRegister(){
             if (empty($_POST['user_name']) || empty($_POST['email']) || empty($_POST['pass'])) {
         $response = array(
                    "message" =>"Fill out all required fields",
                    "error" => true
                );
        }
        if (email_exists(trim($_POST['email']))) {
            $response = array(
                        "message" =>"The E-mail , you enetered is already registered, Try another one.",
                        "error" => true
                    );
        }
        if (username_exists(trim($_POST['user_name']))) {
            $response = array(
                        "message" =>"Username , you enetered is already registered, Try another one.",
                        "error" => true
                    );
        }
        else{
                /** FORM REGISTRATION  **/
                $user_name =    trim($_POST['user_name']);
                $user_email =    trim($_POST['email']);    
                $user_password =    trim($_POST['pass']);   
                $userdata = array(
                'user_login' => $_POST['user_name'],
                'user_pass' => $_POST['pass'], // When creating a new user, `user_pass` is expected.
                'user_email' => $_POST['email'],
                'role' => 'ticket-system-user'
            );
            $user_id  = wp_insert_user($userdata);
            $response = array(
                        "message" =>"User registered",
                        "redirect_url" => home_url().'/ticket-system-login', 
                        "error" => false
                    );
           
        }
            return $this->responseJson($response);
    }


    function ticketSystemUserlogin(){
        $user_system_email = $_POST['user_name'];
        $user_system_password = $_POST['pass'];

        if (empty($user_system_email)) {
            $emailErr      = "Email/User Login is required";
            $err['error']  = $emailErr;
            $err['status'] = false;
        } 
        else {
            $user_system_email = $this->ticketSystemTestInput($user_system_email);
            // check if e-mail address is well-formed
            if (!filter_var($user_system_email, FILTER_VALIDATE_EMAIL)) {
                // it's not a email
                $userlogin_emailStatus = true;
            } else {
                // it's not a login
                $userlogin_emailStatus = false;
            }
        }

        //password
        if (empty($user_system_password)) {
            $passwordErr   = "Password is required";
            $err['error']  = $passwordErr;
            $err['status'] = false;
        } else {
            $user_system_password = $this->ticketSystemTestInput($user_system_password);
        }

    //REMEMBER ME
    if (isset($_POST['user_system_remember'])) {
        $remember_me = true;
    } else {
        $remember_me = false;
    }
    if ($userlogin_emailStatus == true) {
        $get_user = get_user_by('login', $user_system_email);
    } else {
        $get_user = get_user_by('email', $user_system_email);
    }
    $user_role = $get_user->roles[0];
    if ($user_role == 'ticket-system-user' || $user_role == 'ticket-system-tech') {

        //$get_user = get_user_by( 'email', $shears_email );
        if ($get_user != false) {

        // echo "<pre>".var_dump($user_role)."</pre>";
        if (wp_check_password($user_system_password, $get_user->data->user_pass, $get_user->ID)) {
            $creds = array(
                'user_login' => $get_user->data->user_login,
                'user_password' => $user_system_password,
                'remember' => $remember_me
            );
            $user  = wp_signon($creds, false);
            if (is_wp_error($user)) {
                $passwordErr   = "Can't login";
                $err['error']  = $passwordErr;
                $err['status'] = false;
                //return $user->get_error_message();
            } else {
                $redirect_dashboard  = home_url('/ticket-system-dashboard');
                //$redirect_dashboard  = home_url();
                $err['status']       = true;
                $err['redirect_url'] = $redirect_dashboard;
            }
        } 
        else {
            $passwordErr   = "Password is inncorrect";
            $err['error']  = $passwordErr;
            $err['status'] = false;
        }
      
    } else {
        $emailErr      = "User with this email doesn't exists";
        $err['error']  = $emailErr;
        $err['status'] = false;
       }
    }
    else{
        $emailErr      = "User with this email doesn't exists";
        $err['error']  = $emailErr;
        $err['status'] = false;
    }

        return $this->responseJson($err);
    }
    function ticketSystemForgotPswd(){
        $email = $_POST['email'];
        //check if the email is not in use yet
        $user_id = email_exists($email);
        if ($user_id) {
            // $random_password = wp_generate_password(16);

            $this->dtc_send_password_reset_mail($user_id);

            $err['message']  = "New Password has been sent to your email";
            $err['error'] = false;

        }
        else{
            $err['message']  = "User with this email doesn't exists";
            $err['error'] = true;
        }
        return $this->responseJson($err);
    }
    function ticketSystemCreateTicket(){
        if ( !empty($_POST['full_name'] ) ) {
         $post = array(
            'post_status'       => "publish",
            'post_title'        =>  $_POST['ticket_title'],
            'post_type'         => "tickets",
            'post_author'       => get_current_user_id(),
        );
         $post_id = wp_insert_post( $post );
         // wp_set_post_terms( $post_id, array('pend'), 'status');
         add_post_meta($post_id, '_mcf_ticket_title_custom',$_POST['ticket_title']);
         add_post_meta($post_id, '_mcf_user_name_custom',$_POST['full_name']);
         add_post_meta($post_id, '_mcf_address_custom',$_POST['Address']);
         add_post_meta($post_id, '_mcf_service_custom',$_POST['service']);
         add_post_meta($post_id, '_mcf_state_custom',$_POST['state']);
         add_post_meta($post_id, '_mcf_contact_custom',$_POST['contact_no']);
         add_post_meta($post_id, '_mcf_zipcode_custom',$_POST['zip_code']);
         add_post_meta($post_id, '_mcf_date_custom',$_POST['date']);
         add_post_meta($post_id, '_mcf_desc_custom',$_POST['description']);
         add_post_meta($post_id, '_mcf_user_id',$_POST['user_id']);

        ob_start();
        include(get_stylesheet_directory() .'/inc/email-template.php');
        $email_content = ob_get_contents();
        ob_end_clean();
        $headers = array('Content-Type: text/html; charset=UTF-8');
        // $email_array = array('rjones@pureproofinc.com','afarinella@pureproofinc.com','gcapardi@pureproofinc.com ');
        wp_mail('maxwilson908@gmail.com', "PureProof New Ticket Opened", $email_content, $headers);

        $response = array(
            "message" =>'Ticket Created Successfully',
            "error" => false
        );
    }
        else{
            $response = array(
                "message" =>'Oops! Something Missing',
                "error" => true
            );
        }
        return $this->responseJson($response);

    }
    function ticketSystemCloseTicket(){

            $ticket_id = $_POST['tck_id'];
            $post_type = get_post_type($ticket_id);
                if ( $post_type == 'tickets') {
                    $status = wp_get_post_terms($ticket_id,'status', array('fields' => 'all' ) );
                    
                    if ($status[0]->name == 'Closed') {
                          $response = array(
                            "message"   =>'Ticket Already Closed',
                            "error"     => true
                        );
                    }
                    else{
                        $terms = get_terms([
                                'taxonomy' => 'status',
                                'hide_empty' => false,
                                ]);
                         foreach ($terms as $term) {
                            if ($term->name == 'Closed' || $term->name == 'closed') {
                                    wp_set_post_terms( $ticket_id, array($term->term_id), 'status');
                            }
                        }
                         update_post_meta($ticket_id,'_mcf_tech_comments_custom',$_POST['comments_by_technician']);
                          $response = array(
                            "message"   =>'Ticket Closed Successfully!',
                            "error"     => false
                        );
                          
                    }
            }
        else{
                $response = array(
                "message"   =>'Ticket Does Not Exist!',
                "error"     => true
            );
        }
            return $this->responseJson($response);
    }

    function ticketSystemSendToAdmin(){
        date_default_timezone_set("America/New_York");
        $selected_users = 1;
        $user_ids =  explode(",",$selected_users);  // string to array
        //$errors = 0;
        $countfiles        = count($_FILES['admin-system-files']['name']);
        $admin_files = $_FILES['admin-system-files'];
        $check_file_exists = $admin_files['name'][0];
        if (empty($check_file_exists)) {
            $err['message']  = 'Kindly Select a file';
            $err['error'] = true;
            
        }
        if ($countfiles > 10) {

            $err['message']  = "Can't select files more than 10. You selected $countfiles  files.";
            $err['error'] = true;
            //$errors += 1;
        
        }

        if(count($user_ids) > 0){
            //$users_ids = array();
            $uu = 0;
            $files_names = array();
            foreach ($user_ids as $key => $value) {
                $uu++;
                $current_user_id = get_current_user_id();  
                $user_id = trim($value);
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
                                'user_id'           => $current_user_id,
                                'file_name'         => $new_name,
                                'file_extension'    => $fileExtension,
                                'file_size'         => $admin_files['size'][$file_looping],
                                'file_location'     => 'user_system_admin',
                                'created_at'        => $file_date,
                                'status'            => 1,
                                'sender_id'         => $current_user_id,
                                'receiver_id'       => 1001,
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
                    $err['message']  = "Error in creating folder";
                    $err['error'] = true;
                }

                /*ob_start();
                include(get_stylesheet_directory() .'/inc/file-email-user.php');
                $email_content = ob_get_contents();
                ob_end_clean();
                $headers = array('Content-Type: text/html; charset=UTF-8');
                $email_array = array('rjones@pureproofinc.com','afarinella@pureproofinc.com','gcapardi@pureproofinc.com');
                wp_mail($email_array, "New File Shared", $email_content, $headers);*/
            }
            
            
                    
            $err['message']  = "File(s) Successfully sent to admin ";
            // $err['redirect_url'] = home_url().'/wp-admin/admin.php?page=files-users';
            $err['error'] = false;
        } 
        else {
            $err['message']  = 'File is not sent to any selected user';
            $err['error']  = true;
            
        }
            return $this->responseJson($err);               
    }

    function dtc_send_password_reset_mail($user_id){

        $user = get_user_by('id', $user_id);
        $firstname = $user->first_name;
        $email = $user->user_email;
        $user_login = $user->user_login;

        $random_password = $user_login.'!@#^%34';
        wp_set_password( $random_password, $user_id );

        $rp_link= "<a href=".home_url()."/ticket-system-login>Here</a>";


        if ($firstname == "") $firstname = "User";
        $message = "Hi ".$firstname.",<br>";
        $message .= "An account has been created on ".get_bloginfo( 'name' )." for email address ".$email."<br>";
        $message .= "Your New Password Is ".$random_password ." Click ".$rp_link." to login";
        $message .= '<br>';

       $subject = __("Your account on ".get_bloginfo( 'name'));
       $headers = array();
       add_filter( 'wp_mail_content_type', function( $content_type ) {return 'text/html';});
       // $headers[] = 'From: Your company name <info@your-domain.com>'."\r\n";
       wp_mail( $email, $subject, $message, $headers);

       // Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
       remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
    }

    function responseJson($data){
        header('Content-Type: application/json');
        echo json_encode($data);
        wp_die();
    }
    function ticketSystemTestInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
