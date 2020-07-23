

<div class="container-wrap">
	<div class="main-content container">
		<div class="row">

		</div><!--/row-->
	</div><!--/container-->
	<?php
	if (isset( $_GET['post_id']) && is_numeric($_GET['post_id'] ) && get_post($_GET['post_id']) && (get_post_type($_GET['post_id']) == 'tickets') ) {
		$post_id 		= $_GET['post_id'];

		$full_name 		= get_post_meta($post_id,'_mcf_user_name_custom',true);
		$service 		= get_post_meta($post_id,'_mcf_service_custom',true);
		$description 	= get_post_meta($post_id,'_mcf_desc_custom',true);
		$title 			= get_post_meta($post_id,'_mcf_ticket_title_custom',true);
		$state 			= get_post_meta($post_id,'_mcf_state_custom',true);
		$contact_no 	= get_post_meta($post_id,'_mcf_contact_custom',true);
		$zip_code	 	= get_post_meta($post_id,'_mcf_zipcode_custom',true);
		$date 		 	= get_post_meta($post_id,'_mcf_date_custom',true);
		$Address		= get_post_meta($post_id,'_mcf_address_custom',true);
		$comments_by_tech = get_post_meta($post_id,'_mcf_tech_comments_custom',true);

	?>
	<div id="main-area">
		<?php
			include('sidebars/sidebar.php');
		?>
	    <div id="content-rhs">
		    <div id="card">
		    	<div class="heading-btn">
		            <div class="row">
		              <div class="col span_6"><h1>Ticket Details</h1></div>  
			          <!-- <div class="col span_6 col_last"><button class="Create_tick">my ticket</button></div>  -->
			       </div>
			    </div>
		    	
			     <div class="form_box">
			     	<div class="row">
			     	<div class="form_fields">
			     		<div class="col span_4">
			     		<label>Ticket Id</label>
			     		<input type="text" readonly="" name="tck_id"  value=<?php echo !empty($post_id)? $post_id:''; ?>  >
			     		</div>
			     		<div class="col span_4">
			     		<label>Title</label>
			     		<input type="text" readonly="" name="Title" value=<?php echo !empty($title)? $title:''; ?> >
			     	</div>
			     		<div class="col span_4 col_last">
			     		<label>Customer Name</label>
			     		<input type="text" readonly="" name="customer_name" value=<?php echo !empty($full_name)? $full_name:''; ?> >
			     	</div>
			     	</div>
			     	<div class="form_fields">
			     		<div class="col span_4">
			     		<label>service</label>
			     		<input type="text" readonly="" name="service"  value=<?php echo !empty($post_id)? $post_id:''; ?>  >
			     		</div>
			     		<div class="col span_4">
			     		<label>State</label>
			     		<input type="text" readonly="" name="state"  value=<?php echo !empty($state)? $state:''; ?> >
			     	</div>
			     		<div class="col span_4 col_last">
			     		<label>Contact Number</label>
			     		<input type="text" readonly="" name="contact_no" value=<?php echo !empty($contact_no)? $contact_no:''; ?> >
			     	</div>
			     	</div>
			     		<div class="form_fields">
			     		<div class="col span_4">
			     		<label>Zip Code</label>
			     		<input type="text" readonly="" name="zip_code"  value=<?php echo !empty($zip_code)? $zip_code:''; ?>  >
			     		</div>
			     		<div class="col span_4">
			     		<label>Date</label>
			     		<input type="text" readonly="" name="customer_name"  value=<?php echo !empty($date)? $date:''; ?> >
			     	</div>
			     		<div class="col span_4 col_last">
			     		<label>Address</label>
			     		<input type="text" readonly="" name="service" value=<?php echo !empty($Address)? $Address:''; ?> >
			     	</div>
			     	</div>
			     	<div class="txt-area_box">
			     		<label>Description</label>
			     	   <textarea class="txt-area" readonly=""> <?php echo !empty($description)? $description:''; ?> </textarea>
			        </div>
			        <div class="txt-area_box">
			     		<label>Comments by Technician</label>
			     	   <textarea class="txt-area" readonly=""> <?php echo !empty($comments_by_tech)? $comments_by_tech:'No Comments Yet'; ?> </textarea>
			        </div>
			    </div>
			     </div>
            </div>
	    </div>
	</div>	
	<?php
	}
	elseif(wp_get_current_user()->roles[0] == 'ticket-system-tech' && isset($_GET['close_id'])){
			$post_id = $_GET['close_id'];
			$full_name 		= get_post_meta($post_id,'_mcf_user_name_custom',true);
			$service 		= get_post_meta($post_id,'_mcf_service_custom',true);
		?>

	<div id="main-area" class="myclass">
		<?php
		include("sidebars/sidebar.php"); 
		?>
	    <div id="content-rhs">
		    <div id="card">
		    	 <h1>Close ticket</h1>
			     <div class="form_box">
			     	<div class="row">
			     	<form id="close-ticket" method="post">
			     	<div class="form_fields">
			     		<div class="col span_4">
			     			<label>Ticket Id</label>
			     		<input type="number" name="tck_id" class="required" value="<?php echo !empty($post_id)? $post_id:''; ?>" readonly="">
			     		</div>
			     		<div class="col span_4">
			     			<label>Customer Name</label>
			     		<input type="text" name="customer_name" value="<?php echo !empty($full_name)? $full_name:''; ?>" readonly="">
			     		</div>
			     		<div class="col span_4 col_last">
			     			<label>Service</label>
			     		<input type="hidden" name="action" value="close_ticket">
			     		<input type="text" readonly="" name="service" value="<?php echo !empty($service)? $service:''; ?>" >
	    			</div>
			     	</div>
			     	<div class="txt-area_box">
			     	   <label>Comments</label>
			     	   <textarea class="txt-area required" name="comments_by_technician"> </textarea>
			     	   <button type="submit" class="submit" id="submit">Close</button>
			        </div>
			        </form>
			     </div>
			     </div>
            </div>
	    </div>
	</div>	
</div><!--/container-wrap-->

<?php
	 }
	 else{
 		?>
 		<p>Invalid Post ID</p>
 		<?php
	 }

 	
	?>