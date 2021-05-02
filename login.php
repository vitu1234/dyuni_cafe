<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="container-fluid">


  <!-- Content Wrapper. Contains page content -->
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <!-- Main content -->
      
        <div class="container-fluid mt-5">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
             
              <p style="text-align: center;" id="artiststhumbnail" class="ii">
                <img  src="dist/img/AdminLTELogo.png" alt="Logo" class=" img-circle elevation-3" style="opacity: .8">
              </p>
              <!-- jquery validation -->
              <div class="card ">
                <div class="card-header">
                    <h1 class="text-center">LOGIN</h1>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="quickForm" method="post">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email address</label>
                      <input type="email" name="email" id="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" name="password" id="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <div class="form-group mb-0">
                      <div class="custom-control custom-checkbox">
                         <a href="forget_password.php">Forgot Password?</a></label>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button id="loginBtn" type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
              </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

            </div>
            <!--/.col (right) -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      <!-- /.content -->
    </div>
    <div class="col-md-4"></div>
  </div>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      var email = $("#email").val();
      var password = $("#password").val();
       if (email !== '' && password !== '') {

        
          //login
         
         // do other stuff for a valid form
            $.post('process/login.php', $("#quickForm").serialize(), function(dataResult) {
                // $("#confrom").fadeOut('fast', function(){
                  console.log(dataResult)
                  var data = JSON.parse(dataResult)
                if(data.code == 1){
                    swal({
                        title: data.msg,
                        icon: "success",
                      });
                     setTimeout(function(){
                       window.location = "index.php";
                     },1000);
                    document.getElementById("quickForm").reset();//empty the form
                }else if(data.code == 2){
                    swal({
                      title: data.msg,
                      icon: "error",
                    });
                   document.getElementById("quickForm").reset();//empty the form
                }else{
                swal({
                        title: "An error occured,retry!",
                        icon: "error",
                      });
                     
                  }
                document.getElementById("quickForm").reset();//empty the form
                // });
            });


       }else{
          swal({
            title: "Fill all fields!",
            icon: "error",
          });
    
       }

    }
  });
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 5
      }
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
</body>
</html>
