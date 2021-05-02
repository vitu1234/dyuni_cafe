<?php
   include("../connection/Functions.php");
	$operation = new Functions();

//print_r($_POST);
  //add user
  if(isset($_POST['img']) && !empty($_POST['img']) ){
    $img = $_POST['img'];
    
    //encyrpt password

    $table = "photo_gallery";

      //upload photo
    $data = $_POST['img'];
    
    $image_array_1 = explode(";", $data);
    $image_array_2 = explode(",", $image_array_1[1]);
    $data = base64_decode($image_array_2[1]);
	

    $photo_id=str_replace("-", "_",date("Y-m-d")."".time());
    $filename = $photo_id.'.png';
    
    /* Location */
    $location = "../../images/images/".$filename;
    
    //check if directory exist
	if (!file_exists("../../images/images/")) {
	    mkdir("../../images/images/", 0777,true);
	    chmod("../../images/images/", 0777);
	}else{
    chmod("../../images/images/", 0755);  // octal; correct value of mode
  }
    
    file_put_contents($location, $data);

	$data_="n_image='".$filename."'";
   
           //save admin user
        $data = [
          'img_url'=>"$filename",
        ];
        //print out response
        if($operation->insertData($table,$data)==1){
          echo json_encode(array("code"=>1,"msg"=>"Photo saved, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while saving Photo!"));
        }
 

    //delete staff member
  }elseif(isset($_POST['delUser']) && !empty($_POST['delUser'])){
    $id = addslashes($_POST['delUser']);
    
        //check for the member
    if($operation->countAll("SELECT *FROM photo_gallery WHERE photo_id = '$id'") > 0){
        //get the staff
        $checkImg = $operation->retrieveSingle("SELECT *FROM photo_gallery WHERE photo_id = '$id'");
        //delete the staff from the location
        $table = "photo_gallery";
        $where = "photo_id = '$id'";

            $directory = "../../images/images/".$checkImg['img_url'];
            chmod("../../images/images/", 0755);  // octal; correct value of mode
           if(unlink($directory)){
              
               if($operation->deleteData($table,$where) == 1){
    //                       echo $filename;
                   echo json_encode(array("code"=>1,"msg"=>"Photo Deleted, please wait!"));
               }else{
                   echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while deleting!"));
               }
           }else{
                echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while deleting!"));
           }
   
     
    }else{
        echo json_encode(array("code"=>2,"msg"=>"✖ Selected photo not found!"));
    }
    //edit staff member
  }elseif(isset($_POST['img_update']) && isset($_POST['img_id']) && !empty($_POST['img_update']) && !empty($_POST['img_id']) ){
      $img = $_POST['img_update'];
      $id = addslashes($_POST['img_id']);
      
      $where = "photo_id = '$id'";
      $table = "photo_gallery";
      
      
              //check for the meal 
    if($operation->countAll("SELECT *FROM photo_gallery WHERE photo_id = '$id'") > 0){
        //get the staff
        $checkImg = $operation->retrieveSingle("SELECT *FROM photo_gallery WHERE photo_id = '$id'");
        //delete the staff image from the location
        $table = "photo_gallery";
        $where = "photo_id = '$id'";

          //upload photo
        $data =$img;

        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);


        $photo_id=str_replace("-", "_",date("Y-m-d")."".time());
        $filename = $photo_id.'.png';

        /* Location */
        $location = "../../images/images/".$filename;

        //check if directory exist
        if (!file_exists("../../images/images/")) {
            mkdir("../../images/images/", 0777,true);
            chmod("../../images/images/", 0777);
        }else{
          chmod("../../images/images/", 0755);  // octal; correct value of mode
        }

        file_put_contents($location, $data);

        $data_="n_image='".$filename."'";

           //save admin user
        $data = [
          'img_url'=>"$filename",
        ];
        
        
        if($checkImg['img_url'] != ''){
            $directory = "../../images/images/".$checkImg['img_url'];
            chmod("../../images/images/", 0755);  // octal; correct value of mode
           if(unlink($directory)){
              if($operation->updateData($table,$data,$where)==1){
                  echo json_encode(array("code"=>1,"msg"=>" picture saved, please wait!"));
              }else{
                  echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while changing picture!"));
              }
           }else{
                echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while changing picture!"));
           }
        }else{
            if($operation->updateData($table,$data,$where)==1){
                echo json_encode(array("code"=>1,"msg"=>" picture saved, please wait!"));
            }else{
                echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while changing picture!"));
            }
        }
     
    }else{
        echo json_encode(array("code"=>2,"msg"=>"✖ Selected user not found!"));
    }
  }

?>