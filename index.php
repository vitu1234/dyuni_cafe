<?php 
  include("connection/Functions.php");
  $operation = new Functions();
  session_start();

  if (!isset($_SESSION['user'])) {
    # code...
    header("Location:login.php");
  }

  $user_id = addslashes($_SESSION['user']);

  $countUsers = $operation->countAll("SELECT *FROM users");
  $countMeals = $operation->countAll("SELECT *FROM meals");
  $countOrders = $operation->countAll("SELECT *FROM orders");
  $countMenuItems = $operation->countAll("SELECT *FROM menu_items");

  //gets
  $getMeals = $operation->retrieveMany("SELECT *FROM meals ORDER BY meal_id DESC LIMIT 5 ");
  $getUsers = $operation->retrieveMany("SELECT *FROM users LIMIT 5");
  $getUser = $operation->retrieveSingle("SELECT *FROM users WHERE user_id = '$user_id'");
  $getOrders = $operation->retrieveMany("SELECT * FROM `orders` INNER JOIN menu_items ON menu_items.menu_id = orders.menu_id ORDER BY order_id DESC LIMIT 5");
    $user = $operation->retrieveSingle("SELECT *FROM users WHERE user_id = '$user_id'");

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
            <a href="index.php" class="nav-link active">
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
            <a href="meals.php" class="nav-link">
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
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
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
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$countUsers?></h3>

                <p>Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=$countMeals?></h3>

                <p>Meals</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=$countOrders?></h3>

                <p>Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-link"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>Year Sales</h3>

                <p>10</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-6">
            <!-- MAP & BOX PANE -->
    

            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Orders</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                          <tr>
                            <th>Customer Name</th>
                            <th>
                              Meal Name
                            </th>
                            <th>Amount</th>
                            <th>Qty</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                                                  
                                                  <?php
                                                    foreach($getOrders as $row){
                                                      //get mealname
                                                      $order_id = $row['order_id'];
                                                      $meal_id = $row['meal_id'];
                                                      $customer_id = $row['user_id'];

                                                      $getMeal = $operation->retrieveSingle("SELECT *FROM meals WHERE meal_id = '$meal_id'");
                                                      $getCustomer = $operation->retrieveSingle("SELECT *FROM users WHERE user_id = '$customer_id'");  

                                                      $img ='';
                                 if($getMeal['img_url'] != ''){
                                                      $img = '<img height=80px" src="../images/news/'.$getMeal['img_url'].'"/>';
                                                  }else{
                                                      $img = '<img height="50px" src="assets/img/users/no_profile.jpeg"/>';
                                                  }
                            
                             $btn_del = '';
                                                  $btn_sus = '';
                                                  
                                                  
                                                    $btn_del = '<div class="col-12 col-sm-6">
                                                                  <button data-dismiss="modal" onclick="getDeleteNews(\''.$order_id.'\')"  id="btn_e_del'.$order_id.'" class="btn btn-danger btn-block mt-2" type="button">Delete </button>
                                                          </div>';
                                         
                                        
                                                      echo '
                                                        <tr >
                                                              <td>
                                                                  '.$getUser['fullname'].'
                                                              </td>
                                                              <td>
                                                                  '.$getMeal['meal_name'].'
                                                              </td>
                                                              <td>
                                                          <div class="form-button-action">
                                                              <a href="#view-user'.$order_id.'" data-toggle="modal"  role="button" id="addAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" data-toggle="tooltip" title="View" class="btn btn-link btn-simple-primary">
                                                                  <i class="fas fa-eye"></i>
                                                              </a>
                                                          </div>
                                                          
                                                           
                                                            <div class="form-button-action">
                                  <a onclick="setUpdateAttachment(\''.$order_id.'\')" href="#view-attachment" data-toggle="modal"  role="button" id="addAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" data-toggle="tooltip" title="Add/Change Attachment" class="btn btn-link btn-simple-primary">
                                                                  <i class="fas fa-picture"></i>
                                                              </a>
                                </div>

                                                      </td>
                                                  </tr>
                                           
                                               <div id="view-user'.$order_id.'" class="modal fade " role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title font-weight-400">VIEW NEWS ARTICLE</h5>
                                                      <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                    </div>

                                                    <div class="modal-body p-4">


                                                      <div class="row">
                                                          <div class="col-12">

                                                              '.$img.'

                                                              
                                                          </div>
                                                      </div>
                                                    <div id="adminResponse" style="width:100%;"></div>

                                                      <form id="editNewsForm'.$order_id.'" method="post">
                                                        <div class="row">
                                                          <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                              <label for="firstName">Meal Name</label>
                                                              <input type="text" class="form-control" data-bv-field="firstName" id="etitle'.$order_id.'" name="etitle" required placeholder="Meal Name" value="'.$getMeal['meal_name'].'" />
                                                            </div>
                                                            
                                                          </div>
                                                         
                                                         <div class="col-12 col-md-6">
                                                            <label for="firstName">Customer Name</label>
                                                              <input type="text" class="form-control" data-bv-field="firstName" id="etitle'.$order_id.'" name="etitle" required placeholder="Meal Name" value="'.$getCustomer['fullname'].'" />
                                                            </div>
                                                         </div>
                                                         
                                                         <input type="hidden" id="e_news_id'.$order_id.'" name="e_news_id" value="'.$order_idd.'"/>
                                                         
                                                  
                                                         <div class="row">
                                                          <div class="col-12 col-sm-6">
                                                                  <button onclick="editNews(\''.$order_id.'\')"  id="editUserBtn'.$order_id.'" class="btn btn-warning btn-block mt-2 " type="submit">Update </button>
                                                          </div>
                                                            
                                                          '.$btn_del.'
                                                        </div>
                                                        
                                                      </form>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              </div>
                                                <div id="view-meal'.$order_id.'" class="modal fade " role="dialog" aria-hidden="true">
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
                                       
                                                 <div  id="pictureForm'.$order_id.'">
                                                 
                                                      <form id="editPictureForm'.$order_id.'" method="post">
                                                       <div class="col-12 ">

                                                            <div class="form-group">
                                                                    <label for="firstName">Picture</label>
                                                                    <input type="file" class="form-control" data-bv-field="firstName" id="meal_pic'.$order_id.'" accept="image/*" name="meal_pic" required placeholder="Picture" />
                                                                  </div>
                                                              </div>
                                                         <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="uploadimageContainer'.$order_id.'" style="display: none;">
                                                                <div class="row">
                                                                    <div class="col-md-12 text-center">
                                                                      <div id="image_demo'.$order_id.'" style="width:100%; margin-top:30px"></div>
                                                                    </div>

                                                                </div>
                                                              </div>  
                                                      <div class="row">  
                                                        <div class="col-12 col-sm-6">

                                                                <div class="form-group">
                                                                     <button style="display: none;"  id="btn_add'.$order_id.'" class="btn btn-warning  crop_image btn-block mt-2" type="button">Change picture</button>
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
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
            
                <a href="orders.php" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <div class="col-md-6">
            <!-- Info Boxes Style 2 -->
       
                  <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Users</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table  table-striped table-hover">
                      <thead>
                        <tr>
                          <th scope="col"></th>
                          <th scope="col">Fullname</th>
                          <th scope="col">Role</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                                              
                                              <?php
                                                foreach($getUsers as $row){
                                                  $img = '';
                                                  //check if img url is empty or not
                                                  if($row['img_url'] == '' || $row['img_url'] == 'NULL'){
                                                    $img = "assets/img/users/no_profile.jpeg";
                                                  }else{
                                                    $img = "assets/img/users/".$row['img_url'];
                                                  }
                                                  
                                                    echo '
                                                        <tr>
                                                            <td><img height="100px" src="'.$img.'"/></td>
                                                            <td>'.$row['fullname'].'</td>
                                                            <td>'.$row['user_role'].'</td>
                                                            <td class="td-actions">
                                                                <div class="form-button-action">
                                                                  <button type="button" data-toggle="tooltip" title="View" class="btn btn-link btn-simple-primary">
                                                                      <i class="fas fa-eye"></i>
                                                                  </button>
                                                              </div>
                                                            </td>
                                                        </tr>
                                                    ';
                                                }
                                              ?>
                      </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
            
                <a href="users.php" class="btn btn-sm btn-secondary float-right">View All Users</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
 
            </div>
            <!-- /.card -->

          </div>

          <div class="row">
              <div class="col-md-12">
                <!-- BAR CHART -->
                <div class="card card-success">
                  <div class="card-header">
                    <h3 class="card-title">Bar Chart - Orders</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="chart">
                      <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
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

  
  
    <div id="add-admin" class="modal fade " role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-400">NEW MEAL</h5>
            <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body p-4">
            
            <form id="addNewsForm" method="post">
              <div class="row">
                <div class="col-12 ">
                  <div class="form-group">
                    <label for="firstName">Title</label>
                    <input type="text" class="form-control" data-bv-field="firstName" id="title" name="title" maxlength="150" required placeholder="Title" />
                  </div>

                </div>

              <div class="col-12">
                
                  <div class="form-group">
                    <label for="firstName">Body</label>
                    <textarea class="form-control"  data-bv-field="firstName" id="content" name="content" required placeholder="Body" ></textarea>
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
              <button style="display:none;"  id="btn_add" class="btn btn-warning crop_image btn-block  mt-2" type="button">Next </button>
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
            <h5 class="modal-title font-weight-400">MEAL PICTURE</h5>
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
            <h5 class="modal-title font-weight-400" id="title">DELETE MEAL</h5>
            <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body p-4">
            
            <form id="deleteNewsForm" method="post">
              <input type="hidden" id="delUser" name="delUser"/>
              <p id="msg">Are you sure you want to delete this meal?</p>
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
  
  
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
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
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="js/js.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dist/js/pages/dashboard.js"></script> -->
<script type="text/javascript">
  
function setUpdateAttachment(id){
       $("#post_attachment1").val(id);
   }

 $(function () {
    // Summernote
    $('textarea').summernote()

    //-------------
    //- BAR CHART -
    //-------------

     var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : '2020',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : '2021',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }


    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

  
  })
</script>
</body>
</html>
