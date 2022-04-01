$(document).ready(function () {
    $('#login').validate({
      rules: {
        username: {
          required: true
		},
        password: {
          required: true,
          minlength: 3
        }
      },
      messages: {
		username: {
          required: 'Please enter Username.',
        },
        password: {
          required: 'Please enter Password.',
          minlength: 'Password must be at least 8 characters long.',
        }
      },
      submitHandler: function (form) {
        login.submit();
      }
    });
  });

$(document).ready(function () {
    $('#form').validate({
      rules: {
        firstname: {
          required: true
		},
		      lastname: {
          required: true
        },
        emailaddress: {
          required: true,
          email: true,
        },
        password: {
          required: true,
          minlength: 3
        },
        organizationname: {
          required: true
        },
        confirmpassword: {
          required: true,
          equalTo: "#password"
        }
      },
      messages: {
		firstname: 'Please enter First Name.',
		lastname: 'Please enter Last Name.',
    organizationname: 'Please enter Organization Name.',
        emailaddress: {
          required: 'Please enter Email Address.',
          email: 'Please enter correct email this email not valid.',
        },

        password: {
          required: 'Please enter Password.',
          minlength: 'Password must be at least 8 characters long.',
        },
        confirmpassword: {
          required: 'Please enter Confirm Password.',
          equalTo: 'Confirm Password do not match with Password.',
        }
      },

    });
    $('#idnext').click(function() {
      if($("#form").valid()){
        $(".terms_content").show();
        $(".login-fields").hide();
      }
    });
  });


$.noConflict();
jQuery(document).ready(function($){
jQuery("#emailaddress").change(function(){
	var email = jQuery("#emailaddress").val();
	jQuery.ajax({
					url: 'js/chk-email.php?email='+email,
					type: "GET",
					data:  {email:email},
					success: function(data){
					
						if(!data){
							jQuery('#email-error').hide();
							jQuery('#create').removeAttr('disabled');
						}else{
							jQuery('#email-error').html(data);
							jQuery('#email-error').show();
							jQuery('#create').attr('disabled','disabled');
						}
						
					},
					error: function() 
					{
						jQuery('#email-error').hide();
						jQuery('#create').attr('disabled','disabled');
					} 	        
				});
			   

});
});

setTimeout(function() {
   jQuery('.alert-success').fadeOut('slow');
}, 8000); // <-- time in milliseconds
	setTimeout(function() {
   jQuery('.alert-error').fadeOut('slow');
}, 8000); // <-- time in milliseconds


               jQuery.noConflict();
               jQuery(document).ready(function($){
               jQuery(function() {    // Makes sure the code contained doesn't run until
                  //     all the DOM elements have loaded

                  jQuery('#w_type').change(function(){
                      jQuery('.watermark').hide();
                      jQuery('#' + jQuery(this).val()).show();
                  });

              });
               });

               jQuery(function() {
               jQuery('#number').change(function(){ 
                  var file = jQuery('#file_type').val();  
                  var page = jQuery('#number').val();
                  
                  if(file == 'PDF'){
                    var total = (page * 5);
                  }
                  else{
                    var total = (page * 10);
                  }
                
                  jQuery('#price').val(total);
               });
               });

               function validateForm() {
                var number = document.forms["uploadFormcontent"]["number"].value;
                var fileurl = document.forms["uploadFormcontent"]["fileurl"].value;
                var w_type = document.forms["uploadFormcontent"]["w_type"].value;
                var error = document.getElementById("error");
                var errorfile = document.getElementById("errorfile");
                var errorw = document.getElementById("errorw");
                if (fileurl == "") {
                  errorfile.innerHTML =  
                   "Please Select a file to upload.";
                  //alert("Name must be filled out");
                  return false;
                }else {
                  errorfile.innerHTML =  
                   "";
                }
                if (number == "") {
                  error.innerHTML =  
                   "Please enter total pages.";
                  //alert("Name must be filled out");
                  return false;
                }else {
                  error.innerHTML =  
                   "";
                }
                if (w_type == "Text") {
                  var watermark_text = document.forms["uploadFormcontent"]["watermark_text"].value;
                  if (watermark_text == "") {
                  errorw.innerHTML =  
                   "Please enter watermark.";
                  //alert("Name must be filled out");
                  return false;
                }
                } else{
                  var file = document.forms["uploadFormcontent"]["file"].value;
                  if (file == "") {
                  errorw.innerHTML =  
                   "Please select watermark file.";
                  //alert("Name must be filled out");
                  return false;
                }
                }
              }