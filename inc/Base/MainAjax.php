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
	                    "redirect_url" => home_url().'/ticket-sytem-login', 
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
                $redirect_dashboard  = home_url('/ticket-sytem-dashboard');
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
