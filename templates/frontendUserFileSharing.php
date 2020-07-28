<div class="container-wrap">
	<div class="container">
		<div class="row">
			
		</div><!--/row-->
	</div><!--/container-->
<div id="myModal" class="modal">
  <div class="modal-content">
      <div class="ater_box">
          <span>!</span>
      </div>
      <div class="content_box">
         <p>Alert</p>
         <h6>Would you like to delete the file?</h6>
      </div>
      <div class="btn_box">
         <button class="noBtn" id="noDel">No</button>
         <button class="yesBtn" id="yesDel">yes</button>
     </div>
  </div>
</div> 	
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
  include("sidebars/sidebar.php");
   ?>		
	<div id="content-rhs">
		<div id="card">
      <div class="row">
                  <div class="col span_6"><h1>File Sharing</h1></div>  
                <div class="col span_6 col_last">
                  <!-- <button  id="dash" class="Create_tick" >Send File</button> -->
        <button data-modal-target="#modal">Send File</button>
         <div class="modal myclass" id="modal">
    <div class="modal-header">
      <div class="title">Send Files To Admin</div>
      <button data-close-button class="close-button">&times;</button>
    </div>
    <div class="modal-body">
      <form id="files-to-admin" method="post" enctype="multipart/form-data">
        <input type="file" id="admin-system-files" name="admin-system-files[]" multiple="multiple" class="required">
        <br>
          <input type="hidden" name="action" value="send_files_to_admin" />
        <br>
        <input type="submit" name="submit" value="Send">
      </form>
    </div>
  </div>
             </div>
  			<table id="myTable2" class="cell-border" style="width:100%" >
          <thead>
              <tr>
                  <th>File Name</th>
                  <th>File Size</th>
                  <th>Status</th>
                  <th>Download File</th>
              </tr>
          </thead>
          <tbody>
            <?php
              global $wpdb;
                $results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."ticket_files WHERE `receiver_id` = $current_user->ID OR `sender_id` = $current_user->ID ",OBJECT ); 
                foreach ($results as $row) {
                  $file_size_float = $row->file_size / 1000;
                 $file_size = round($file_size_float,0);
                $file_to_download = 'wp-content/uploads/user_system_admin/' . $row->file_name;
                ?>
                <tr>
                <td><?php echo $row->file_name; ?> </td>
                  <td><?php echo $file_size; ?>kb</td>
                  <td><?php if ($row->receiver_id == $current_user->ID) {
                    echo "Recieved";
                  }
                  else{
                    echo "Sent";
                  } ?></td>
                  <td><a href="<?php echo home_url('/' . $file_to_download);  ?>" download >Download</a></td>
              </tr>
                    <?php
                          } 
            ?>
          </tbody>
      </table>


    </div>
	</div>
  <div id="overlay"></div>

	</div>	
</div><!--/container-wrap-->
  <script type="text/javascript">
const openModalButtons = document.querySelectorAll('[data-modal-target]')
const closeModalButtons = document.querySelectorAll('[data-close-button]')
const overlay = document.getElementById('overlay')

openModalButtons.forEach(button => {
  button.addEventListener('click', () => {
    const modal = document.querySelector(button.dataset.modalTarget)
    openModal(modal)
  })
})

overlay.addEventListener('click', () => {
  const modals = document.querySelectorAll('.modal.active')
  modals.forEach(modal => {
    closeModal(modal)
  })
})

closeModalButtons.forEach(button => {
  button.addEventListener('click', () => {
    const modal = button.closest('.modal')
    closeModal(modal)
  })
})

function openModal(modal) {
  if (modal == null) return
  modal.classList.add('active')
  overlay.classList.add('active')
}

function closeModal(modal) {
  if (modal == null) return
  modal.classList.remove('active')
  overlay.classList.remove('active')
}
  </script>
