
<div class="container-wrap">
	<div class='container'>
		<div class="row">
			
		</div><!--/row-->
	</div><!--/container-->
<!-- <div id="myModal" class="modal">
  <div class="modal-content">
      <div class="ater_box">
          <span>!</span>
      </div>
      <div class="content_box">
         <p>Alert</p>
         <h6>Would you like to delete the ticket?</h6>
      </div>
      <div class="btn_box">
         <button class="noBtn" id="noDel">No</button>
         <button class="yesBtn" id="yesDel">yes</button>
     </div>
  </div>
</div> 	 -->

		<?php 
    // var_dump(wp_get_current_user());
		if (wp_get_current_user()->roles[0] == 'ticket-system-user') {
		?>
<div class="toggle_bar"> 
	<a href="javascript:void(0)" class="myToggle"> 
		<div></div>
        <div></div>
        <div></div>
	</a>
</div>	
<?php
  // include("phoneMenu/phone_menu.php");
?>			
	<div id="main-area">
		<?php 
		 include('sidebars/sidebar.php');
		?>
	<div id="content-rhs">
		<div id="card">
			<h1>User - ticket Dashboard</h1>
			<a href="<?= home_url().'/ticket-system-create-ticket'; ?>" id="button">Create New Ticket</a>
			<!-- <button class="Create_tick">Create New ticket</button> -->
			<table id="myTable" class="cell-border" style="width:100%" >
        <thead>
            <tr>
                <th>ticket id</th>
                <th>Date</th>
                <th>Title</th>
                <th>Status</th>
                <th>more</th>
            </tr>
        </thead>
        <tbody>
        		<?php
        	                     $the_query =  new WP_Query( array('posts_per_page' => -1,
                                 'post_type'       => 'tickets',
                                 'post_status'     => array('publish'),
                                 'order'           => 'DESC',
                                 // 'paged'           => get_query_var('paged') ? get_query_var('paged') : 1,
                                 'meta_query'      =>
                                    array(
                                       array(
                                           'relation' => 'OR',
                                         array(
                                        'key' => '_mcf_user_id',
                                        'value' => get_current_user_id()
                                       )
                                            
                                  )
                                    )
                                 )
                              );
                      if ( $the_query->have_posts() ) { 
                      		while ( $the_query->have_posts() ) {
								$the_query->the_post();
								$post_id 	= get_the_ID();
								$title 		= get_post_meta( $post_id, '_mcf_ticket_title_custom', true );
								$full_name 	= get_post_meta( $post_id, '_mcf_user_name_custom', true );
								$Address 	= get_post_meta( $post_id, '_mcf_address_custom', true );
								$service 	=  get_post_meta( $post_id, '_mcf_service_custom', true );
								$date 		= get_post_meta( $post_id, '_mcf_date_custom', true );
								$status 	= wp_get_post_terms($post_id,'status', array('fields' => 'all' ) );
						

								?>
								   <tr>
					                <td><?php echo $post_id; ?></td>
					                <td><?php echo $date; ?></td>
					                <td><?php echo $title; ?></td>
									<td><?php echo ((empty($status))? '': $status[0]->name); ?></td>
					                <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i>
					                   <div id="myPop">
					                       <ul>
					                           <li><a href="<?= home_url().'/ticket-system-view-ticket?post_id='.$post_id; ?>" ><i class="fa fa-eye" aria-hidden="true"></i> View </a></li>
					                           <!-- <li><a href="#" id="myBtn"><i class="fa fa-trash" aria-hidden="true"></i> delete file</a></li> -->
					                       </ul>
					                   </div>
					                </td>
            						</tr>    
								<?php

                      		}
                      }
                      ?>
                       
        </tbody>
    </table>
    </div>
	</div>
	</div>	
	<?php
}
else{

	?>

<div class="toggle_bar"> 
	<a href="javascript:void(0)" class="myToggle"> 
		<div></div>
        <div></div>
        <div></div>
	</a>
</div>	
<?php
  // include("phoneMenu/phone_menu.php");
?>	
	<div id="main-area">
		<?php 
		include('sidebars/sidebar.php');
		?>
	<div id="content-rhs">
		<div id="card">
			<h1>Technician - ticket Dashboard</h1>
			<!-- <button class="Create_tick">Create New ticket</button> -->
			<table id="myTable" class="cell-border" style="width:100%" >
        <thead>
            <tr>
                <th>ticket id</th>
                <th>Date</th>
                <th>Title</th>
                <th>Status</th>
                <th>more</th>
            </tr>
        </thead>
        <tbody>
        		<?php
        	                     $the_query =  new WP_Query( array('posts_per_page' => -1,
                                 'post_type'       => 'tickets',
                                 'post_status'     => array('publish'),
                                 'order'           => 'DESC',
                                 // 'paged'           => get_query_var('paged') ? get_query_var('paged') : 1,
                                 'meta_query'      =>
                                    array(
                                       array(
                                           'relation' => 'OR',
                                         array(
                                        'key' => '_mcf_tech_custom',
                                        'value' => get_current_user_id()
                                       )
                                            
                                  )
                                    )
                                 )
                              );
                      if ( $the_query->have_posts() ) { 
                      		while ( $the_query->have_posts() ) {
								$the_query->the_post();
								$post_id 	    = get_the_ID();
							  $title    = get_post_meta( $post_id, '_mcf_ticket_title_custom', true );
                $full_name  = get_post_meta( $post_id, '_mcf_user_name_custom', true );
                $Address  = get_post_meta( $post_id, '_mcf_address_custom', true );
                $service  =  get_post_meta( $post_id, '_mcf_service_custom', true );
                $date     = get_post_meta( $post_id, '_mcf_date_custom', true );
								$status 	    = wp_get_post_terms($post_id,'status', array('fields' => 'all' ) );

								?>
								   <tr>
					                <td><?php echo $post_id; ?></td>
					                <td><?php echo $date; ?></td>
        									<td><?php echo $title; ?></td>
        									<td><?php echo ((empty($status))? '': $status[0]->name); ?></td>
					                <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i>
					                   <div id="myPop">
					                       <ul>
					                           <li><a href="<?= home_url().'/ticket-system-view-ticket?post_id='.$post_id; ?>"><i class="fa fa-eye" aria-hidden="true"></i> View </a></li>
					                           <li><a href="<?= home_url().'/ticket-system-view-ticket?close_id='.$post_id; ?>" id="myBtn"><i class="fa fa-lock" aria-hidden="true"></i> Close </a></li>
					                       </ul>
					                   </div>
					                </td>
            						</tr>    
								<?php

                      		}
                      }
                      ?>
                       
        </tbody>
    </table>
    </div>
	</div>
	</div>	
<?php
 }
?>
</div><!--/container-wrap-->

<?php 
/*}
else{
	wp_redirect(home_url());
}*/ ?>