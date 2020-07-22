<?php 
/*
Template Name: Create Ticket Template
*/
// if ($current_user->ID != 0) {
?>

<div class="container-wrap">
	<div class="container">
		<div class="row">
		</div><!--/row-->
	</div><!--/container-->
	<div id="main-area" class="myclass">
		<?php 
		include('sidebars/sidebar.php');
		?>
<!-- <div class="overlay">
    <div class="overlay__inner">
        <div class="overlay__content"><span class="spinner"></span></div>
    </div>
</div> -->
	    <div id="content-rhs">
		    <div id="card">
		        <div class="heading-btn">
		            <div class="row">
		              <div class="col span_6"><h1>Create ticket</h1></div>  
			          <div class="col span_6 col_last"></div> 
			       </div>
			    </div>
			    <div class="form_sec">
			    	<form id="create-ticket" method="POST">

			    	<div class="row">
			    		<div class="col span_6">
			    			<div class="field">
			    				<input type="text" name="ticket_title" class="required" placeholder="Title">
			    			</div>
			    		</div>
			    		<div class="col span_6 col_last">
			    			<div class="field">
			    				<input type="text" name="full_name" class="required" placeholder="Full Name">
			    			</div>
			    		</div>
			    		<div class="col span_6">
			    			<div class="field">
			    				<input type="text" name="Address" class="required" placeholder="Address">
			    			</div>			    			
			    		</div>
			    		<div class="col span_6 col_last">
			    			<div class="field">
			    				<select name="service" class="required">
			    					<option value="">:: Select Service::</option>
			    					<?php
								global $wpdb;
								$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."ticket_services ",OBJECT ); 
								foreach ($results as $row) {
								?>
								<option value="<?php echo $row->service_name; ?>"><?php echo $row->service_name; ?></option>
										<?php
					                }
					                ?>
			    				</select>
			    			</div>
			    		</div>
			    		<div class="col span_6">
			    			<div class="field">
			    				<input type="text" name="state" placeholder="State" class="required">
			    			</div>			    			
			    		</div>
			    		<div class="col span_6 col_last">
			    			<div class="field">
			    				<input type="number" name="contact_no" class="required" placeholder="Contact Number">
			    			</div>
			    		</div>
			    		<div class="col span_6">
			    			<div class="field">
			    				<input type="text" name="zip_code" class="required" placeholder="Zip Code">
			    			</div>			    			
			    		</div>
			    		<div class="col span_6 col_last">
			    			<div class="field">
			    			    <i class="fa fa-calendar" aria-hidden="true"></i>
			    			    <input type="text" class="required" name="date" placeholder="mm/dd/yy" data-select="datepicker">
			    			    <input type="hidden" name="action" value="create_ticket">
			    			    <input type="hidden" name="user_id" value=<?php echo $current_user->ID ; ?>>
			    			    <!-- <p>Pick a date on which you'd want the technicain to come for inspection.</p> -->
			    			</div>			    			
			    		</div>
			    		<div class="col span_12">
			    			<div class="field">
			    			    <textarea placeholder="Briefly describe the issue you are facing with the service." class="required" name="description"></textarea>
			    			</div>			    			
			    		</div>
			    		<div class="col span_12">
			    			<div class="field">
			    			    <button type="submit" class="create">Create ticket</button>
			    			</div>			    			
			    		</div>			    		
			    	</div>
			    	</form>
			    </div>
            </div>
	   </div>
    </div>	


</div><!--/container-wrap-->



<?php get_footer();
/*}
else{
	wp_redirect(home_url());
}*/ 
?>