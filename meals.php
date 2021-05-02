<?php
    session_start();
    include("connection/Functions.php");
  $operation = new Functions();
    if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
        header("location:login.php");
        die();
    }
$user_id = addslashes($_SESSION['user']);
    $user = $operation->retrieveSingle("SELECT *FROM users WHERE user_id = '$user_id'");
  $countUsers = $operation->countAll("SELECT *FROM users");
  $countMeals = $operation->countAll("SELECT *FROM meals");
  $countOrders = $operation->countAll("SELECT *FROM orders");
  $countMenuItems = $operation->countAll("SELECT *FROM menu_items");

  //gets
  $getMeals = $operation->retrieveMany("SELECT *FROM meals ");
  $getUsers = $operation->retrieveMany("SELECT *FROM users LIMIT 5");
  $getUser = $operation->retrieveSingle("SELECT *FROM users WHERE user_id = '$user_id'");
  $getOrders = $operation->retrieveMany("SELECT * FROM `orders` INNER JOIN menu_items ON menu_items.menu_id = orders.menu_id ORDER BY order_id DESC LIMIT 5");
    $user = $operation->retrieveSingle("SELECT *FROM users WHERE user_id = '$user_id'");
$getUser = $operation->retrieveSingle("SELECT *FROM users WHERE user_id = '$user_id'");

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DYUNI CAFE | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <link rel="stylesheet" href="assets/croppie/croppie.css">
  <link rel="stylesheet" href="assets/datatable/datatables.min.css">
  <link rel="stylesheet" href="assets/simditor/styles/simditor.css">
    <style>
  .para {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
  
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CAFE Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/img/users/no_profile.jpeg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=$getUser['fullname']?></a>
          <a data-toggle='modal' data-target='#modalUser<?=$user_id?>' href="#" class="d-block">View Profile</a>

          <a class="d-block" href="logout.php"><i class="fa fa-power-off"></i> Logout</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
            <a href="index.php" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
           
          </li>

         
          <li class="nav-item">
            <a href="users.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
           
          </li>

          <li class="nav-item">
            <a href="meals.php" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Meals
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
      
          </li>

          <li class="nav-item">
            <a href="orders.php" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Orders
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          </li>

          


          
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Meals</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Meals</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
       
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title"></div>
                    <a  class="btn btn-warning float-right text-light " href="menus.php" aria-haspopup="true" aria-expanded="false"><i class="fas fa-book text-3 mr-1"></i>Menus</a>

                     <a  class="btn btn-warning float-right text-light mx-4" href="#add-admin" data-toggle="modal"  role="button" id="addAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus text-3 mr-1"></i>Add Meal</a>

                  </div>
                  <div class="card-body">
                    <table class="table table-hover" id="user_tbl">
                      <thead>
                        <tr>
                          <th scope="col"></th>
                          <th scope="col">Meal Name</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                                              
                                              <?php
                                                foreach($getMeals as $row){
                                                  $img = '';
                                                 
                                                  //sort out user role
                                                 
                                                  $btn_del = '';
                                                  $btn_sus = '';
                                                  
                                                  
                                                    $btn_del = '<div class="col-12 col-sm-6">
                                                                  <button data-dismiss="modal" onclick="getDeleteNews(\''.$row['meal_id'].'\')"  id="btn_e_del'.$row['meal_id'].'" class="btn btn-danger btn-block mt-2" type="button">Delete </button>
                                                          </div>';
                                         
                                                      
                                                
                                                  
                                                  
                                                  if($row['img_url'] != ''){
                                                      $img = '<img height=80px" src="../images/news/'.$row['img_url'].'"/>';
                                                  }else{
                                                      $img = '<img height="50px" src="assets/img/users/no_profile.jpeg"/>';
                                                  }
                                                   
                                                    
                                                  echo '
                                                    <tr>
                                                      <td>'.$img.'</td>
                                                      <td>'.$row['meal_name'].'</td>
                                                      <td>
                                                          <div class="form-button-action">
                                                              <a href="#view-user'.$row['meal_id'].'" data-toggle="modal"  role="button" id="addAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" data-toggle="tooltip" title="View" class="btn btn-link btn-simple-primary">
                                                                  <i class="fas fa-eye"></i>
                                                              </a>
                                                          </div>
                                                          
                                                           <div class="form-button-action">
                                  <a onclick="setUpdateMeal(\''.$row['meal_id'].'\')" href="#view-meal'.$row['meal_id'].'" data-toggle="modal"  role="button" id="addAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" data-toggle="tooltip" title="Change Picture" class="btn btn-link btn-simple-primary">
                                                                  <i class="fas fa-photo"></i>
                                                              </a>
                                </div>
                                                            <div class="form-button-action">
                                  <a onclick="setUpdateAttachment(\''.$row['meal_id'].'\')" href="#view-attachment" data-toggle="modal"  role="button" id="addAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" data-toggle="tooltip" title="Add/Change Attachment" class="btn btn-link btn-simple-primary">
                                                                  <i class="fas fa-book"></i>
                                                              </a>
                                </div>

                                                      </td>
                                                  </tr>
                                           
                                               <div id="view-user'.$row['meal_id'].'" class="modal fade " role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title font-weight-400">VIEW MEAL</h5>
                                                      <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                    </div>

                                                    <div class="modal-body p-4">


                                                      <div class="row">
                                                          <div class="col-12">

                                                              '.$img.'
                                                          </div>
                                                      </div>
                                                    <div id="adminResponse" style="width:100%;"></div>

                                                      <form id="editNewsForm'.$row['meal_id'].'" method="post">
                                                        <div class="row">
                                                          <div class="col-12 ">
                                                            <div class="form-group">
                                                              <label for="firstName">Meal Name</label>
                                                              <input type="text" class="form-control" data-bv-field="firstName" id="etitle'.$row['meal_id'].'" name="etitle" required placeholder="Meal Name" value="'.$row['meal_name'].'" />
                                                            </div>
                                                            
                                                          </div>
                                                         
                                                         
                                                         <input type="hidden" id="e_news_id'.$row['meal_id'].'" name="e_news_id" value="'.$row['meal_id'].'"/>
                                                         
                                                  
                                                         
                                                          <div class="col-12 col-sm-6">
                                                                  <button onclick="editNews(\''.$row['meal_id'].'\')"  id="editUserBtn'.$row['meal_id'].'" class="btn btn-warning btn-block mt-2 " type="submit">Update </button>
                                                          </div>
                                                           
                                                          '.$btn_del.'
                                                        </div>
                                                        
                                                      </form>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              </div>
                                                <div id="view-meal'.$row['meal_id'].'" class="modal fade " role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title font-weight-400">CHANGE PICTURE</h5>
                                                      <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                    </div>

                                                    <div class="modal-body p-4">


                                                      <div class="row">
                                                          <div class="col-12">
                                                           '.$img.'
                                                          </div>
                                                      </div>
                                       
                                                 <div  id="pictureForm'.$row['meal_id'].'">
                                                 
                                                      <form id="editPictureForm'.$row['meal_id'].'" method="post">
                                                       <div class="col-12 ">

                                                            <div class="form-group">
                                                                    <label for="firstName">Picture</label>
                                                                    <input type="file" class="form-control" data-bv-field="firstName" id="meal_pic'.$row['meal_id'].'" accept="image/*" name="meal_pic" required placeholder="Picture" />
                                                                  </div>
                                                              </div>
                                                         <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="uploadimageContainer'.$row['meal_id'].'" style="display: none;">
                                                                <div class="row">
                                                                    <div class="col-md-12 text-center">
                                                                      <div id="image_demo'.$row['meal_id'].'" style="width:100%; margin-top:30px"></div>
                                                                    </div>

                                                                </div>
                                                              </div>  
                                                      <div class="row">  
                                                        <div class="col-12 col-sm-6">

                                                                <div class="form-group">
                                                                     <button style="display: none;"  id="btn_add'.$row['meal_id'].'" class="btn btn-warning  crop_image btn-block mt-2" type="button">Change picture</button>
                                                                </div>
                                                            </div>
                                                           <div class="col-12 col-sm-6">

                                                                
                                                            </div>
                                                        </div>
                                                      </form>
                                                    </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                                 
                                                  
                                                  ';
                                                }
                                              ?>
                      </tbody>
                    </table>
                  </div>
                </div>
  
              </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright  &copy; <script>document.write(new Date().getFullYear());</script> Designed by <a href="#" target="_blank">Jack Kamba.</a></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>


  <div id="add-admin" class="modal fade " role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-400">ADD MEAL</h5>
            <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body p-4">
            
            <form id="addNewsForm" method="post">
              <div class="row">
                <div class="col-12 ">
                  <div class="form-group">
                    <label for="firstName">Meal Name</label>
                    <input type="text" class="form-control" data-bv-field="firstName" id="meal_name" name="meal_name" maxlength="150" required placeholder="Meal Name" />
                  </div>

                </div>

              
            <div class="col-12 ">
                
                  <div class="form-group">
                    <label for="firstName">Picture</label>
                    <input type="file" class="form-control" data-bv-field="firstName" id="meal_pic" accept="image/*" name="meal_pic" required placeholder="Picture" />
                  </div>
              </div>
                  
                
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="uploadimageContainer" style="display: none;">
                <div class="row">
                    <div class="col-md-12 text-center">
                      <div id="image_demo" style="width:100%; margin-top:30px"></div>
                    </div>

                </div>
              </div>  
        
               </div>
              <button style="display:none;"  id="btn_add" class="btn btn-warning crop_image btn-block  mt-2" type="button">Add Meal </button>
            </form>
              
              <form id="addAttachmentForm" method="post" style="display:none;">
                  <div class="row">
                    <div class="col-12 ">
                      <div class="form-group">
                        <label for="firstName">Attachment</label>
                        <input type="file" class="form-control" data-bv-field="firstName" id="attachment" accept="application/pdf" name="attachment" required placeholder="Attachment" />
                          <small id="emailHelp" class="form-text text-muted">Optional</small>
                      </div>
                    </div>
                        <input type="hidden" name="post_attachment" id="post_attachment" required/>
                      <div class="col-12 col-sm-6">
                            <div class="form-group">
                                   <button onclick="reloadMe()" data-dismiss="modal" aria-label="Close" id="btn_add" class="btn btn-default btn-block px-5 mt-2" type="button">Finish without attachment </button>
                            </div>
                      </div>
                      <div class="col-12 col-sm-6">
                            <div class="form-group">
                                   <button id="btn_add_attachment" class="btn btn-warning btn-block px-5 mt-2 px-5" type="submit">Finish with attachment </button>
                            </div>
                      </div>
                    </div>
              </form>
              
          </div>
        </div>
      </div>
    </div>
    
  <div id="view-attachment" class="modal fade " role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-400">NEWS ARTICLE ATTACHMENT</h5>
            <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body p-4">
     
              <form id="addAttachmentForm2" method="post" >
                  <div class="row">
                    <div class="col-12 ">
                      <div class="form-group">
                        <label for="firstName">Attachment</label>
                        <input type="file" class="form-control" data-bv-field="firstName" id="attachments" accept="application/pdf" name="attachment" required placeholder="Attachment" />
                          <small id="emailHelp" class="form-text text-muted">Optional</small>
                      </div>
                    </div>
                        <input type="hidden" name="post_attachment" id="post_attachment1" required/>
                   
                      <div class="col-12 col-sm-6">
                            <div class="form-group">
                                   <button id="btn_add_attachment2" class="btn btn-warning btn-block px-5 mt-2 px-5" type="submit">Save </button>
                            </div>
                      </div>
                    </div>
              </form>
              
          </div>
        </div>
      </div>
    </div>
  

  <div id="deleteUserModal" class="modal fade " role="dialog" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-400" id="title">DELETE NEWS ARTICLE</h5>
            <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body p-4">
            
            <form id="deleteNewsForm" method="post">
              <input type="hidden" id="delUser" name="delUser"/>
              <p id="msg">Are you sure you want to delete this news article?</p>
                <div class="row">
                  
                  <div class="col-6 col-sm-3">
                    <div class="form-group">
                     <button type="submit" id="delBtn" class="btn btn-danger" > Yes </button>
                    </div>
                    </div>
                   <div class="col-6 col-sm-3">
                    <div class="form-group">
                        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close"> Cancel </button>
                      </div>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  
  
    
      <!--edit my profile-->
<div class="modal fade" id="modalUser<?=$user_id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title " id="exampleModalLabel">Edit My Profile</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <form action="" method="post" id="editUserForm<?=$user_id?>">
                <input type="hidden" id="eUid" name="eUid" value="<?=$user_id?>" />
              <div class="modal-body">
                <div id="userEditResponse<?=$user_id?>"></div>
                <div class="form-group">
                    <label for="email">Fullname</label>
                    <input type="text" required class="form-control" name="efullname" id="efullname" placeholder="Enter Fullname" value="<?=$user['fullname']?>">
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="eemail" required class="form-control" name="eemail" id="eemail" placeholder="Enter Email" value="<?=$user['email']?>" />
                </div>
                <div class="form-group">
                    <label for="email">Phone Number</label>
                    <input type="tel" required class="form-control" name="ephone" id="ephone" placeholder="Enter Phone Number" value="<?=$user['phone']?>" />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="epassword" name="epassword" placeholder="Password">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="editUserBtn<?=$user['user_id']?>" onclick="editUser('<?=$user['user_id']?>')" class="btn btn-danger">Save changes</button>
              </div>
        </form>
        </div>
      </div>
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
  <script src="assets/datatable/datatables.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<!-- <script src="plugins/sparklines/sparkline.js"></script> -->
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="assets/croppie/croppie.js"></script>
<script src="js/js.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dist/js/pages/dashboard.js"></script> -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
  
function setUpdateAttachment(id){
       $("#post_attachment1").val(id);
   }

 $(function () {
    // Summernote
    $('textarea').summernote()

  
  })
</script>



<script>
    function reloadMe(){
        window.location="meals.php";
    }
function setUpdateAttachment(id){
    $("#post_attachment1").val(id);
}
   function getDeleteNews(id){
    $("#delUser").val(id);
    $("#view-user"+id).modal('toggle');
    $("#deleteUserModal").modal('toggle');
  }
  function setUpdateMeal(id){
    var image_crop = $('#image_demo'+id).croppie({
    enableExif: true,
    viewport: {
      width:500,
      height:300,
      type:'square' //circle
    },
    boundary:{
      width:500,
      height:300
    },
    showZoomer: false,
    enableResize: true,
    enableOrientation: true,
    mouseWheelZoom: 'ctrl'
    });
  
   $('#meal_pic'+id).on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      image_crop.croppie('bind', {
      url: event.target.result
      }).then(function(){
//      console.log('jQuery bind complete');
      });
    }

    reader.readAsDataURL(this.files[0]);
    $('#uploadimageContainer'+id).show();
    $('#btn_add'+id).show();
    });

  $('#btn_add'+id).click(function(event){
    upload_btn_action=$(this).text();
    image_crop.croppie('result', {
      type: 'canvas',
      size: "original", 
      format: "png",
      quality: 1
    }).then(function(response){
      //get meal name and meal price
            $("#btn_add"+id).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Updating...');
        $.ajax({
          url:"process/news.php",
          type: "POST",
          data:{"img_update": response, "img_id":id},

          cache: false,

          success:function(dataResult)
          { 
            console.log(dataResult)
            var data = JSON.parse(dataResult);
            $("#btn_add"+id).html('Change Picture');
              $('#uploadimageContainer'+id).hide();
              $('#btn_add'+id).hide();
            if(data.code==1){
              //Uploaded and finish
                swal({
                      title: data.msg,
                      icon: "success",
                    });
                   setT
            
              $("#view-meal"+id).modal("toggle");
                 document.getElementById("editPictureForm"+id).reset();//empty the form
              
               setTimeout(function(){ 
                window.location = "news.php";
              }, 800);
            }else{
                 swal({
                      title: data.msg,
                      icon: "error",
                    });
                   setT
              $("#view-meal"+id).modal("toggle");
                 document.getElementById("editPictureForm"+id).reset();//empty the form
            }

          }
          });
  
    })
    });

}
    
    
    
   $(document).ready(function(){
  //notification variables

  
    var table = $('#user_tbl').DataTable({
      columnDefs: [
        {bSortable: false, targets: [0]} 
      ] ,
       "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
      dom: 'Bfrtip',
      buttons: [
          'colvis',
          'csv',
          'pdf'
      ]


    });
  
  var image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:500,
      height:300,
      type:'square' //circle
    },
    boundary:{
      width:500,
      height:300
    },
    showZoomer: false,
    enableResize: true,
    enableOrientation: true,
    mouseWheelZoom: 'ctrl'
    });
  
   $('#meal_pic').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      image_crop.croppie('bind', {
      url: event.target.result
      }).then(function(){
//      console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageContainer').show();
    $('#btn_add').show();
    });

  $('#btn_add').click(function(event){
    upload_btn_action=$(this).text();
    image_crop.croppie('result', {
      type: 'canvas',
      size: "original", 
      format: "png",
      quality: 1
    }).then(function(response){
      //get meal name and meal price
      var titlex  = $("#meal_name").val();
            
      if(titlex !== "" ){
        $("#btn_add").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Adding...');
        $.ajax({
          url:"process/meals.php",
          type: "POST",
          data:{"img": response,"title":titlex},

          cache: false,

          success:function(dataResult)
          { 
           console.log(dataResult);
            
            var data = JSON.parse(dataResult);
            $("#btn_add").html('Add Meal');
              $('#uploadimageContainer').hide();
              $('#btn_add').hide();
            if(data.code==1){
//                          alert(data.msg)
               swal({
                      title: data.msg,
                      icon: "success",
                    });
//              $("#add-admin").modal("toggle");
                 document.getElementById("addNewsForm").reset();//empty the form
              
              setTimeout(function(){ 
               window.location = "meals.php";
                               
             }, 500);
            }else{
                 swal({
                      title: data.msg,
                      icon: "error",
                    });
              $("#add-admin").modal("toggle");
                 document.getElementById("addNewsForm").reset();//empty the form
            }

          }
          });
      }else{
         swal({
              title: "Fill all fields",
              icon: "error",
            });
                   
        $("#add-admin").modal("toggle");
        document.getElementById("addNewsForm").reset();//empty the form
        
      }
  
      
    })
        event.preventDefault();
    event.stopImmediatePropagation();
    });

  
});

</script>
</body>
</html>
