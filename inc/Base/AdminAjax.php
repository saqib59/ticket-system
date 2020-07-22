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
	
}