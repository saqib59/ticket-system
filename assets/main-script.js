

(function($){

  // $(".myclass").

  // $("#dash").click(function(){
  //   MicroModal.show('modal-id');

  // });
 /* $("#myTable").DataTable();
  $("#myTable2").DataTable();
  

    var dateToday = new Date();
    $("input[name=date]").datepicker({
       minDate: dateToday,
    });*/
    $("#user_register_form").submit(function(event) {
    	event.preventDefault();
    $("#user_register_form").validate({

      rules: {
        user_name: {required: true},
        email: {required: true},
        pass: {required: true},
        c_pass: {equalTo:'#pass'},
      },
      messages: {
                  user_name: { required: 'Please Enter Your Username' },
                  email:{ required:'Please Enter a Valid email'},
                  c_pass :{ equalTo :'Your Password Does not Match'},
                },
    });

    var valid = $(this).valid();
    if (valid) {
    	$("#register_submit").append('<i class="fa fa-circle-o-notch fa-spin" style="font-size:20px"></i>');
    	$("#register_submit").prop("disabled",true);
      var serialize_form = $(this).serialize();

            $.ajax({
                type:"POST",
                url: the_ajax_script.ajaxurl,
                data: serialize_form,
                dataType : 'json',
              success: function (response) {
                        console.log(response);

                $("#register_submit").children().remove();
      			    $("#register_submit").prop("disabled",false);
                        var error = response.error;
                        if (error) { 
                            Swal.fire({
                                icon: 'error',
                                text: response.message,
                                });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                text: response.message,
                                }).then((result) => {
                                      if (result.value) {
                                         window.location.href = response.redirect_url;
                                      }
                        });
                    }
                },
                    error: function (errorThrown) {
                       alert('error');
                        console.log(errorThrown);
                    },
            });
    }
      
  });
 
  function run_waitMe(){

  $('.myclass').waitMe({
      effect:'ios',
      text:'',
      bg:'rgba(255,255,255,0.7)',
      color:'#05a9e8',
      maxSize:'',
      waitTime: -1,
      source:'',
      textPos:'vertical',
      fontSize:'',
      onClose:function() {}
  });
}


	$("#user-login-form").submit(function(event) {
    event.preventDefault();
    $("#user-login-form").validate({

      rules: {
        user_name: {required: true},
        pass: {required: true},
      },
      messages: {
                  user_name: { required: 'Please Enter Your Username' },
                  pass:{ required:'Please Enter your password'},
                },
       
    });

    var valid = $(this).valid();
    if (valid) {
      	$("#login-user").append('<i class="fa fa-circle-o-notch fa-spin" style="font-size:20px"></i>');
    	$("#login-user").prop("disabled",true);
            var serialize_form = $(this).serialize();
            $.ajax({
                type:"POST",
                url: the_ajax_script.ajaxurl,
                data: serialize_form,
                dataType : 'json',
              success: function (response) {
          	    	$("#login-user").children().remove();
					       $("#login-user").prop("disabled",false);
                    console.log(response);
                    var error = response.status;
                    if (error) { 
                        window.location.href = response.redirect_url;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: response.error,
                            });
                       // console.log(response);
                    }
                },
            	error: function (errorThrown) {
                        console.log(errorThrown);
                    },
            });
    }
      
  });
  /*TECHNICIAN LOGIN*/
  $("#tech-login-form").submit(function(event) {
    event.preventDefault();
    $("#tech-login-form").validate({

      rules: {
        user_name: {required: true},
        pass: {required: true},
      },
      messages: {
                  user_name: { required: 'Please Enter Your Username' },
                  pass:{ required:'Please Enter your password'},
                },
       
    });

    var valid = $(this).valid();
    if (valid) {
        $("#login-tech").append('<i class="fa fa-circle-o-notch fa-spin" style="font-size:20px"></i>');
      $("#login-tech").prop("disabled",true);
            var serialize_form = $(this).serialize();
            $.ajax({
                type:"POST",
                url: the_ajax_script.ajaxurl,
                data: serialize_form,
                dataType : 'json',
              success: function (response) {
                  $("#login-tech").children().remove();
                 $("#login-tech").prop("disabled",false);
                    console.log(response);
                    var error = response.status;
                    if (error) { 
                        window.location.href = response.redirect_url;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: response.error,
                            });
                    }
                },
              error: function (errorThrown) {
                        console.log(errorThrown);
                    },
            });
    }
      
  });

    /*CREATE TICKET*/

    $('#create-ticket').submit(function(){
      event.preventDefault();
      $(this).validate();

      var valid = $(this).valid();
      if (valid) {
        run_waitMe();
            var serialize_form = $(this).serialize();
            $.ajax({
                type:"POST",
                url: the_ajax_script.ajaxurl,
                data: serialize_form,
                dataType : 'json',
              success: function (response) {
                $(".myclass").waitMe("hide");
                    console.log(response);
                    var error = response.error;
                    if (error) { 
                       Swal.fire({
                            icon: 'error',
                            text: response.error,
                            });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            }).then((result)=>{
                                  location.reload();
                              });
                    }
                },
              error: function (errorThrown) {
                        console.log(errorThrown);
                    },
            });

      }

  });


    /*CLOSE TICKET*/
    $('#close-ticket').submit(function(){
      event.preventDefault();
      $(this).validate();

      var valid = $(this).valid();
      if (valid) {
            var serialize_form = $(this).serialize();

              Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, Close!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
            }).then((result) => {
                if (result.value) {
                   run_waitMe();
                    $.ajax({
                        type:"POST",
                        url: the_ajax_script.ajaxurl,
                        data: serialize_form,
                        dataType : 'json',
                      success: function (response) {
                            console.log(response);
                            var error = response.error;
                            if (error) { 
                               Swal.fire({
                                    icon: 'error',
                                    text: response.message,
                                    }).then((result)=>{
                                      $(".myclass").waitMe("hide");

                                    });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    text: response.message,
                                    }).then((result)=>{
                                      $(".myclass").waitMe("hide");
                                      location.reload();
                                    });
                            }
                        },
                        error: function (errorThrown) {
                                console.log(errorThrown);
                            },
                      });
                  } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    Swal.fire(
                      'Cancelled',
                      'Ticket did not deleted :)',
                      'error'
                    )
                  }
                });
          }
  });
    $("#files-to-admin").submit(function(event){
      event.preventDefault();
      $(this).validate();

      var valid = $(this).valid();
      if (valid) {
            run_waitMe();
         $.ajax({
          type: 'POST',
          url: the_ajax_script.ajaxurl,
          data: new FormData(this),
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function (response) {
            //console.log(dataa);
            console.log(response);
            var error = response.error;
            if (error) { 
               Swal.fire({
                    icon: 'error',
                    text: response.message,
                    }).then((result)=>{
                      $(".myclass").waitMe("hide");

                    });
            } else {
                Swal.fire({
                    icon: 'success',
                    text: response.message,
                    }).then((result)=>{
                      $(".myclass").waitMe("hide");
                      location.reload();
                    });
            }
          },
          error: function (errorThrown) {
            console.log(errorThrown);
          }
        });

      }
    });
})(jQuery);

