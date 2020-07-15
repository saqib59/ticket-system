<?php
/**
 * @package ticket_system_custom
 * @version 1.0
 */
namespace Inc\CustomFields;
use Inc\CustomFields\MyCustomFields;

class TechnicianField extends MyCustomFields{

	var $customFields = array(
        array(
            "name"          => "ticket_title_custom",
            "title"         => "Ticket Title",
            "description"   => "",
            "type"          => "text",
            "scope"         =>   array( "tickets" ),
            "capability"    => "edit_pages"
        ),
    ); 
    function __construct() {

            add_action( 'admin_menu', array( $this, 'createTechnicainField' ) );
            add_action( 'save_post', array( $this, 'saveTechnicainField' ), 1, 2 );
        }

    function createTechnicainField() {
        if ( function_exists( 'add_meta_box' ) ) {
            foreach ( $this->postTypes as $postType ) {
                add_meta_box( 'my-custom-fields', 'Custom Fields', array( $this, 'displayTechnicainField' ), $postType, 'normal', 'high' );
            }
        }
    }
    function saveTechnicainField() {
      /*  if ( function_exists( 'add_meta_box' ) ) {
            foreach ( $this->postTypes as $postType ) {
                add_meta_box( 'my-custom-fields', 'Custom Fields', array( $this, 'displayTechnicainField' ), $postType, 'normal', 'high' );
            }
        }*/
    }
    function displayTechnicainField() {
      /*  if ( function_exists( 'add_meta_box' ) ) {
            foreach ( $this->postTypes as $postType ) {
                add_meta_box( 'my-custom-fields', 'Custom Fields', array( $this, 'displayTechnicainField' ), $postType, 'normal', 'high' );
            }
        }*/
    }
}