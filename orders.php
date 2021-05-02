<?php
    session_start();
    include("connection/Functions.php");
  $operation = new Functions();
    if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
        header("location:login.php");
        die();
    }

    $user_id = $_SESSION['user'];
    $user = $operation->retrieveSingle("SELECT *FROM users WHERE user_id = '$user_id'");

    $countStudents = "";
    $countUsers = $operation->countAll("SELECT *FROM users");
    $countNews = "";
    $countProjects = "";

    $countGallery = "";

  //get users
    $getUsers = $operation->retrieveMany("SELECT *FROM users WHERE user_id <> '$user_id' LIMIT 5");
  
    $getUser = $operation->retrieveSingle("SELECT *FROM users WHERE user_id = '$user_id'");

    $getMeals = $operation->retrieveMany("SELECT *FROM meals ORDER BY meal_name ASC");
    $getOrders = $operation->retrieveMany("SELECT *FROM orders INNER JOIN users ON orders.user_id = users.user_id ORDER BY order_id DESC");
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DYUNI Cafe | Dashboard</title>

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

    <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
            <a href="users.php" class="nav-link ">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
           
          </li>

          <li class="nav-item">
            <a href="meals.php" class="nav-link  ">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Meals
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
      
          </li>

          <li class="nav-item">
            <a href="orders.php" class="nav-link active">
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
            <h1 class="m-0">Orders</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">Orders</li>
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
                    <span class="spinner-border spinner-border-lg float-right text-warning " role="status" aria-hidden="true"></span>
                  </div>
                  <div class="card-body">
                    <table class="table table-hover" id="user_tbl">
                      <thead>
                        <tr>
                          <th scope="col">Meal Name</th>
                          <th scope="col">Meal Type</th>
                          <th scope="col">Expiry Date</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                            
                            <?php
                              foreach($getOrders as $row){                                
                                
                                  $btn_del = '<div class="col-12 col-sm-6">
                                                <button data-dismiss="modal" onclick="getDeleteUser(\''.$row['menu_id'].'\')"  id="btn_e_del'.$row['menu_id'].'" class="btn btn-danger btn-block mt-2" type="button">Delete User</button>
                                        </div>';
                       

                                      $meals_select = '';
                                      foreach ($getMeals as $row1) {
                                        # code...
                                        $sel = '';
                                        if ($row1['meal_id'] == $row['meal_id']) {
                                          # code...
                                          $sel = "selected";
                                        }else{
                                          $sel = "";
                                        }
                                        $meals_select .='<option '.$sel.' value="'.$row1['meal_id'].'">'.$row1['meal_name'].'</option>';
                                      }

                                      $typeSele1 = "";
                                      $typeSele2 = "";
                                      $typeSele3 = "";
                                      $typeSele4 = "";

                                      if ($row['meal_type'] == "Breakfast"){
                                        # code...
                                        $typeSele1 = "selected";
                                      }else if ($row['meal_type'] == "Lunch") {
                                        # code...
                                        $typeSele2 = "selected";
                                      }else if ($row['meal_type'] == "Supper") {
                                        # code...
                                        $typeSele3 = "selected";
                                      }else{
                                        $typeSele4 = "selected";
                                      }
                        
                                echo '
                                  <tr>
                                    <td>'.$row['meal_name'].'</td>
                                    <td>'.$row['meal_type'].'</td>
                                    <td>'.$row['menu_expiry_date'].'</td>
                                    <td>
                                        <div class="form-button-action">
                                            <a href="#view-user'.$row['menu_id'].'" data-toggle="modal"  role="button" id="addAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" data-toggle="tooltip" title="View" class="btn btn-link btn-simple-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>


                                    </td>
                                </tr>
                                
                                
                             <div id="view-user'.$row['menu_id'].'" class="modal fade " role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title font-weight-400">VIEW MENU ITEM</h5>
                                    <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                  </div>

                                  <div class="modal-body p-4">
                                     <form id="editMenuForm'.$row['menu_id'].'" method="post">
                                        <div class="row">
                                          

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">

                                                  
                                                     <label>Meal Name</label>
                                                  <select name="meal_id_edit" id="meal_id_edit'.$row['menu_id'].'" required class="form-control select2" style="width: 100%;">
                                                      '.$meals_select.'
                                                  </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                              <label for="firstName">-Meal Type-</label>
                                              <select id="meal_type_edit'.$row['menu_id'].'" name="meal_type_edit" required class="form-control select2" style="width: 100%;">
                                                    <option '.$typeSele1.' value="Breakfast">Breakfast</option>
                                                    <option '.$typeSele2.' value="Lunch">Lunch</option>
                                                    <option '.$typeSele3.' value="Supper">Supper</option>
                                                    <option '.$typeSele4.' value="Special Meal">Special Meal</option>
                                                   
                                                  </select>
                                            </div>                
                                        </div>
                                        
                                        <input type="hidden" name="menu_id_edit" value="'.$row['menu_id'].'" />
                                        <div class="col-12 col">
                                            <div class="form-group">
                                              <label for="firstName">Menu Expiry Date</label>
                                              <input type="date" class="form-control" data-bv-field="firstName" id="menu_expiry_edit'.$row['menu_id'].'" name="menu_expiry_edit" value="'.$row['menu_expiry_date'].'"" required placeholder="Enter date" min="'.date('Y-m-d').'" />
                                            </div>

                                            

                                        </div> 
                                        
                                         <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                        <button onclick="updateMenus(\''.$row['menu_id'].'\')" id="addUserBtn'.$row['menu_id'].'" class="btn btn-warning btn-block mt-2 text-light" type="submit">Update</button>
                                        </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">

                                        <button onclick="showDeleteModal(\''.$row['menu_id'].'\')" class="btn btn-danger btn-block mt-2 text-light" type="button">Delete</button>
                                         </div>
                                        </div>
                                         </div>
                                      </form>
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
            <h5 class="modal-title font-weight-400">NEW MENU ITEM</h5>
            <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body p-4">
              <div id="adminResponse" style="width:100%;"></div>
            
            <form id="addMenuForm" method="post">
              <div class="row">
                

              <div class="col-12 col-sm-6">
                  <div class="form-group">

                        <label>Meal Name</label>
                        <select required class="form-control select2" id="meal_id_add" name="meal_id_add" style="width: 100%;">
                          <option selected="selected" disabled="disabled">-Selected-</option>
                          <?php
                              foreach ($getMeals as $row ) {
                                # code...
                                echo '<option value="'.$row['meal_id'].'">'.$row['meal_name'].'</option>';
                              }
                          ?>
                        </select>
                           
                  </div>
              </div>
              <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="firstName">-Meal Type-</label>
                    <select id="meal_id_type" name="meal_id_type" required class="form-control select2" style="width: 100%;">
                          <option selected="selected" disabled="disabled">-Selected-</option>
                          <option value="Breakfast">Breakfast</option>
                          <option value="Lunch">Lunch</option>
                          <option value="Supper">Supper</option>
                          <option value="Special Meal">Special Meal</option>
                         
                        </select>
                  </div>                
              </div>
              
    
              <div class="col-12 col">
                  <div class="form-group">
                    <label for="firstName">Menu Expiry Date</label>
                    <input type="date" class="form-control" data-bv-field="firstName" id="menu_expiry" name="menu_expiry" required placeholder="Enter date" min="<?=date('Y-m-d')?>" />
                  </div>

                  

              </div> 
               </div>
              <button id="addUserBtn" class="btn btn-warning btn-block mt-2 text-light" type="submit">Add Menu Item</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  
  <div id="deleteUserModal" class="modal fade " role="dialog" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-400" id="title">DELETE MENU ITEM</h5>
            <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body p-4">
            
            <form id="deleteMenuForm" method="post">
              <input type="hidden" id="delUser" name="delUser"/>
              <p id="msg">Are you sure you want to delete this menu item?</p>
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
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
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

  
   function showDeleteModal(id){
    $("#delUser").val(id);
    $("#view-user"+id).modal('toggle');
    $("#deleteUserModal").modal('toggle');
  }
  
   $(document).ready(function(){

    // var today = new Date().toISOString().split('T')[0];
    // document.getElementsByName("menu_expiry")[0].setAttribute('min', today);


       //Initialize Select2 Elements
    $('.select2').select2()

    var table = $('#user_tbl').DataTable({
      columnDefs: [
        {bSortable: false, targets: [2]} 
      ] ,
       "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
      dom: 'Bfrtip',
      buttons: [
          'colvis',
          'csv',
          'pdf'
      ]


    });
});
</script>

</body>
</html>
