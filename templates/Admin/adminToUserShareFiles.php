 <?php 
  $args = array(
                'role__in' => ['ticket-system-user','ticket-system-tech']
            );

            $all_users = get_users($args);
            $count_users = count($all_users);
            // if ($count_users > 0) {
            // echo "<pre>";
            // foreach ($all_users as $user) {
            //     var_dump($user->roles);
            // }
            // echo "</pre>";
            // exit();
    ?>
    
     <!--  Send to selected users -->
<div class="modal fade" id="sendtoselected" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send to selected users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="send-files-selected" method="post" enctype="multipart/form-data"> 
          <div class="modal-body">
            
              <div class="form-group">
                <label for="message-text" class="col-form-label">Choose Files (Not more than 10) :</label>
                  <input type="file" id="admin-system-files" name="admin-system-files[]" multiple="multiple">
                <div><small id="admin-system-files-err" style="color: red;"></small></div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Send message</button>
          </div>
          <input type="hidden" name="selected_users" value="0" />
          <input type="hidden" name="action" value="send_files_selected" />
     </form>
    </div>
  </div>
</div>
<div class="card">
     <h2 class="card-header">File Sharing</h2>
    <br>
        <table id="myTable2" class="cell-border table  table-bordered table-hover" style="width:100%" >
        <thead>
            <tr>
                <th>UserName</th>
                <th>Full Name</th>
                <th>Role</th>
                <th>Send File
                  <button type="button" class="btn btn-primary modal-sendselected" data-toggle="modal" data-target="#sendtoselected">Send to Selected Users</button></th>
                
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($all_users as $user) {
                    ?>
                      <tr>
                        <td class="service_col"><?php echo $user->data->user_login; ?></td>
                        <td class="service_col"><?php echo $user->data->display_name; ?></td>
                        <td class="service_col"><?php echo $user->roles[0]; ?></td>
                        <td class="service_col">
                            <input type="checkbox" class="single-user-id" name="user_id" value="<?php echo $user->ID; ?>" >
                </td>
               <?php
                ?>
            </tr>
                    <?php
                }
            ?>
        </tbody>
            <input type="hidden" id="selected-users" name="selected-users" value="0" />
    </table>
</div>
<div class="card">
    <h2 class="card-header">Shared Files</h2>
    <br>
    <table id="myTable3" class="cell-border table table-bordered table-hover" style="width:100%" >
        <thead>
            <tr>
                <th>UserName</th>
                <th>Full Name</th>
                <th>role</th>
                <th>Status</th>
                <th>Download File</th>
                <th>Delete File</th>
                
            </tr>
        </thead>
        <tbody>
            <?php 
                global $wpdb;
                $result = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."ticket_files ",OBJECT ); 
                foreach ($result as $row) {
                $user = get_user_by('id',$row->user_id);
                $file_to_download = 'wp-content/uploads/user_system_admin/' . $row->file_name;

                    ?>
                      <tr id=<?= $row->ID; ?>>
                        <td class="service_col"><?php echo $user->data->user_login; ?></td>
                        <td class="service_col"><?php echo $user->data->display_name; ?></td>
                        <td class="service_col"><?php echo $user->roles[0]; ?></td>
                        <td class="service_col">
                          <?php
                          if ($row->sender_id == 1001) {
                            echo "Sent";
                          }
                          else{
                            echo "Received";                            
                          }
                          ?>  
                </td>
                  <td class="service_col"><a href="<?php echo home_url('/' . $file_to_download);  ?>" download >Download</a></td>
                  <td class="service_col"><button type="button" class="delete-file" data-id="<?php echo $row->ID; ?>">Delete</button>
                    <!-- <a href="" class="delete-file" data-id="<?php echo $row->ID; ?> " >Delete</a> -->
                  </td>
               <?php
                ?>
            </tr>
                    <?php
                }
            ?>
        </tbody>
            <input type="hidden" id="selected-users" name="selected-users" value="0" />
    </table>
    </div>
<?php
    // }
    ?>