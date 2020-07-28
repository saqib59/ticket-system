(function($){
   $('#myTable2').DataTable();
	 $('#myTable3').DataTable();
       /* $("input[id*='in-popular-status']").click(function(){
            var status = $(this).val();
            $("input[id=acf-field_5e989541af11d]").val(status);
        });*/
	 $("#add_service").submit(function(){
    	event.preventDefault();
    	var serialize_form = $(this).serialize();
	 	 $.ajax({
                type:"POST",
                url: the_ajax_script.ajaxurl,
                data: serialize_form,
                dataType : 'json',
              		success: function (response) {
                        var error = response.error;
                        if (error) { 
                           	alert(response.message);
                        } else {
                           alert(response.message);
                           location.reload();
                    }
                },
                    error: function (errorThrown) {
                       	alert('error');
                        console.log(errorThrown);
                    },
            });
	 });
	  $(".del-service").click(function(){
	  	var service_id = $(this).attr("data-id");
	 	 $.ajax({
                type:"POST",
                url: the_ajax_script.ajaxurl,
                data: {'service_id':service_id , 'action': 'delete_service_from_admin'} ,
                dataType : 'json',
              		success: function (response) {
                        var error = response.error;
                        if (error) { 
                           	alert(response.message);
                        } else {
                           alert(response.message);
                           location.reload();
                    }
                },
                    error: function (errorThrown) {
                       	alert('error');
                        console.log(errorThrown);
                    },
            });
	 });
    /*CHANGES START*/
    $('.single-user-id').change(function(e){
    e.preventDefault();
    var user_id =  $(this).val();
    if($(this).prop("checked")) {
      check_val(user_id);
    } else {
      uncheck_val(user_id);
    }
  });

  /**  Checked Values Verification  **/
  function check_val(user_id){
    var selected_users = $('input[name=selected-users]').val();
    if(selected_users == 0){
      $('input[name=selected-users]').val(user_id);
    }
    else{
      var user_id = user_id;
      var new_selected_users = selected_users.split(","); // string to array
      var status = false;
      for(var i=0; i<new_selected_users.length; i++){
        var users_ids = new_selected_users[i];
        if(users_ids == user_id){
          status = true;
          break;
        }
      }

      if(status == true){
        return;
      }
      else{
        new_selected_users.push(user_id);
        var arr_to_str =  new_selected_users.toString();
        $('input[name=selected-users]').val(arr_to_str);
      } 
      //console.log(typeof selected_users);
    } 
  }
  /**  Un Checked Values Verification  **/
  function uncheck_val(user_id){
    var selected_users = $('input[name=selected-users]').val();
    var user_id = user_id;
    //alert(user_id);
    var new_selected_users = selected_users.split(","); // string to array
    var index = new_selected_users.indexOf(user_id);
    if (index > -1) {
      new_selected_users.splice(index, 1);

      if( new_selected_users.length == 0){
        $('input[name=selected-users]').val(0);
      }
      else{
        var arr_to_str =  new_selected_users.toString();
        $('input[name=selected-users]').val(arr_to_str);  
      }
    }     
  }
      /**   SEND FILES TO ALL USERS **/
       $( "#send-files-selected" ).submit(function( e ) {
        e.preventDefault();
        var errors = 0;
      var file_data = $('#admin-system-files').prop('files');   
      if(file_data.length  == 0){
        errors += 1;
        $('#admin-system-files-err').text('Select At least one file to proceed');
      }
      else{
        $('#admin-system-files-err').empty();
      }
        if(errors == 0){   
          // Files from admin
      // var form_data = new FormData(this);                  
      // form_data.append('file_admin', file_data);   
          var selected_users = $('input[name=selected-users]').val();
          if(selected_users == 0){
            alert('Make Users Selection First');
          }
          else{
            //alert('No errors');
            $('input[name=selected_users]').val(selected_users);
        $.ajax({
          type: 'POST',
          url: the_ajax_script.ajaxurl,
          data: new FormData(this),
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function (dataa) {
            //console.log(dataa);
            var status = dataa.status;
            if (status) {
              alert(dataa.error);
              location.reload();
            } 
            else {
              alert(dataa.error);
            }
          },
          error: function (errorThrown) {
            console.log(errorThrown);
          }
        });
          }
        }
    });
       $(".delete-file").click(function(){
          var file_id = $(this).attr('data-id');
               $.ajax({
                type:"POST",
                url: the_ajax_script.ajaxurl,
                data: {'file_id':file_id , 'action': 'delete_file_from_admin'} ,
                dataType : 'json',
                  success: function (response) {
                        var error = response.error;
                        if (error) { 
                            alert(response.message);
                        } else {
                           alert(response.message);
                           location.reload();
                    }
                },
                    error: function (errorThrown) {
                        alert('error');
                        console.log(errorThrown);
                    },
            });

       });

})(jQuery);