<?php
   include("../connection/Functions.php");
	$operation = new Functions();
  // echo "<pre>";print_r($_POST);echo "</pre>";
  //add user
  if(isset($_POST['fullname']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['newPassword']) && isset($_POST['role']) && isset($_POST['acc_bal']) && !empty($_POST['fullname']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['newPassword']) ){
    
    $fullname = addslashes($_POST['fullname']);
    $phone = addslashes($_POST['phone']);
    $email = addslashes($_POST['email']);
    $pass = addslashes($_POST['newPassword']);
    $role = addslashes($_POST['role']);
    $acc_bal = addslashes($_POST['acc_bal']);

    $urole = "";
    if ($role == 1) {
      # code...
      $urole = "admin";
    }elseif($role == 2){
      $urole = "student";
    }else{
      $urole= "staff_visitor";
    }
    
    //encyrpt password
    $password=password_hash($pass, PASSWORD_DEFAULT);
    
    $table = "users";
    
    
    //check email existance
    if($operation->countAll("SELECT *FROM users WHERE email = '$email'") == 0){
      //check id user role is admin or chef    
  
     
           //save admin user
        $data = [
          'fullname'=>"$fullname",
          'phone'=>"$phone",
          'email'=>"$email",
          'password'=>"$password",
          'user_role'=>"$urole",
          'account_balance'=>"$acc_bal",
        ];
        //print out response
        if($operation->insertData($table,$data)==1){
          if ($urole != 1) {
            # code...
              $tbl = "transactions";
            //get user id
            $getUser = $operation->retrieveSingle("SELECT *FROM users WHERE email = '$email'");
            $user_id = $getUser['user_id'];
            $dt = [
              'user_id'=>"$user_id",
              'amount'=>"$acc_bal",
              'trans_type'=>'1'
            ];
            $operation->insertData($tbl,$dt);
          }
        
          echo json_encode(array("code"=>1,"msg"=>"User saved, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while saving user!"));
        }
        
      
    } else{
      echo json_encode(array("code"=>2,"msg"=>"User already exists try another email!"));
    } 
    

    //suspend user
  }elseif(isset($_POST['susUser']) && isset($_POST['susStatus']) && !empty($_POST['susUser']) && !empty($_POST['susStatus']) ){
    $id = addslashes($_POST['susUser']);
    $status = addslashes($_POST['susStatus']);
  
    
    
    $table = "users";
    $data = [
      'account_status'=>"$status"
    ];
    $where = "user_id = '$id'";
    
    //print out response
    if($operation->updateData($table,$data,$where)==1){
      echo json_encode(array("code"=>1,"msg"=>"User suspended, please wait!"));
    }else{
      echo json_encode(array("code"=>2,"msg"=>"An error occured while suspending user!"));
    }
    
    //delete user
  }elseif(isset($_POST['delUser']) && !empty($_POST['delUser'])){
    $id = addslashes($_POST['delUser']);
    
    $table = "users";
    
    $where = "user_id = '$id'";
    
    //print out response
    if($operation->deleteData($table,$where)==1){
      echo json_encode(array("code"=>1,"msg"=>"User deleted, please wait!"));
    }else{
      echo json_encode(array("code"=>2,"msg"=>"An error occured while deleting user!"));
    }
    
    //edit user
  }elseif(isset($_POST['e_user_id']) && isset($_POST['efullname']) && isset($_POST['ephone']) && isset($_POST['eemail']) && isset($_POST['epassword']) && !empty($_POST['e_user_id']) && !empty($_POST['efullname']) && !empty($_POST['ephone']) && !empty($_POST['eemail']) && !empty($_POST['epassword']) ){
    
    $fullname = addslashes($_POST['efullname']);
    $phone = addslashes($_POST['ephone']);
    $email = addslashes($_POST['eemail']);
    $pass = addslashes($_POST['epassword']);
    $id = addslashes($_POST['e_user_id']);
    $acc_bal1 = addslashes($_POST['eacc_bal']);
     $role = addslashes($_POST['erole']);
  

    $acc_bal = '';  
    if ($acc_bal1 == "" || is_null($acc_bal)) {
      # code...
      $acc_bal = 0;
    }else{
      $acc_bal = $acc_bal1;
    }
    
      $urole = "";
    if ($role == 1) {
      # code...
      $urole = "admin";
    }elseif($role == 2){
      $urole = "student";
    }else{
      $urole= "staff_visitor";
    }
    
    $table = "users";
    $password = '';
    $where = "user_id = '$id'";
    
    //check email existance
    if($operation->countAll("SELECT *FROM users WHERE email = '$email' AND user_id = '$id'") > 0){
      
      //getpassword
      $getUser = $operation->retrieveSingle("SELECT *FROM users WHERE email = '$email' AND user_id = '$id'");
      if($pass == "password"){
        $pasword = $getUser['password'];
      }else{
          //encyrpt password
          $password=password_hash($pass, PASSWORD_DEFAULT);
      }
      
      

        
          //save user
        $data = [
          'fullname'=>"$fullname",
          'phone'=>"$phone",
          'email'=>"$email",
          'password'=>"$password",
          'user_role'=>"$urole",
          'account_balance'=>"$acc_bal"
        ];
        //print out response
        if($operation->updateData($table,$data,$where)==1){
          echo json_encode(array("code"=>1,"msg"=>"User saved, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while saving user!"));
        }
        
 
    } else{
      echo json_encode(array("code"=>2,"msg"=>"User does not exist try another email!"));
    } 
    

    //suspend user
  }

?>