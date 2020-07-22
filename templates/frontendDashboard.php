<?php 

/*if ($current_user->ID != 0) {

get_header(); 
nectar_page_header($post->ID); 

//full page
$fp_options = nectar_get_full_page_options();
extract($fp_options);*/

?>

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
		// if ($current_user->roles[0] == 'pureproof-user') {
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
                                /* 'meta_query'      =>
                                    array(
                                       array(
                                           'relation' => 'OR',
                                         array(
                                        'key' => 'user_id',
                                        'value' => $current_user->ID
                                       )
                                            
                                  )
                                    )*/
                                 )
                              );
                      if ( $the_query->have_posts() ) { 
                      		while ( $the_query->have_posts() ) {
								$the_query->the_post();
								$post_id 	= get_the_ID();
								$title 		= get_post_meta( $post_id, 'ticket_title', true );
								$full_name 	= get_post_meta( $post_id, 'full_name', true );
								$Address 	= get_post_meta( $post_id, 'Address', true );
								$service 	=  get_post_meta( $post_id, 'service', true );
								$date 		= get_post_meta( $post_id, 'date', true );
								$status 	= wp_get_post_terms($post_id,'status', array('fields' => 'all' ) );
								// echo "<pre>";
								// var_dump($post_id[0]->name);
								// echo "</pre>";

								?>
								   <tr>
					                <td><?php echo $post_id; ?></td>
					                <td><?php echo $date; ?></td>
					                <td><?php echo $title; ?></td>
									<td><?php echo $status[0]->name; ?></td>
					                <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i>
					                   <div id="myPop">
					                       <ul>
					                           <li><a href="<?= home_url().'/close-ticket?post_id='.$post_id; ?>" ><i class="fa fa-eye" aria-hidden="true"></i> View </a></li>
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
// }
/*else{
	?>

<div class="toggle_bar"> 
	<a href="javascript:void(0)" class="myToggle"> 
		<div></div>
        <div></div>
        <div></div>
	</a>
</div>	
<?php
  include("phoneMenu/phone_menu.php");
?>	
	<div id="main-area">
		<?php 
		include('inc/sidebar.php');
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
                                        'key' => '_wporg_meta_key',
                                        'value' => $current_user->ID
                                       )
                                            
                                  )
                                    )
                                 )
                              );
                      if ( $the_query->have_posts() ) { 
                      		while ( $the_query->have_posts() ) {
								$the_query->the_post();
								$post_id 	= get_the_ID();
								$title 		= get_post_meta( $post_id, 'ticket_title', true );
								$full_name 	= get_post_meta( $post_id, 'full_name', true );
								$Address 	= get_post_meta( $post_id, 'Address', true );
								$service 	=  get_post_meta( $post_id, 'service', true );
								$date 		= get_post_meta( $post_id, 'date', true );
								$status 	= wp_get_post_terms($post_id,'status', array('fields' => 'all' ) );
								// echo "<pre>";
								// var_dump($post_id[0]->name);
								// echo "</pre>";

								?>
								   <tr>
					                <td><?php echo $post_id; ?></td>
					                <td><?php echo $date; ?></td>
									<td><?php echo $title; ?></td>
									<td><?php echo $status[0]->name; ?></td>
					                <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i>
					                   <div id="myPop">
					                       <ul>
					                           <li><a href="<?= home_url().'/close-ticket?post_id='.$post_id; ?>"><i class="fa fa-eye" aria-hidden="true"></i> View </a></li>
					                           <li><a href="<?= home_url().'/close-ticket?close_id='.$post_id; ?>" id="myBtn"><i class="fa fa-lock" aria-hidden="true"></i> Close </a></li>
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
 }*/
?>
</div><!--/container-wrap-->

<?php 
/*}
else{
	wp_redirect(home_url());
}*/ ?>