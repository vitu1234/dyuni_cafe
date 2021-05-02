<?php
   include("../connection/Functions.php");
	$operation = new Functions();

//print_r($_POST);
  //add user
  if(isset($_POST['fullname']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['bio']) && isset($_POST['img']) && isset($_POST['position']) && !empty($_POST['fullname']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['bio']) && !empty($_POST['img']) && !empty($_POST['position']) ){
    
    $fullname = addslashes($_POST['fullname']);
    $phone = addslashes($_POST['phone']);
    $email = addslashes($_POST['email']);
    $bio = addslashes($_POST['bio']);
    $position = addslashes($_POST['position']);
    $img = $_POST['img'];
    
    //encyrpt password

    $table = "staff";
    
    
    //check email existance
    if($operation->countAll("SELECT *FROM staff WHERE staff_email = '$email'") == 0){
      //upload photo
    $data = $_POST['img'];
    
    $image_array_1 = explode(";", $data);
    $image_array_2 = explode(",", $image_array_1[1]);
    $data = base64_decode($image_array_2[1]);
	

    $photo_id=str_replace("-", "_",date("Y-m-d")."".time());
    $filename = $photo_id.'.png';
    
    /* Location */
    $location = "../../images/staff/".$filename;
    
    //check if directory exist
	if (!file_exists("../../images/staff/")) {
	    mkdir("../../images/staff/", 0777,true);
	    chmod("../../images/staff/", 0777);
	}else{
    // chmod($location, 0755);
     chmod("../../images/staff/", 0755);  // octal; correct value of mode
  }
    
    file_put_contents($location, $data);

	$data_="n_image='".$filename."'";
   
           //save admin user
        $data = [
          'staff_name'=>"$fullname",
             'staff_bio'=>"$bio",
            'staff_email'=>"$email",
          'staff_phone'=>"$phone",
          'position'=>"$position",
          'img_url'=>"$filename",
        ];
        //print out response
        if($operation->insertData($table,$data)==1){
          echo json_encode(array("code"=>1,"msg"=>"Staff Member saved, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while saving Staff Member!"));
        }
        
      
    } else{
      if($email == "admin@ipormw.org"){
           //upload photo
    $data = $_POST['img'];
    
    $image_array_1 = explode(";", $data);
    $image_array_2 = explode(",", $image_array_1[1]);
    $data = base64_decode($image_array_2[1]);
	

    $photo_id=str_replace("-", "_",date("Y-m-d")."".time());
    $filename = $photo_id.'.png';
    
    /* Location */
    $location = "../../images/staff/".$filename;
    
    //check if directory exist
	if (!file_exists("../../images/staff/")) {
	    mkdir("../../images/staff/", 0777,true);
	    chmod("../../images/staff/", 0777);
	}else{
     chmod("../../images/staff/", 0755);  // octal; correct value of mode
  }
    
    file_put_contents($location, $data);

	$data_="n_image='".$filename."'";
   
           //save admin user
        $data = [
          'staff_name'=>"$fullname",
             'staff_bio'=>"$bio",
            'staff_email'=>"$email",
          'staff_phone'=>"$phone",
          'position'=>"$position",
          'img_url'=>"$filename",
        ];
        //print out response
        if($operation->insertData($table,$data)==1){
          echo json_encode(array("code"=>1,"msg"=>"Staff Member saved, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while saving Staff Member!"));
        }
      }else{
      echo json_encode(array("code"=>2,"msg"=>"Staff Member already exists try another email!"));
      }
    } 
    

    //delete staff member
  }elseif(isset($_POST['delUser']) && !empty($_POST['delUser'])){
    $id = addslashes($_POST['delUser']);
    
        //check for the member
    if($operation->countAll("SELECT *FROM staff WHERE staff_id = '$id'") > 0){
        //get the staff
        $checkImg = $operation->retrieveSingle("SELECT *FROM staff WHERE staff_id = '$id'");
        //delete the staff from the location
        $table = "staff";
        $where = "staff_id = '$id'";

        if($checkImg['img_url'] != ''){
            $directory = "../../images/staff/".$checkImg['img_url'];
             chmod("../../images/staff/", 0755);
           if(unlink($directory)){
              
               if($operation->deleteData($table,$where) == 1){
    //                       echo $filename;
                   echo json_encode(array("code"=>1,"msg"=>"Staff Member Deleted, please wait!"));
               }else{
                   echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while deleting!"));
               }
           }else{
                echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while deleting!"));
           }
        }else{
            if($operation->deleteData($table,$where) == 1){
    //                       echo $filename;
               echo json_encode(array("code"=>1,"msg"=>"Staff Member Deleted, please wait!"));
           }else{
               echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while deleting!"));
           }
        }
     
    }else{
        echo json_encode(array("code"=>2,"msg"=>"✖ Selected user not found!"));
    }
    //edit staff member
  }elseif(isset($_POST['e_staff_id']) && isset($_POST['efullname']) && isset($_POST['ephone']) && isset($_POST['eemail']) && isset($_POST['ebio']) && isset($_POST['eposition']) && !empty($_POST['e_staff_id']) && !empty($_POST['efullname']) && !empty($_POST['ephone']) && !empty($_POST['eemail']) && !empty($_POST['ebio']) && !empty($_POST['eposition'])){
    
    $fullname = addslashes($_POST['efullname']);
    $phone = addslashes($_POST['ephone']);
    $email = addslashes($_POST['eemail']);
    $bio = addslashes($_POST['ebio']);
    $id = addslashes($_POST['e_staff_id']);
    $position = addslashes($_POST['eposition']);
    
    $table = "staff";
    $where = "staff_id = '$id'";
    

      //getpassword
      $getUser = $operation->retrieveSingle("SELECT *FROM staff WHERE staff_email = '$email' AND staff_id = '$id'");

      

        
          //save user
        $data = [
          'staff_name'=>"$fullname",
            'staff_bio'=>"$bio",
          'staff_email'=>"$email",
          'staff_phone'=>"$phone",
          'position'=>"$position",
          
          
        ];
        //print out response
        if($operation->updateData($table,$data,$where)==1){
          echo json_encode(array("code"=>1,"msg"=>"Staff Member saved, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while saving Staff Member!"));
        }
        
 
   

    //change staff member picture
  }elseif(isset($_POST['img_update']) && isset($_POST['img_id']) && !empty($_POST['img_update']) && !empty($_POST['img_id'])){
      $img = $_POST['img_update'];
      $id = addslashes($_POST['img_id']);
      
      $where = "staff_id = '$id'";
      $table = "staff";
      
      
              //check for the meal 
    if($operation->countAll("SELECT *FROM staff WHERE staff_id = '$id'") > 0){
        //get the staff
        $checkImg = $operation->retrieveSingle("SELECT *FROM staff WHERE staff_id = '$id'");
        //delete the staff image from the location
        $table = "staff";
        $where = "staff_id = '$id'";

          //upload photo
        $data =$img;

        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);


        $photo_id=str_replace("-", "_",date("Y-m-d")."".time());
        $filename = $photo_id.'.png';

        /* Location */
        $location = "../../images/staff/".$filename;

        //check if directory exist
        if (!file_exists("../../images/staff/")) {
            mkdir("../../images/staff/", 0777,true);
            chmod("../../images/staff/", 0777);
        }else{
           chmod("../../images/staff/", 0755);  // octal; correct value of mode
        }

        file_put_contents($location, $data);

        $data_="n_image='".$filename."'";

           //save admin user
        $data = [
          'img_url'=>"$filename",
        ];
        
        
        if($checkImg['img_url'] != ''){
            $directory = "../../images/staff/".$checkImg['img_url'];
             chmod("../../images/staff/", 0755);  // octal; correct value of mode
           if(unlink($directory)){
              if($operation->updateData($table,$data,$where)==1){
                  echo json_encode(array("code"=>1,"msg"=>"Staff Member picture saved, please wait!"));
              }else{
                  echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while changing picture!"));
              }
           }else{
                echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while changing picture!"));
           }
        }else{
            if($operation->updateData($table,$data,$where)==1){
                echo json_encode(array("code"=>1,"msg"=>"Staff Member picture saved, please wait!"));
            }else{
                echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while changing picture!"));
            }
        }
     
    }else{
        echo json_encode(array("code"=>2,"msg"=>"✖ Selected user not found!"));
    }
  }

?>