<div class="container-wrap">
	<div class="<?php if($page_full_screen_rows != 'on') echo 'container'; ?> main-content">
		<div class="row">
			
			<?php 

			//breadcrumbs
			if ( function_exists( 'yoast_breadcrumb' ) && !is_home() && !is_front_page() ){ yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } 

			 //buddypress
			 global $bp; 
			 if($bp && !bp_is_blog_page()) echo '<h1>' . get_the_title() . '</h1>';
			
			 //fullscreen rows
			 if($page_full_screen_rows == 'on') echo '<div id="nectar_fullscreen_rows" data-animation="'.$page_full_screen_rows_animation.'" data-row-bg-animation="'.$page_full_screen_rows_bg_img_animation.'" data-animation-speed="'.$page_full_screen_rows_animation_speed.'" data-content-overflow="'.$page_full_screen_rows_content_overflow.'" data-mobile-disable="'.$page_full_screen_rows_mobile_disable.'" data-dot-navigation="'.$page_full_screen_rows_dot_navigation.'" data-footer="'.$page_full_screen_rows_footer.'" data-anchors="'.$page_full_screen_rows_anchors.'">';

				 if(have_posts()) : while(have_posts()) : the_post(); 
					
					 the_content(); 
					 
				 endwhile; endif; 
				
			if($page_full_screen_rows == 'on') echo '</div>'; ?>

		</div><!--/row-->
	</div><!--/container-->
<div id="myModal" class="modal">
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
</div> 	
	<div id="main-area">
		
		<div id="content-lhs">
			<ul>
				<li><a href="#"><i class="fa fa-area-chart" aria-hidden="true"></i> Dashboard</a></li>
				<li><a href="https://pureproofinc.com/user-ticket/" class="active"><i class="fa fa-user" aria-hidden="true"></i> User - Ticket</a></li>
				<li><a href="#"><i class="fa fa-trash" aria-hidden="true"></i> Ticket Delete</a></li>
				<li><a href="https://pureproofinc.com/create-ticket-2/" ><i class="fa fa-cogs" aria-hidden="true"></i> Create Ticket</a></li>
				<li><a href="https://pureproofinc.com/message-board/"><i class="fa fa-users" aria-hidden="true"></i> Message board</a></li>
				<li><a href="https://pureproofinc.com/file-sharing/"><i class="fa fa-file" aria-hidden="true"></i> file sharing</a></li>
				<li><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Download file</a></li>
				<li><a href="#"><i class="fa fa-user" aria-hidden="true"></i> technician login</a></li>
				<li><a href="https://pureproofinc.com/148-2/#"><i class="fa fa-ticket" aria-hidden="true"></i> Assigned ticket</a></li>
				<li><a href="https://pureproofinc.com/close-ticket/"><i class="fa fa-trash" aria-hidden="true"></i> Close ticket</a></li>																
			</ul>
		</div>
	<div id="content-rhs">
		<div id="card">
			<h1>User - ticket Dashboard</h1>
			<button class="Create_tick">Create New ticket</button>
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
            <tr>
                <td>911</td>
                <td>03-02-2020</td>
				<td>Lorem Ipsum Dummy Ticket Title</td>
				<td>open</td>
                <td><i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                   <div id="myPop">
                       <ul>
                           <li><a href="#"><i class="fa fa-download" aria-hidden="true"></i> Download file</a></li>
                           <li><a href="#" id="myBtn"><i class="fa fa-trash" aria-hidden="true"></i> delete file</a></li>
                       </ul>
                   </div>
                </td>
            </tr>                  
        </tbody>
    </table>
    </div>
	</div>
	</div>	
</div><!--/container-wrap-->