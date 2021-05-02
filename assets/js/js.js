//notification variables
var placementFrom = "top";
var placementAlign = "right";
var style = "withicon";
var content = {};

//number input only
function isNumberKey(evt){
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

 return true;
}

//sim editor
$(document).ready(function(){
    //check if page has a textarea
    var el = $('textarea')[0];
    if (el) {
//        console.log('element found', el);
//         var editor = new Simditor({
//          textarea: $(this).find('textarea'),
//          pasteImage: false
//        }); 
        }
   
});

//login
$("#loginForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var email = $("#email").val();
    var password = $("#password").val();
    if(email !== '' && password !== ''){
      
      $("#loginBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Checking...');
       $.ajax({ //make ajax request to cart_process.php
          url: "process/login.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
             $("#loginResponse").fadeIn();
            $("#loginBtn").html('Login');
            var data = JSON.parse(dataResult);
            if(data.code == 1){
               $("#loginResponse").html('<p class="alert alert-success text-center">'+data.msg+'</p>');
               setTimeout(function(){
                 window.location = "index";
               },1000);
            }else if(data.code == 2){
               $("#loginResponse").html('<p class="alert alert-danger text-center">'+data.msg+'</p>');
              setTimeout(function(){
                  $("#loginResponse").fadeOut();
              },1500);
            }else{
              $("#loginResponse").html('<p class="alert alert-danger text-center">Unknown error occured try again later!</p>');
               setTimeout(function(){
                  $("#loginResponse").fadeOut();
              },1500);
            }

       });
     
    }else{
      $("#loginResponse").html('<p class="alert alert-danger text-center">Both fields are required</p>');
       setTimeout(function(){
                  $("#loginResponse").fadeOut();
              },1500);
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//add user
$("#addUserForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var email = $("#email").val();
    var password = $("#newPassword").val();
    var password2 = $("#confirmPassword").val();
    var fullname = $("#fullname").val();
    var phone = $("#phone").val();
  
    
    if(email !== '' && password !== '' && phone !== '' && fullname !== ''){
      if(password === password2){
          $("#addUserBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
           $.ajax({ //make ajax request to cart_process.php
              url: "process/users.php",
                  type: "POST",
                  //dataType:"json", //expect json value from server
                  data: form_data
              }).done(function(dataResult){ //on Ajax success
                console.log(dataResult);
                $("#addUserBtn").html('Add User');
                var data = JSON.parse(dataResult);
             
                document.getElementById("addUserForm").reset();//empty the form
                $("#add-admin").modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'User Adding';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'users.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "users";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'User Adding';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'users.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'User Adding';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'users.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                }
                document.getElementById("addUserForm").reset();//empty the form
                $("#add-admin").modal('toggle');
           });

        }else{
          var state = "danger";
          content.message = "Passwords do not match";
          content.title = 'User Adding';
          if (style == "withicon") {
              content.icon = 'la la-bell';
          } else {
              content.icon = 'none';
          }
          content.url = 'users.php';
          content.target = '_blank';

          $.notify(content,{
              type: state,
              placement: {
                  from: placementFrom,
                  align: placementAlign
              },
              time: 800,
          });
          $("#add-admin").modal('toggle');
          
          
        }
    }else{
      $("#add-admin").modal('toggle');
        var state = "danger";
        content.message = "All fields are required";
        content.title = 'User Adding';
        if (style == "withicon") {
            content.icon = 'la la-bell';
        } else {
            content.icon = 'none';
        }
        content.url = 'users.php';
        content.target = '_blank';

        $.notify(content,{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 1000,
        });
      
          $("#add-admin").modal('toggle');
    }
  
 
    e.preventDefault();
    e.stopImmediatePropagation();
});

//suspend user 
$("#suspendUserForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var id = $("#susUser").val();
    if(id !== '' ){
      
      $("#suspendBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Suspending...');
      
      $.ajax({ //make ajax request to cart_process.php
          url: "process/users.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
            console.log(dataResult);
            $("#suspendBtn").html('Yes');
            var data = JSON.parse(dataResult);

            document.getElementById("suspendUserForm").reset();//empty the form
            $("#suspendUserModal").modal('toggle');

            if(data.code == 1){
              var state = "success";
              content.message = data.msg;
              content.title = 'User Suspension';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'users.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
               setTimeout(function(){
                 window.location = "users";
               },800);

            }else if(data.code == 2){
                var state = "danger";
                content.message = data.msg;
                content.title = 'User Supension';
                if (style == "withicon") {
                    content.icon = 'la la-bell';
                } else {
                    content.icon = 'none';
                }
                content.url = 'users.php';
                content.target = '_blank';

                $.notify(content,{
                    type: state,
                    placement: {
                        from: placementFrom,
                        align: placementAlign
                    },
                    time: 800,
                });
            }else{
              var state = "danger";
              content.message = "An unknown error occured, try again later!";
              content.title = 'User Suspension';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'users.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
            }
            document.getElementById("suspendUserForm").reset();//empty the form
            $("#suspendUserModal").modal('toggle');
       });

        
      
    }else{
        var state = "danger";
        content.message = "No User Selected, try again later!";
        content.title = 'User Suspension';
        if (style == "withicon") {
            content.icon = 'la la-bell';
        } else {
            content.icon = 'none';
        }
        content.url = 'users.php';
        content.target = '_blank';

        $.notify(content,{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 800,
        });
      
      document.getElementById("suspendUserForm").reset();//empty the form
      $("#suspendUserModal").modal('toggle');
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//delete user
$("#deleteUserForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var id = $("#delUser").val();
    if(id !== '' ){
      
      $("#delBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Deleting...');
      
      $.ajax({ //make ajax request to cart_process.php
          url: "process/users.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
            console.log(dataResult);
            $("#delBtn").html('Yes');
            var data = JSON.parse(dataResult);

            document.getElementById("deleteUserForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');

            if(data.code == 1){
              var state = "success";
              content.message = data.msg;
              content.title = 'Delete User';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'users.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
               setTimeout(function(){
                 window.location = "users";
               },800);

            }else if(data.code == 2){
                var state = "danger";
                content.message = data.msg;
                content.title = 'Delete User';
                if (style == "withicon") {
                    content.icon = 'la la-bell';
                } else {
                    content.icon = 'none';
                }
                content.url = 'users.php';
                content.target = '_blank';

                $.notify(content,{
                    type: state,
                    placement: {
                        from: placementFrom,
                        align: placementAlign
                    },
                    time: 800,
                });
            }else{
              var state = "danger";
              content.message = "An unknown error occured, try again later!";
              content.title = 'Delete User';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'users.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
            }
            document.getElementById("deleteUserForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
       });

        
      
    }else{
        var state = "danger";
        content.message = "No User Selected, try again later!";
        content.title = 'Delete User';
        if (style == "withicon") {
            content.icon = 'la la-bell';
        } else {
            content.icon = 'none';
        }
        content.url = 'users.php';
        content.target = '_blank';

        $.notify(content,{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 800,
        });
      
      document.getElementById("deleteUserForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//edit user
function editUser(id){
    $("#editUserForm"+id).on('submit',function(e){
   var form_data = $(this).serialize();
    
    var email = $("#eemail"+id).val();
    var eUid = id;
    var fullname = $("#efullname"+id).val();
    var phone = $("#ephone"+id).val();
    var user_role = $("#euser_role"+id).val();
    var password = $("#epassword"+id).val();
      
    if(email !== '' && eUid !== '' && phone !== '' && fullname !== '' && user_role){
      
      $("#editUserBtn"+id).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
                $.ajax({ //make ajax request to cart_process.php
              url: "process/users.php",
                  type: "POST",
                  //dataType:"json", //expect json value from server
                  data: form_data
              }).done(function(dataResult){ //on Ajax success
                $("#editUserBtn"+id).html('Update User');
                var data = JSON.parse(dataResult);
             
                document.getElementById("editUserForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Update User ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'users.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "users";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Update User';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'users.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Update User';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'users.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                  
                  document.getElementById("editUserForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
                }
                 
             
           });
     
    }else{
     
      var state = "danger";
      content.message = "All Fields are required!";
      content.title = 'Update User';
      if (style == "withicon") {
          content.icon = 'la la-bell';
      } else {
          content.icon = 'none';
      }
      content.url = 'users.php';
      content.target = '_blank';

      $.notify(content,{
          type: state,
          placement: {
              from: placementFrom,
              align: placementAlign
          },
          time: 800,
      });
      
      document.getElementById("editUserForm"+id).reset();//empty the form
      $("#view-user"+id).modal('toggle');
      
    }
      
             
    
    e.preventDefault();
    e.stopImmediatePropagation();
});

}
   

//edit staff
function editStaff(id){
    $("#editStaffForm"+id).on('submit',function(e){
   var form_data = $(this).serialize();
    
    var email = $("#eemail"+id).val();
    var eUid = id;
    var fullname = $("#efullname"+id).val();
    var phone = $("#ephone"+id).val();
    var bio = $("#ebio"+id).val();
    var position = $("#eposition"+id).val();
      
    if(email !== '' && eUid !== '' && phone !== '' && fullname !== '' && bio !=='' && position !==''){
      
      $("#editUserBtn"+id).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
                $.ajax({ //make ajax request to cart_process.php
              url: "process/staff.php",
                  type: "POST",
                  //dataType:"json", //expect json value from server
                  data: form_data
              }).done(function(dataResult){ //on Ajax success
                    
                    console.log(dataResult)
                $("#editUserBtn"+id).html('Update User');
                var data = JSON.parse(dataResult);
             
                document.getElementById("editStaffForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Update Staff Member ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'staff.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "staff";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Update Staff Member';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'staff.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Update Staff Member';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'staff.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                  
                  document.getElementById("editStaffForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
                }
                 
             
           });
     
    }else{
     
      var state = "danger";
      content.message = "All Fields are required!";
      content.title = 'Update User';
      if (style == "withicon") {
          content.icon = 'la la-bell';
      } else {
          content.icon = 'none';
      }
      content.url = 'staff.php';
      content.target = '_blank';

      $.notify(content,{
          type: state,
          placement: {
              from: placementFrom,
              align: placementAlign
          },
          time: 800,
      });
      
      document.getElementById("editStaffForm"+id).reset();//empty the form
      $("#view-user"+id).modal('toggle');
      
    }
      
             
    
    e.preventDefault();
    e.stopImmediatePropagation();
});

}

//delete staff
$("#deleteStaffForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var id = $("#delUser").val();
    if(id !== '' ){
      
      $("#delBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Deleting...');
      
      $.ajax({ //make ajax request to cart_process.php
          url: "process/staff.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
            console.log(dataResult);
            $("#delBtn").html('Yes');
            var data = JSON.parse(dataResult);

            document.getElementById("deleteStaffForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');

            if(data.code == 1){
              var state = "success";
              content.message = data.msg;
              content.title = 'Delete Staff';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'staff.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
               setTimeout(function(){
                 window.location = "staff";
               },800);

            }else if(data.code == 2){
                var state = "danger";
                content.message = data.msg;
                content.title = 'Delete Staff';
                if (style == "withicon") {
                    content.icon = 'la la-bell';
                } else {
                    content.icon = 'none';
                }
                content.url = 'staff.php';
                content.target = '_blank';

                $.notify(content,{
                    type: state,
                    placement: {
                        from: placementFrom,
                        align: placementAlign
                    },
                    time: 800,
                });
            }else{
              var state = "danger";
              content.message = "An unknown error occured, try again later!";
              content.title = 'Delete Staff';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'staff.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
            }
            document.getElementById("deleteStaffForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
       });

        
      
    }else{
        var state = "danger";
        content.message = "No User Selected, try again later!";
        content.title = 'Delete Staff';
        if (style == "withicon") {
            content.icon = 'la la-bell';
        } else {
            content.icon = 'none';
        }
        content.url = 'staff.php';
        content.target = '_blank';

        $.notify(content,{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 800,
        });
      
      document.getElementById("deleteStaffForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});
   
//add news attachment
$("#addAttachmentForm").on('submit',function(e){
   var form_data = new FormData(this);
    
    var news_id = $('#post_attachment').val();
   
   
    if(news_id !== ''){

        $("#btn_add_attachment").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
         $.ajax({ //make ajax request to cart_process.php
              url: 'process/news.php',
              type: 'post',
              data : form_data,
              contentType: false,
              cache: false,
              processData:false,
              success: function(dataResult){  //on Ajax success
//                console.log(dataResult);
                $("#btn_add_attachment").html('Finish with attachment');
                var data = JSON.parse(dataResult);
             
                document.getElementById("addAttachmentForm").reset();//empty the form
                $("#add-admin").modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Add News Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'news.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "news";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Add News Attachment';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'news.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Add News Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'news.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                }
                document.getElementById("addAttachmentForm").reset();//empty the form
                $("#add-admin").modal('toggle');
                   },
       });
     
    }else{
        document.getElementById("addAttachmentForm").reset();//empty the form
                $("#add-admin").modal('toggle');
                 var state = "danger";
                  content.message = "All fields are required!";
                  content.title = 'Add News Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'news.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//add attachment from update
$("#addAttachmentForm2").on('submit',function(e){
   var form_data = new FormData(this);
    
    var news_id = $('#post_attachment1').val();
   
   
    if(news_id !== ''){

        $("#btn_add_attachment2").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
         $.ajax({ //make ajax request to cart_process.php
              url: 'process/news.php',
              type: 'post',
              data : form_data,
              contentType: false,
              cache: false,
              processData:false,
              success: function(dataResult){  //on Ajax success
//                console.log(dataResult);
                $("#btn_add_attachment2").html('Save');
                var data = JSON.parse(dataResult);
             
                document.getElementById("addAttachmentForm2").reset();//empty the form
                $("#view-attachment").modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = ' News Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'news.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "news";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'News Attachment';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'news.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'News Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'news.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                }
                document.getElementById("addAttachmentForm2").reset();//empty the form
                $("#view-attachment").modal('toggle');
                   },
       });
     
    }else{
        document.getElementById("addAttachmentForm2").reset();//empty the form
                $("#view-attachment").modal('toggle');
                 var state = "danger";
                  content.message = "All fields are required!";
                  content.title = 'News Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'news.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//delete news
$("#deleteNewsForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var id = $("#delUser").val();
    if(id !== '' ){
      
      $("#delBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Deleting...');
      
      $.ajax({ //make ajax request to cart_process.php
          url: "process/news.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
            console.log(dataResult);
            $("#delBtn").html('Yes');
            var data = JSON.parse(dataResult);

            document.getElementById("deleteNewsForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');

            if(data.code == 1){
              var state = "success";
              content.message = data.msg;
              content.title = 'Delete News Article';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'news.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
               setTimeout(function(){
                 window.location = "news";
               },800);

            }else if(data.code == 2){
                var state = "danger";
                content.message = data.msg;
                content.title = 'Delete News Article';
                if (style == "withicon") {
                    content.icon = 'la la-bell';
                } else {
                    content.icon = 'none';
                }
                content.url = 'news.php';
                content.target = '_blank';

                $.notify(content,{
                    type: state,
                    placement: {
                        from: placementFrom,
                        align: placementAlign
                    },
                    time: 800,
                });
            }else{
              var state = "danger";
              content.message = "An unknown error occured, try again later!";
              content.title = 'Delete News Article';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'news.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
            }
            document.getElementById("deleteNewsForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
       });

        
      
    }else{
        var state = "danger";
        content.message = "No News Article selected, try again later!";
        content.title = 'Delete News Article';
        if (style == "withicon") {
            content.icon = 'la la-bell';
        } else {
            content.icon = 'none';
        }
        content.url = 'news.php';
        content.target = '_blank';

        $.notify(content,{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 800,
        });
      
      document.getElementById("deleteNewsForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});
  
//edit news
function editNews(id){
    $("#editNewsForm"+id).on('submit',function(e){
   var form_data = $(this).serialize();
    
    var title = $("#etitle"+id).val();
    var eUid = id;
    var contentx = $("#econtent"+id).val();
   
    if(title !== '' && eUid !== '' && contentx !== ''){
      
      $("#editUserBtn"+id).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
                $.ajax({ //make ajax request to cart_process.php
              url: "process/news.php",
                  type: "POST",
                  //dataType:"json", //expect json value from server
                  data: form_data
              }).done(function(dataResult){ //on Ajax success
                    
                    console.log(dataResult)
                $("#editUserBtn"+id).html('Update ');
                var data = JSON.parse(dataResult);
             
                document.getElementById("editNewsForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Update News Article ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'news.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "news";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Update News Article';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'news.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Update News Article';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'news.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                  
                  document.getElementById("editNewsForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
                }
                 
             
           });
     
    }else{
     
      var state = "danger";
      content.message = "All Fields are required!";
      content.title = 'Update News Article';
      if (style == "withicon") {
          content.icon = 'la la-bell';
      } else {
          content.icon = 'none';
      }
      content.url = 'news.php';
      content.target = '_blank';

      $.notify(content,{
          type: state,
          placement: {
              from: placementFrom,
              align: placementAlign
          },
          time: 800,
      });
      
      document.getElementById("editNewsForm"+id).reset();//empty the form
      $("#view-user"+id).modal('toggle');
      
    }
      
             
    
    e.preventDefault();
    e.stopImmediatePropagation();
});

}

//edit research
function editResearch(id){
    $("#editResearchForm"+id).on('submit',function(e){
   var form_data = $(this).serialize();
    
    var title = $("#etitle"+id).val();
    var cat_name = $("#cat_name_e"+id).val();
    var eUid = id;
   
    if(title !== '' && eUid !== '' && cat_name !== ''){
      
      $("#editUserBtn"+id).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
                $.ajax({ //make ajax request to cart_process.php
              url: "process/research.php",
                  type: "POST",
                  //dataType:"json", //expect json value from server
                  data: form_data
              }).done(function(dataResult){ //on Ajax success
                    
                $("#editUserBtn"+id).html('Update ');
                var data = JSON.parse(dataResult);
             
                document.getElementById("editResearchForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Update Research Area ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'focus.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "focus";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Update Research';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'focus.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Update Research ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'focus.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                  
                  document.getElementById("editResearchForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
                }
                 
             
           });
     
    }else{
     
      var state = "danger";
      content.message = "All Fields are required!";
      content.title = 'Update Research';
      if (style == "withicon") {
          content.icon = 'la la-bell';
      } else {
          content.icon = 'none';
      }
      content.url = 'research.php';
      content.target = '_blank';

      $.notify(content,{
          type: state,
          placement: {
              from: placementFrom,
              align: placementAlign
          },
          time: 800,
      });
      
      document.getElementById("editResearchForm"+id).reset();//empty the form
      $("#view-user"+id).modal('toggle');
      
    }
      
             
    
    e.preventDefault();
    e.stopImmediatePropagation();
});

}

//add research attachment
$("#addResearchAttachmentForm").on('submit',function(e){
   var form_data = new FormData(this);
    
    var news_id = $('#post_attachment').val();
   
   
    if(news_id !== ''){

        $("#btn_add_attachment").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
         $.ajax({ //make ajax request to cart_process.php
              url: 'process/research.php',
              type: 'post',
              data : form_data,
              contentType: false,
              cache: false,
              processData:false,
              success: function(dataResult){  //on Ajax success
//                console.log(dataResult);
                $("#btn_add_attachment").html('Finish with attachment');
                var data = JSON.parse(dataResult);
             
                document.getElementById("addResearchAttachmentForm").reset();//empty the form
                $("#add-admin").modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Add Research Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'research.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "research";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Add Research Attachment';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'research.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Add Research Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'research.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                }
                document.getElementById("addResearchAttachmentForm").reset();//empty the form
                $("#add-admin").modal('toggle');
                   },
       });
     
    }else{
        document.getElementById("addResearchAttachmentForm").reset();//empty the form
                $("#add-admin").modal('toggle');
                 var state = "danger";
                  content.message = "All fields are required!";
                  content.title = 'Add Research Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'research.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//add attachment from update
$("#addAttachmentForm22").on('submit',function(e){
   var form_data = new FormData(this);
    
    var news_id = $('#post_attachment1').val();
   
   
    if(news_id !== ''){

        $("#btn_add_attachment2").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
         $.ajax({ //make ajax request to cart_process.php
              url: 'process/research.php',
              type: 'post',
              data : form_data,
              contentType: false,
              cache: false,
              processData:false,
              success: function(dataResult){  //on Ajax success
                console.log(dataResult);
                $("#btn_add_attachment2").html('Save');
                var data = JSON.parse(dataResult);
             
                document.getElementById("addAttachmentForm22").reset();//empty the form
                $("#view-attachment").modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = ' Research Area Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'research.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "research";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Research Area Attachment';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'research.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Research Area Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'research.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                }
                document.getElementById("addAttachmentForm22").reset();//empty the form
                $("#view-attachment").modal('toggle');
                   },
       });
     
    }else{
        document.getElementById("addAttachmentForm22").reset();//empty the form
                $("#view-attachment").modal('toggle');
                 var state = "danger";
                  content.message = "All fields are required!";
                  content.title = 'Research Area Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'research.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//delete research
$("#deleteResearchForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var id = $("#delUser").val();
    if(id !== '' ){
      
      $("#delBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Deleting...');
      
      $.ajax({ //make ajax request to cart_process.php
          url: "process/research.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
            console.log(dataResult);
            $("#delBtn").html('Yes');
            var data = JSON.parse(dataResult);

            document.getElementById("deleteResearchForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');

            if(data.code == 1){
              var state = "success";
              content.message = data.msg;
              content.title = 'Delete Research Area';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'research.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
               setTimeout(function(){
                 window.location = "research";
               },800);

            }else if(data.code == 2){
                var state = "danger";
                content.message = data.msg;
                content.title = 'Delete Research Area';
                if (style == "withicon") {
                    content.icon = 'la la-bell';
                } else {
                    content.icon = 'none';
                }
                content.url = 'research.php';
                content.target = '_blank';

                $.notify(content,{
                    type: state,
                    placement: {
                        from: placementFrom,
                        align: placementAlign
                    },
                    time: 800,
                });
            }else{
              var state = "danger";
              content.message = "An unknown error occured, try again later!";
              content.title = 'Delete Research Area';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'research.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
            }
            document.getElementById("deleteResearchForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
       });

        
      
    }else{
        var state = "danger";
        content.message = "No Research Area selected, try again later!";
        content.title = 'Delete Research Area';
        if (style == "withicon") {
            content.icon = 'la la-bell';
        } else {
            content.icon = 'none';
        }
        content.url = 'research.php';
        content.target = '_blank';

        $.notify(content,{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 800,
        });
      
      document.getElementById("deleteResearchForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});
  

//add publication
$("#addPublicationForm").on('submit',function(e){
   var form_data = new FormData(this);
    
    var publication_name = $('#publication_name').val();
    var publication_summary = $('#publication_summary').val();
   
   
    if(publication_name !== '' && publication_summary !== ''){

        $("#btn_add").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
         $.ajax({ //make ajax request to cart_process.php
              url: 'process/publications.php',
              type: 'post',
              data : form_data,
              contentType: false,
              cache: false,
              processData:false,
              success: function(dataResult){  //on Ajax success
                console.log(dataResult);
                $("#btn_add").html('Save');
                var data = JSON.parse(dataResult);
             
                document.getElementById("addPublicationForm").reset();//empty the form
                $("#add-admin").modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = ' Add Publication';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'publications.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "publications";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Add Publication';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'publications.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Add Publication';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'publications.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                }
                document.getElementById("addPublicationForm").reset();//empty the form
                $("#add-admin").modal('toggle');
                   },
       });
     
    }else{
        document.getElementById("addPublicationForm").reset();//empty the form
                $("#add-admin").modal('toggle');
                 var state = "danger";
                  content.message = "All fields are required!";
                  content.title = 'Add Publication';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'publications.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//delete publication deletePublicationForm
$("#deletePublicationForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var id = $("#delUser").val();
    if(id !== '' ){
      
      $("#delBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Deleting...');
      
      $.ajax({ //make ajax request to cart_process.php
          url: "process/publications.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
            console.log(dataResult);
            $("#delBtn").html('Yes');
            var data = JSON.parse(dataResult);

            document.getElementById("deletePublicationForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');

            if(data.code == 1){
              var state = "success";
              content.message = data.msg;
              content.title = 'Delete Publication';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'publications.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
               setTimeout(function(){
                 window.location = "publications";
               },800);

            }else if(data.code == 2){
                var state = "danger";
                content.message = data.msg;
                content.title = 'Delete Publication';
                if (style == "withicon") {
                    content.icon = 'la la-bell';
                } else {
                    content.icon = 'none';
                }
                content.url = 'publications.php';
                content.target = '_blank';

                $.notify(content,{
                    type: state,
                    placement: {
                        from: placementFrom,
                        align: placementAlign
                    },
                    time: 800,
                });
            }else{
              var state = "danger";
              content.message = "An unknown error occured, try again later!";
              content.title = 'Delete Publication';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'publications.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
            }
            document.getElementById("deletePublicationForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
       });

        
      
    }else{
        var state = "danger";
        content.message = "No Publications selected, try again later!";
        content.title = 'Delete Publication';
        if (style == "withicon") {
            content.icon = 'la la-bell';
        } else {
            content.icon = 'none';
        }
        content.url = 'publications.php';
        content.target = '_blank';

        $.notify(content,{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 800,
        });
      
      document.getElementById("deletePublicationForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});
  
//update publication attachment
$("#updatePublicationAttachmentForm2").on('submit',function(e){
   var form_data = new FormData(this);
    
    var publication_id = $('#post_attachment1').val();
   
   
    if(publication_id !== ''){

        $("#btn_add_attachment2").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
         $.ajax({ //make ajax request to cart_process.php
              url: 'process/publications.php',
              type: 'post',
              data : form_data,
              contentType: false,
              cache: false,
              processData:false,
              success: function(dataResult){  //on Ajax success
//                console.log(dataResult);
                $("#btn_add_attachment2").html('Save');
                var data = JSON.parse(dataResult);
             
                document.getElementById("updatePublicationAttachmentForm2").reset();//empty the form
                $("#view-attachment").modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = ' Publication Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'publications.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "publications";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Publication Attachment';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'publications.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Publication Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'publications.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                }
                document.getElementById("updatePublicationAttachmentForm2").reset();//empty the form
                $("#view-attachment").modal('toggle');
                   },
       });
     
    }else{
        document.getElementById("updatePublicationAttachmentForm2").reset();//empty the form
                $("#view-attachment").modal('toggle');
                 var state = "danger";
                  content.message = "All fields are required!";
                  content.title = 'Publication Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'publications.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//edit news
function editPublication(id){
    $("#editPublicationForm"+id).on('submit',function(e){
   var form_data = $(this).serialize();
    
    var title = $("#etitle"+id).val();
    var eUid = id;
    var contentx = $("#econtent"+id).val();
   
    if(title !== '' && eUid !== '' && contentx !== ''){
      
      $("#editUserBtn"+id).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
                $.ajax({ //make ajax request to cart_process.php
              url: "process/publications.php",
                  type: "POST",
                  //dataType:"json", //expect json value from server
                  data: form_data
              }).done(function(dataResult){ //on Ajax success
                    
                    console.log(dataResult)
                $("#editUserBtn"+id).html('Update ');
                var data = JSON.parse(dataResult);
             
                document.getElementById("editPublicationForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Update Publication ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'publications.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "publications";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Update Publication';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'publications.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Update Publication';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'publications.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                  
                  document.getElementById("editPublicationForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
                }
                 
             
           });
     
    }else{
     
      var state = "danger";
      content.message = "All Fields are required!";
      content.title = 'Update Publication';
      if (style == "withicon") {
          content.icon = 'la la-bell';
      } else {
          content.icon = 'none';
      }
      content.url = 'publications.php';
      content.target = '_blank';

      $.notify(content,{
          type: state,
          placement: {
              from: placementFrom,
              align: placementAlign
          },
          time: 800,
      });
      
      document.getElementById("editPublicationForm"+id).reset();//empty the form
      $("#view-user"+id).modal('toggle');
      
    }
      
             
    
    e.preventDefault();
    e.stopImmediatePropagation();
});

}

//add project
$("#addProjectForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var title = $("#title").val();
    var contentx = $("#content").val();
    var project_period = $("#period").val();
 
  
    
    if(title !== '' &&  contentx !== '' && project_period !== ''){
          $("#addUserBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
           $.ajax({ //make ajax request to cart_process.php
              url: "process/projects.php",
                  type: "POST",
                  //dataType:"json", //expect json value from server
                  data: form_data
              }).done(function(dataResult){ //on Ajax success
                console.log(dataResult);
                $("#addUserBtn").html('Next');
                var data = JSON.parse(dataResult);
             
                document.getElementById("addProjectForm").reset();//empty the form
//                $("#add-admin").modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Add Project';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'projects.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
//                   setTimeout(function(){
//                     window.location = "projects";
//                   },800);
                    $("#post_attachment").val(data.id)
                    $("#addProjectForm").hide(500);
                    $("#addProjectAttachmentForm").show(700);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Add Project';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'projects.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Add Project';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'projects.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                }
//                document.getElementById("addProjectForm").reset();//empty the form
//                $("#add-admin").modal('toggle');
           });

        
    }else{
      $("#add-admin").modal('toggle');
        var state = "danger";
        content.message = "All fields are required";
        content.title = 'Add Projects';
        if (style == "withicon") {
            content.icon = 'la la-bell';
        } else {
            content.icon = 'none';
        }
        content.url = 'projects.php';
        content.target = '_blank';

        $.notify(content,{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 1000,
        });
      
          $("#add-admin").modal('toggle');
    }
  
 
    e.preventDefault();
    e.stopImmediatePropagation();
});

//add news attachment
$("#addProjectAttachmentForm").on('submit',function(e){
   var form_data = new FormData(this);
    
    var news_id = $('#post_attachment').val();
   
   
    if(news_id !== ''){

        $("#btn_add_attachment").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
         $.ajax({ //make ajax request to cart_process.php
              url: 'process/projects.php',
              type: 'post',
              data : form_data,
              contentType: false,
              cache: false,
              processData:false,
              success: function(dataResult){  //on Ajax success
//                console.log(dataResult);
                $("#btn_add_attachment").html('Finish with attachment');
                var data = JSON.parse(dataResult);
             
                document.getElementById("addProjectAttachmentForm").reset();//empty the form
                $("#add-admin").modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Add Projects Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'projects.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "projects";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Add Projects Attachment';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'projects.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Add Projects Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'projects.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                }
                document.getElementById("addProjectAttachmentForm").reset();//empty the form
                $("#add-admin").modal('toggle');
                   },
       });
     
    }else{
        document.getElementById("addProjectAttachmentForm").reset();//empty the form
                $("#add-admin").modal('toggle');
                 var state = "danger";
                  content.message = "All fields are required!";
                  content.title = 'Add Projects Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'projects.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//add project attachment from update
$("#addProjectsAttachmentForm2").on('submit',function(e){
   var form_data = new FormData(this);
    
    var news_id = $('#post_attachment1').val();
   
   
    if(news_id !== ''){

        $("#btn_add_attachment2").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
         $.ajax({ //make ajax request to cart_process.php
              url: 'process/projects.php',
              type: 'post',
              data : form_data,
              contentType: false,
              cache: false,
              processData:false,
              success: function(dataResult){  //on Ajax success
//                console.log(dataResult);
                $("#btn_add_attachment2").html('Save');
                var data = JSON.parse(dataResult);
             
                document.getElementById("addProjectsAttachmentForm2").reset();//empty the form
                $("#view-attachment").modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = ' Project Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'projects.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "projects";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Project Attachment';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'projects.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Project Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'projects.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                }
                document.getElementById("addProjectsAttachmentForm2").reset();//empty the form
                $("#view-attachment").modal('toggle');
                   },
       });
     
    }else{
        document.getElementById("addProjectsAttachmentForm2").reset();//empty the form
                $("#view-attachment").modal('toggle');
                 var state = "danger";
                  content.message = "All fields are required!";
                  content.title = 'Project Attachment';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'projects.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//delete project
$("#deleteProjectsForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var id = $("#delUser").val();
    if(id !== '' ){
      
      $("#delBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Deleting...');
      
      $.ajax({ //make ajax request to cart_process.php
          url: "process/projects.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
            console.log(dataResult);
            $("#delBtn").html('Yes');
            var data = JSON.parse(dataResult);

            document.getElementById("deleteProjectsForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');

            if(data.code == 1){
              var state = "success";
              content.message = data.msg;
              content.title = 'Delete Project';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'project.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
               setTimeout(function(){
                 window.location = "projects";
               },800);

            }else if(data.code == 2){
                var state = "danger";
                content.message = data.msg;
                content.title = 'Delete Project';
                if (style == "withicon") {
                    content.icon = 'la la-bell';
                } else {
                    content.icon = 'none';
                }
                content.url = 'projects.php';
                content.target = '_blank';

                $.notify(content,{
                    type: state,
                    placement: {
                        from: placementFrom,
                        align: placementAlign
                    },
                    time: 800,
                });
            }else{
              var state = "danger";
              content.message = "An unknown error occured, try again later!";
              content.title = 'Delete Projects';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'projects.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
            }
            document.getElementById("deleteProjectsForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
       });

        
      
    }else{
        var state = "danger";
        content.message = "No Project selected, try again later!";
        content.title = 'Delete Project';
        if (style == "withicon") {
            content.icon = 'la la-bell';
        } else {
            content.icon = 'none';
        }
        content.url = 'projects.php';
        content.target = '_blank';

        $.notify(content,{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 800,
        });
      
      document.getElementById("deleteProjectsForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});
  
//edit project
function editProject(id){
    $("#editProjectForm"+id).on('submit',function(e){
   var form_data = $(this).serialize();
    
    var title = $("#etitle"+id).val();
    var eUid = id;
    var contentx = $("#econtent"+id).val();
    var period = $("#eperiod"+id).val();
   
    if(title !== '' && eUid !== '' && contentx !== '' && period !== ''){
      
      $("#editUserBtn"+id).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
                $.ajax({ //make ajax request to cart_process.php
              url: "process/projects.php",
                  type: "POST",
                  //dataType:"json", //expect json value from server
                  data: form_data
              }).done(function(dataResult){ //on Ajax success
                    
                    console.log(dataResult)
                $("#editUserBtn"+id).html('Update ');
                var data = JSON.parse(dataResult);
             
                document.getElementById("editProjectForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Update Project ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'projects.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "projects";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Update Projects';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'projects.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Update Project';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'projects.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                  
                  document.getElementById("editProjectForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
                }
                 
             
           });
     
    }else{
     
      var state = "danger";
      content.message = "All Fields are required!";
      content.title = 'Update Project';
      if (style == "withicon") {
          content.icon = 'la la-bell';
      } else {
          content.icon = 'none';
      }
      content.url = 'projects.php';
      content.target = '_blank';

      $.notify(content,{
          type: state,
          placement: {
              from: placementFrom,
              align: placementAlign
          },
          time: 800,
      });
      
      document.getElementById("editProjectForm"+id).reset();//empty the form
      $("#view-user"+id).modal('toggle');
      
    }
      
             
    
    e.preventDefault();
    e.stopImmediatePropagation();
});

}

//delete photo
$("#deletePhotoForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var id = $("#delUser").val();
    if(id !== '' ){
      
      $("#delBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Deleting...');
      
      $.ajax({ //make ajax request to cart_process.php
          url: "process/gallery.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
            console.log(dataResult);
            $("#delBtn").html('Yes');
            var data = JSON.parse(dataResult);

            document.getElementById("deletePhotoForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');

            if(data.code == 1){
              var state = "success";
              content.message = data.msg;
              content.title = 'Delete Photo';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'gallery.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
               setTimeout(function(){
                 window.location = "gallery";
               },800);

            }else if(data.code == 2){
                var state = "danger";
                content.message = data.msg;
                content.title = 'Delete Photo';
                if (style == "withicon") {
                    content.icon = 'la la-bell';
                } else {
                    content.icon = 'none';
                }
                content.url = 'gallery.php';
                content.target = '_blank';

                $.notify(content,{
                    type: state,
                    placement: {
                        from: placementFrom,
                        align: placementAlign
                    },
                    time: 800,
                });
            }else{
              var state = "danger";
              content.message = "An unknown error occured, try again later!";
              content.title = 'Delete Photo';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'gallery.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
            }
            document.getElementById("deletePhotoForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
       });

        
      
    }else{
        var state = "danger";
        content.message = "No User Selected, try again later!";
        content.title = 'Delete Photo';
        if (style == "withicon") {
            content.icon = 'la la-bell';
        } else {
            content.icon = 'none';
        }
        content.url = 'gallery.php';
        content.target = '_blank';

        $.notify(content,{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 800,
        });
      
      document.getElementById("deletePhotoForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});
   
//add category
$("#addCategoryForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var email = $("#cat_name").val();
    if(email !== '' ){
      
      $("#btn_add").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Adding...');
       $.ajax({ //make ajax request to cart_process.php
          url: "process/focus_category.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
         $("#btn_add").html('Submit')
       				console.log(dataResult);
						
						var data = JSON.parse(dataResult);
						$("#btn_add").html('Submit');
					  if(data.code==1){
						  //Uploaded and finish
							 var state = "success";
							  content.message = data.msg;
							  content.title = 'Add category';
							  if (style == "withicon") {
								  content.icon = 'la la-bell';
							  } else {
								  content.icon = 'none';
							  }
							  content.url = 'focus_category.php';
							  content.target = '_blank';

							  $.notify(content,{
								  type: state,
								  placement: {
									  from: placementFrom,
									  align: placementAlign
								  },
								  time: 800,
							  });
						
//							$("#add-admin").modal("toggle");
						  	 document.getElementById("addCategoryForm").reset();//empty the form
						  
						   setTimeout(function(){ 
							  window.location = "focus_category.php";
                               
							}, 500);
					  }else{
						  	var state = "danger";
							  content.message = data.msg;
							  content.title = 'Add Category';
							  if (style == "withicon") {
								  content.icon = 'la la-bell';
							  } else {
								  content.icon = 'none';
							  }
							  content.url = 'focus_category.php';
							  content.target = '_blank';

							  $.notify(content,{
								  type: state,
								  placement: {
									  from: placementFrom,
									  align: placementAlign
								  },
								  time: 800,
							  });
							$("#add-admin").modal("toggle");
						  	 document.getElementById("addCategoryForm").reset();//empty the form
					  }


       });
     
    }else{
      $("#loginResponse").html('<p class="alert alert-danger text-center">Both fields are required</p>');
       setTimeout(function(){
                  $("#loginResponse").fadeOut();
              },1500);
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//edit category
function editCategory(id){
    $("#editCategoryForm"+id).on('submit',function(e){
   var form_data = $(this).serialize();
    
    var title = $("#etitle"+id).val();
    var eUid = id;
   
    if(title !== '' && eUid !== '' ){
      
      $("#editUserBtn"+id).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
                $.ajax({ //make ajax request to cart_process.php
              url: "process/focus_category.php",
                  type: "POST",
                  //dataType:"json", //expect json value from server
                  data: form_data
              }).done(function(dataResult){ //on Ajax success
                    
                $("#editUserBtn"+id).html('Update ');
                var data = JSON.parse(dataResult);
             
                document.getElementById("editCategoryForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Update Category Name';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'focus_category.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "focus_category.php";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Update Category Name';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'focus_category.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Update Category Name ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'focus_category.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                  
                  document.getElementById("editCategoryForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
                }
                 
             
           });
     
    }else{
     
      var state = "danger";
      content.message = "All Fields are required!";
      content.title = 'Update Category Name';
      if (style == "withicon") {
          content.icon = 'la la-bell';
      } else {
          content.icon = 'none';
      }
      content.url = 'focus_category.php';
      content.target = '_blank';

      $.notify(content,{
          type: state,
          placement: {
              from: placementFrom,
              align: placementAlign
          },
          time: 800,
      });
      
      document.getElementById("editCategoryForm"+id).reset();//empty the form
      $("#view-user"+id).modal('toggle');
      
    }
      
             
    
    e.preventDefault();
    e.stopImmediatePropagation();
});

}

//delete category
$("#deleteCategoryForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var id = $("#delUser").val();
    if(id !== '' ){
      
      $("#delBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Deleting...');
      
      $.ajax({ //make ajax request to cart_process.php
          url: "process/focus_category.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
            console.log(dataResult);
            $("#delBtn").html('Yes');
            var data = JSON.parse(dataResult);

            document.getElementById("deleteCategoryForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');

            if(data.code == 1){
              var state = "success";
              content.message = data.msg;
              content.title = 'Delete Category';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'focus_category.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
               setTimeout(function(){
                 window.location = "focus_category.php";
               },800);

            }else if(data.code == 2){
                var state = "danger";
                content.message = data.msg;
                content.title = 'Delete Category';
                if (style == "withicon") {
                    content.icon = 'la la-bell';
                } else {
                    content.icon = 'none';
                }
                content.url = 'focus_category.php';
                content.target = '_blank';

                $.notify(content,{
                    type: state,
                    placement: {
                        from: placementFrom,
                        align: placementAlign
                    },
                    time: 800,
                });
            }else{
              var state = "danger";
              content.message = "An unknown error occured, try again later!";
              content.title = 'Delete Category';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'focus_category.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
            }
            document.getElementById("deleteCategoryForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
       });

        
      
    }else{
        var state = "danger";
        content.message = "No Research Area selected, try again later!";
        content.title = 'Delete Category';
        if (style == "withicon") {
            content.icon = 'la la-bell';
        } else {
            content.icon = 'none';
        }
        content.url = 'focus_category.php';
        content.target = '_blank';

        $.notify(content,{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 800,
        });
      
      document.getElementById("deleteCategoryForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});
 
//add folder
$("#addFolderForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var email = $("#folder_name").val();
    if(email !== '' ){
      
      $("#btn_add").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Adding...');
       $.ajax({ //make ajax request to cart_process.php
          url: "process/folder.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
         $("#btn_add").html('Submit')
       				console.log(dataResult);
						
						var data = JSON.parse(dataResult);
						$("#btn_add").html('Submit');
					  if(data.code==1){
						  //Uploaded and finish
							 var state = "success";
							  content.message = data.msg;
							  content.title = 'Add Folder';
							  if (style == "withicon") {
								  content.icon = 'la la-bell';
							  } else {
								  content.icon = 'none';
							  }
							  content.url = 'gallery_folder.php';
							  content.target = '_blank';

							  $.notify(content,{
								  type: state,
								  placement: {
									  from: placementFrom,
									  align: placementAlign
								  },
								  time: 800,
							  });
						
//							$("#add-admin").modal("toggle");
						  	 document.getElementById("addFolderForm").reset();//empty the form
						  
						   setTimeout(function(){ 
							  window.location = "gallery_folder.php";
                               
							}, 500);
					  }else{
						  	var state = "danger";
							  content.message = data.msg;
							  content.title = 'Add Folder';
							  if (style == "withicon") {
								  content.icon = 'la la-bell';
							  } else {
								  content.icon = 'none';
							  }
							  content.url = 'gallery_folder.php';
							  content.target = '_blank';

							  $.notify(content,{
								  type: state,
								  placement: {
									  from: placementFrom,
									  align: placementAlign
								  },
								  time: 800,
							  });
							$("#add-admin").modal("toggle");
						  	 document.getElementById("addFolderForm").reset();//empty the form
					  }


       });
     
    }else{
      $("#loginResponse").html('<p class="alert alert-danger text-center">Both fields are required</p>');
       setTimeout(function(){
                  $("#loginResponse").fadeOut();
              },1500);
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//edit folder
function editFolder(id){
    $("#editFolderForm"+id).on('submit',function(e){
   var form_data = $(this).serialize();
    
    var title = $("#etitle"+id).val();
    var eUid = id;
   
    if(title !== '' && eUid !== '' ){
      
      $("#editUserBtn"+id).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
                $.ajax({ //make ajax request to cart_process.php
              url: "process/folder.php",
                  type: "POST",
                  //dataType:"json", //expect json value from server
                  data: form_data
              }).done(function(dataResult){ //on Ajax success
                    
                $("#editUserBtn"+id).html('Update ');
                var data = JSON.parse(dataResult);
             
                document.getElementById("editFolderForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Rename Folder';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'gallery_folder.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "gallery_folder.php";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Rename Folder';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'gallery_folder.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Update Folder ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'gallery_folder.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                  
                  document.getElementById("editFolderForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
                }
                 
             
           });
     
    }else{
     
      var state = "danger";
      content.message = "All Fields are required!";
      content.title = 'Rename Folder';
      if (style == "withicon") {
          content.icon = 'la la-bell';
      } else {
          content.icon = 'none';
      }
      content.url = 'gallery_folder.php';
      content.target = '_blank';

      $.notify(content,{
          type: state,
          placement: {
              from: placementFrom,
              align: placementAlign
          },
          time: 800,
      });
      
      document.getElementById("editFolderForm"+id).reset();//empty the form
      $("#view-user"+id).modal('toggle');
      
    }
      
             
    
    e.preventDefault();
    e.stopImmediatePropagation();
});

}

//delete folder
$("#deleteFolderForm").on('submit',function(e){
   var form_data = $(this).serialize();
    
    var id = $("#delUser").val();
    if(id !== '' ){
      
      $("#delBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Deleting...');
      
      $.ajax({ //make ajax request to cart_process.php
          url: "process/folder.php",
              type: "POST",
              //dataType:"json", //expect json value from server
              data: form_data
          }).done(function(dataResult){ //on Ajax success
            console.log(dataResult);
            $("#delBtn").html('Yes');
            var data = JSON.parse(dataResult);

            document.getElementById("deleteFolderForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');

            if(data.code == 1){
              var state = "success";
              content.message = data.msg;
              content.title = 'Delete Folder';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'gallery_folder.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
               setTimeout(function(){
                 window.location = "gallery_folder.php";
               },800);

            }else if(data.code == 2){
                var state = "danger";
                content.message = data.msg;
                content.title = 'Delete Folder';
                if (style == "withicon") {
                    content.icon = 'la la-bell';
                } else {
                    content.icon = 'none';
                }
                content.url = 'gallery_folder.php';
                content.target = '_blank';

                $.notify(content,{
                    type: state,
                    placement: {
                        from: placementFrom,
                        align: placementAlign
                    },
                    time: 800,
                });
            }else{
              var state = "danger";
              content.message = "An unknown error occured, try again later!";
              content.title = 'Delete Folder';
              if (style == "withicon") {
                  content.icon = 'la la-bell';
              } else {
                  content.icon = 'none';
              }
              content.url = 'gallery_folder.php';
              content.target = '_blank';

              $.notify(content,{
                  type: state,
                  placement: {
                      from: placementFrom,
                      align: placementAlign
                  },
                  time: 800,
              });
            }
            document.getElementById("deleteFolderForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
       });

        
      
    }else{
        var state = "danger";
        content.message = "No Research Area selected, try again later!";
        content.title = 'Delete Folder';
        if (style == "withicon") {
            content.icon = 'la la-bell';
        } else {
            content.icon = 'none';
        }
        content.url = 'gallery_folder.php';
        content.target = '_blank';

        $.notify(content,{
            type: state,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 800,
        });
      
      document.getElementById("deleteFolderForm").reset();//empty the form
            $("#deleteUserModal").modal('toggle');
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});


//add focus area
$("#addFocusAreaCatForm").on('submit',function(e){
    var form_data = $(this).serialize();
     
     var title = $("#title").val();
     var contentx = $("#content").val();
  
   
     
     if(title !== '' &&  contentx !== '' ){
           $("#addUserBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
            $.ajax({ //make ajax request to cart_process.php
               url: "process/focus_cat.php",
                   type: "POST",
                   //dataType:"json", //expect json value from server
                   data: form_data
               }).done(function(dataResult){ //on Ajax success
                 console.log(dataResult);
                 $("#addUserBtn").html('Next');
                 var data = JSON.parse(dataResult);
              
                 document.getElementById("addFocusAreaCatForm").reset();//empty the form
 //                $("#add-admin").modal('toggle');
              
                 if(data.code == 1){
                   var state = "success";
                   content.message = data.msg;
                   content.title = 'Add Focus Area Category';
                   if (style == "withicon") {
                       content.icon = 'la la-bell';
                   } else {
                       content.icon = 'none';
                   }
                   content.url = 'focus_category.php';
                   content.target = '_blank';
 
                   $.notify(content,{
                       type: state,
                       placement: {
                           from: placementFrom,
                           align: placementAlign
                       },
                       time: 800,
                   });
 //                   setTimeout(function(){
 //                     window.location = "projects";
 //                   },800);
                     $("#post_attachment").val(data.id)
                     $("#addFocusAreaCatForm ").hide(500);
                     $("#addFocusCatAttachmentForm").show(700);
                   
                 }else if(data.code == 2){
                     var state = "danger";
                     content.message = data.msg;
                     content.title = 'Add Focus Area Category';
                     if (style == "withicon") {
                         content.icon = 'la la-bell';
                     } else {
                         content.icon = 'none';
                     }
                     content.url = 'focus_category.php';
                     content.target = '_blank';
 
                     $.notify(content,{
                         type: state,
                         placement: {
                             from: placementFrom,
                             align: placementAlign
                         },
                         time: 800,
                     });
                 }else{
                   var state = "danger";
                   content.message = "An unknown error occured, try again later!";
                   content.title = 'Add Focus Area Category';
                   if (style == "withicon") {
                       content.icon = 'la la-bell';
                   } else {
                       content.icon = 'none';
                   }
                   content.url = 'focus_category.php';
                   content.target = '_blank';
 
                   $.notify(content,{
                       type: state,
                       placement: {
                           from: placementFrom,
                           align: placementAlign
                       },
                       time: 800,
                   });
                 }
 //                document.getElementById("addProjectForm").reset();//empty the form
 //                $("#add-admin").modal('toggle');
            });
 
         
     }else{
       $("#add-admin").modal('toggle');
         var state = "danger";
         content.message = "All fields are required";
         content.title = 'Add Focus Area Category';
         if (style == "withicon") {
             content.icon = 'la la-bell';
         } else {
             content.icon = 'none';
         }
         content.url = 'focus_category.php';
         content.target = '_blank';
 
         $.notify(content,{
             type: state,
             placement: {
                 from: placementFrom,
                 align: placementAlign
             },
             time: 1000,
         });
       
           $("#add-admin").modal('toggle');
     }
   
  
     e.preventDefault();
     e.stopImmediatePropagation();
 });

 //edit focus area
function editFocusAreaCat(id){
    $("#editFocusAreaCatForm"+id).on('submit',function(e){
   var form_data = $(this).serialize();
    
    var title = $("#etitle"+id).val();
    var eUid = id;
    var contentx = $("#econtent"+id).val();
   
    if(title !== '' && eUid !== '' && contentx !== ''){
      
      $("#editUserBtn"+id).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
                $.ajax({ //make ajax request to cart_process.php
              url: "process/focus_cat.php",
                  type: "POST",
                  //dataType:"json", //expect json value from server
                  data: form_data
              }).done(function(dataResult){ //on Ajax success
                    
                    console.log(dataResult)
                $("#editUserBtn"+id).html('Update ');
                var data = JSON.parse(dataResult);
             
                document.getElementById("editFocusAreaCatForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Update ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'focus_category.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "focus_category.php";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Update ';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'focus_category.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Update ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'focus_category.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                  
                  document.getElementById("editFocusAreaCatForm"+id).reset();//empty the form
                $("#view-user"+id).modal('toggle');
                }
                 
             
           });
     
    }else{
     
      var state = "danger";
      content.message = "All Fields are required!";
      content.title = 'Update ';
      if (style == "withicon") {
          content.icon = 'la la-bell';
      } else {
          content.icon = 'none';
      }
      content.url = 'focus_category.php';
      content.target = '_blank';

      $.notify(content,{
          type: state,
          placement: {
              from: placementFrom,
              align: placementAlign
          },
          time: 800,
      });
      
      document.getElementById("editFocusAreaCatForm"+id).reset();//empty the form
      $("#view-user"+id).modal('toggle');
      
    }
      
             
    
    e.preventDefault();
    e.stopImmediatePropagation();
});

}

//add focus area picture from update
$("#addFocusCatAttachmentForm2").on('submit',function(e){
    var form_data = new FormData(this);
     
     var news_id = $('#post_attachment1').val();
    
    
     if(news_id !== ''){
 
         $("#btn_add_attachment2").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
          $.ajax({ //make ajax request to cart_process.php
               url: 'process/focus_cat.php',
               type: 'post',
               data : form_data,
               contentType: false,
               cache: false,
               processData:false,
               success: function(dataResult){  //on Ajax success
 //                console.log(dataResult);
                 $("#btn_add_attachment2").html('Save');
                 var data = JSON.parse(dataResult);
              
                 document.getElementById("addFocusCatAttachmentForm2").reset();//empty the form
                 $("#view-attachment").modal('toggle');
              
                 if(data.code == 1){
                   var state = "success";
                   content.message = data.msg;
                   content.title = ' Picture';
                   if (style == "withicon") {
                       content.icon = 'la la-bell';
                   } else {
                       content.icon = 'none';
                   }
                   content.url = 'focus_category.php';
                   content.target = '_blank';
 
                   $.notify(content,{
                       type: state,
                       placement: {
                           from: placementFrom,
                           align: placementAlign
                       },
                       time: 800,
                   });
                    setTimeout(function(){
                      window.location = "focus_category.php";
                    },800);
                   
                 }else if(data.code == 2){
                     var state = "danger";
                     content.message = data.msg;
                     content.title = 'Picture';
                     if (style == "withicon") {
                         content.icon = 'la la-bell';
                     } else {
                         content.icon = 'none';
                     }
                     content.url = 'focus_category.php';
                     content.target = '_blank';
 
                     $.notify(content,{
                         type: state,
                         placement: {
                             from: placementFrom,
                             align: placementAlign
                         },
                         time: 800,
                     });
                 }else{
                   var state = "danger";
                   content.message = "An unknown error occured, try again later!";
                   content.title = 'Picture';
                   if (style == "withicon") {
                       content.icon = 'la la-bell';
                   } else {
                       content.icon = 'none';
                   }
                   content.url = 'focus_category.php';
                   content.target = '_blank';
 
                   $.notify(content,{
                       type: state,
                       placement: {
                           from: placementFrom,
                           align: placementAlign
                       },
                       time: 800,
                   });
                 }
                 document.getElementById("addFocusCatAttachmentForm2").reset();//empty the form
                 $("#view-attachment").modal('toggle');
                    },
        });
      
     }else{
         document.getElementById("addFocusCatAttachmentForm2").reset();//empty the form
                 $("#view-attachment").modal('toggle');
                  var state = "danger";
                   content.message = "All fields are required!";
                   content.title = 'Picture';
                   if (style == "withicon") {
                       content.icon = 'la la-bell';
                   } else {
                       content.icon = 'none';
                   }
                   content.url = 'focus_category.php';
                   content.target = '_blank';
 
                   $.notify(content,{
                       type: state,
                       placement: {
                           from: placementFrom,
                           align: placementAlign
                       },
                       time: 800,
                   });
     }
     e.preventDefault();
     e.stopImmediatePropagation();
 });
 
//delete project
$("#deleteFocusCatForm").on('submit',function(e){
    var form_data = $(this).serialize();
     
     var id = $("#delUser").val();
     if(id !== '' ){
       
       $("#delBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Deleting...');
       
       $.ajax({ //make ajax request to cart_process.php
            url: "process/focus_cat.php",
               type: "POST",
               //dataType:"json", //expect json value from server
               data: form_data
           }).done(function(dataResult){ //on Ajax success
             console.log(dataResult);
             $("#delBtn").html('Yes');
             var data = JSON.parse(dataResult);
 
             document.getElementById("deleteFocusCatForm").reset();//empty the form
             $("#deleteUserModal").modal('toggle');
 
             if(data.code == 1){
               var state = "success";
               content.message = data.msg;
               content.title = 'Delete ';
               if (style == "withicon") {
                   content.icon = 'la la-bell';
               } else {
                   content.icon = 'none';
               }
               content.url = 'focus_category.php';
               content.target = '_blank';
 
               $.notify(content,{
                   type: state,
                   placement: {
                       from: placementFrom,
                       align: placementAlign
                   },
                   time: 800,
               });
                setTimeout(function(){
                  window.location = "focus_category.php";
                },800);
 
             }else if(data.code == 2){
                 var state = "danger";
                 content.message = data.msg;
                 content.title = 'Delete '
                 if (style == "withicon") {
                     content.icon = 'la la-bell';
                 } else {
                     content.icon = 'none';
                 }
                 content.url = 'focus_category.php';
                 content.target = '_blank';
 
                 $.notify(content,{
                     type: state,
                     placement: {
                         from: placementFrom,
                         align: placementAlign
                     },
                     time: 800,
                 });
             }else{
               var state = "danger";
               content.message = "An unknown error occured, try again later!";
               content.title = 'Delete ';
               if (style == "withicon") {
                   content.icon = 'la la-bell';
               } else {
                   content.icon = 'none';
               }
               content.url = 'focus_category.php';
               content.target = '_blank';
 
               $.notify(content,{
                   type: state,
                   placement: {
                       from: placementFrom,
                       align: placementAlign
                   },
                   time: 800,
               });
             }
             document.getElementById("deleteFocusCatForm").reset();//empty the form
             $("#deleteUserModal").modal('toggle');
        });
 
         
       
     }else{
         var state = "danger";
         content.message = "None selected, try again later!";
         content.title = 'Delete ';
         if (style == "withicon") {
             content.icon = 'la la-bell';
         } else {
             content.icon = 'none';
         }
         content.url = 'focus_cat.php';
         content.target = '_blank';
 
         $.notify(content,{
             type: state,
             placement: {
                 from: placementFrom,
                 align: placementAlign
             },
             time: 800,
         });
       
       document.getElementById("deleteFocusCatForm").reset();//empty the form
             $("#deleteUserModal").modal('toggle');
     }
     e.preventDefault();
     e.stopImmediatePropagation();
 });
   
//add news attachment
$("#addFocusCatAttachmentForm").on('submit',function(e){
    var form_data = new FormData(this);
     
     var news_id = $('#post_attachment').val();
    
    
     if(news_id !== ''){
 
         $("#btn_add_attachment").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
          $.ajax({ //make ajax request to cart_process.php
               url: 'process/focus_cat.php',
               type: 'post',
               data : form_data,
               contentType: false,
               cache: false,
               processData:false,
               success: function(dataResult){  //on Ajax success
 //                console.log(dataResult);
                 $("#btn_add_attachment").html('Finish with attachment');
                 var data = JSON.parse(dataResult);
              
                 document.getElementById("addFocusCatAttachmentForm").reset();//empty the form
                 $("#add-admin").modal('toggle');
              
                 if(data.code == 1){
                   var state = "success";
                   content.message = data.msg;
                   content.title = 'Add Picture';
                   if (style == "withicon") {
                       content.icon = 'la la-bell';
                   } else {
                       content.icon = 'none';
                   }
                   content.url = 'focus_category.php';
                   content.target = '_blank';
 
                   $.notify(content,{
                       type: state,
                       placement: {
                           from: placementFrom,
                           align: placementAlign
                       },
                       time: 800,
                   });
                    setTimeout(function(){
                      window.location = "focus_category.php";
                    },800);
                   
                 }else if(data.code == 2){
                     var state = "danger";
                     content.message = data.msg;
                     content.title = 'Add Picture';
                     if (style == "withicon") {
                         content.icon = 'la la-bell';
                     } else {
                         content.icon = 'none';
                     }
                     content.url = 'focus_category.php';
                     content.target = '_blank';
 
                     $.notify(content,{
                         type: state,
                         placement: {
                             from: placementFrom,
                             align: placementAlign
                         },
                         time: 800,
                     });
                 }else{
                   var state = "danger";
                   content.message = "An unknown error occured, try again later!";
                   content.title = 'Add Picture';
                   if (style == "withicon") {
                       content.icon = 'la la-bell';
                   } else {
                       content.icon = 'none';
                   }
                   content.url = 'focus_category.php';
                   content.target = '_blank';
 
                   $.notify(content,{
                       type: state,
                       placement: {
                           from: placementFrom,
                           align: placementAlign
                       },
                       time: 800,
                   });
                 }
                 document.getElementById("addFocusCatAttachmentForm").reset();//empty the form
                 $("#add-admin").modal('toggle');
                    },
        });
      
     }else{
         document.getElementById("addFocusCatAttachmentForm").reset();//empty the form
                 $("#add-admin").modal('toggle');
                  var state = "danger";
                   content.message = "All fields are required!";
                   content.title = 'Add Picture';
                   if (style == "withicon") {
                       content.icon = 'la la-bell';
                   } else {
                       content.icon = 'none';
                   }
                   content.url = 'focus_category.php';
                   content.target = '_blank';
 
                   $.notify(content,{
                       type: state,
                       placement: {
                           from: placementFrom,
                           align: placementAlign
                       },
                       time: 800,
                   });
     }
     e.preventDefault();
     e.stopImmediatePropagation();
 });
 


















//delete meal
$("#deleteMealForm").on('submit',function(e){
   var form_data = new FormData(this);
      
      $("#addSliderBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Deleting...');
        
        $.ajax({ //make ajax request to cart_process.php
          url: 'process/meals.php',
          type: 'post',
          data : form_data,
          contentType: false,
          cache: false,
          processData:false,
          success: function(dataResult){ //on Ajax success
            $("#addSliderBtn").html('Yes');
                var data = JSON.parse(dataResult);
             
                document.getElementById("deleteMealForm").reset();//empty the form
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Delete meal ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'meals.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "meals";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Delete Meal';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'meals.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Delete Meal';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'meals.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                  
                  document.getElementById("deleteMealForm").reset();//empty the form
                $("#deleteMeal").modal('toggle');
                }
                 
             
          
              
          },
       });

    e.preventDefault();
    e.stopImmediatePropagation();
});


//delete menu
$("#deleteMenuForm").on('submit',function(e){
   var form_data = new FormData(this);
      
      $("#addSliderBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Deleting...');
        
        $.ajax({ //make ajax request to cart_process.php
          url: 'process/menus.php',
          type: 'post',
          data : form_data,
          contentType: false,
          cache: false,
          processData:false,
          success: function(dataResult){ //on Ajax success
//              console.log(dataResult)
            $("#addSliderBtn").html('Yes');
                var data = JSON.parse(dataResult);
             
                document.getElementById("deleteMenuForm").reset();//empty the form
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Delete Menu Item ';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'menus.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "menus";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Delete Menu Item';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'menus.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Delete Menu Item';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'menus.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                  
                  document.getElementById("deleteMenuForm").reset();//empty the form
                $("#deleteMeal").modal('toggle');
                }
                 
             
          
              
          },
       });

    e.preventDefault();
    e.stopImmediatePropagation();
});

//update meal menu
function setUpdateMenu(id){
    
    $("#menu_id"+id).val(id);
    
    $("#updateMenuForm"+id).on('submit',function(e){
   var form_data = $(this).serialize();
    
    var meal_id = $('#selUser'+id).val();
    var meal_type = $('#meal_type'+id).val();
    var menu_expiry = $('#menu_expiry'+id).val();
   
    if(meal_id !== '' && meal_type !== '' && menu_expiry){

        $("#addUserBtn"+id).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Saving...');
           $.ajax({ //make ajax request to cart_process.php
              url: "process/menus.php",
                  type: "POST",
                  //dataType:"json", //expect json value from server
                  data: form_data
              }).done(function(dataResult){ //on Ajax success
                $("#addUserBtn"+id).html('Update Menu Item');
                var data = JSON.parse(dataResult);
             
                document.getElementById("updateMenuForm"+id).reset();//empty the form
                $("#add-admin"+id).modal('toggle');
             
                if(data.code == 1){
                  var state = "success";
                  content.message = data.msg;
                  content.title = 'Add Menu Item';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'menus.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                   setTimeout(function(){
                     window.location = "menus";
                   },800);
                  
                }else if(data.code == 2){
                    var state = "danger";
                    content.message = data.msg;
                    content.title = 'Add Menu Item';
                    if (style == "withicon") {
                        content.icon = 'la la-bell';
                    } else {
                        content.icon = 'none';
                    }
                    content.url = 'menus.php';
                    content.target = '_blank';

                    $.notify(content,{
                        type: state,
                        placement: {
                            from: placementFrom,
                            align: placementAlign
                        },
                        time: 800,
                    });
                }else{
                  var state = "danger";
                  content.message = "An unknown error occured, try again later!";
                  content.title = 'Add Menu Item';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'menus.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
                }
                document.getElementById("updateMenuForm"+id).reset();//empty the form
                $("#add-admin").modal('toggle');
           });
     
    }else{
        document.getElementById("updateMenuForm"+id).reset();//empty the form
                $("#add-admin").modal('toggle');
                 var state = "danger";
                  content.message = "All fields are required!";
                  content.title = 'Update Menu Item';
                  if (style == "withicon") {
                      content.icon = 'la la-bell';
                  } else {
                      content.icon = 'none';
                  }
                  content.url = 'menus.php';
                  content.target = '_blank';

                  $.notify(content,{
                      type: state,
                      placement: {
                          from: placementFrom,
                          align: placementAlign
                      },
                      time: 800,
                  });
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

}





