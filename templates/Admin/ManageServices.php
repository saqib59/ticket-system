  <div class="container">
  <div class="card">
  <h3 class="card-header">Services</h1>
<div class="card-body"> 
        <table id="myTable2" class="cell-border table table-striped table-bordered table-hover" style="width:100%" >
        <thead>
            <tr>
                <th>Service id</th>
                <th>Service Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                global $wpdb;
                $results = $wpdb->get_results( "SELECT * FROM ". $wpdb->prefix ."ticket_services ",OBJECT ); 
                foreach ($results as $row) {
                    ?>
                      <tr>
                        <td class="service_col"><?php echo $row->ID; ?></td>
                        <td class="service_col"><?php echo $row->service_name; ?></td>
                        <td class="service_col"><a href="#" class="del-service" data-id=<?php echo $row->ID; ?>>Delete</a>
                </td>
               <?php
                ?>
            </tr>
                    <?php

                }
?>
        </tbody>
    </table>
    <h2>Add</h2>
    <form id="add_service" method="post">
            <input type="text" name="service_name" placeholder="Service Name" class="form-group row">
            <input type="hidden" name="action" value="add_service_to_admin">
            <input type="submit" name="submit_service">
    </form>
		</div>
	</div>
</div>