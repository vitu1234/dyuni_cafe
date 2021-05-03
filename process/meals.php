<?php
   include("../connection/Functions.php");
	$operation = new Functions();

// print_r($_POST);
  //add post
  if(isset($_POST['title']) && isset($_POST['price']) && isset($_POST['img']) && !empty($_POST['title']) && !empty($_POST['price']) && !empty($_POST['img'])){
    
    $title = addslashes($_POST['title']);
    $price = addslashes($_POST['price']);
    $img = addslashes($_POST['img']);

    $table = "meals";
    
    
    //check email existance
    if($operation->countAll("SELECT *FROM meals WHERE meal_name = '$title'") == 0){
      //upload photo
    $data = $_POST['img'];
    
    $image_array_1 = explode(";", $data);
    $image_array_2 = explode(",", $image_array_1[1]);
    $data = base64_decode($image_array_2[1]);
	

    $photo_id=str_replace("-", "_",date("Y-m-d")."".time());
    $filename = $photo_id.'.png';
    
    /* Location */
    $location = "../images/".$filename;
    // chmod($location, 0755);
    
    //check if directory exist
	if (!file_exists("../images/")) {
	    mkdir("../images/", 0777,true);
	    chmod("../images/", 0777);
	}else{
      // chmod("../images/", 0755);  // octal; correct value of mode
  }
    
    file_put_contents($location, $data);

	$data_="n_image='".$filename."'";
   
           //save admin user
        $data = [
          'meal_name'=>"$title",
          'meal_price'=>"$price",
          'img_url'=>"$filename",
        ];
        //print out response
        if($operation->insertData($table,$data)==1){
            //get the recent id
          echo json_encode(array("code"=>1,"msg"=>"Meal saved, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while saving Meal!"));
        }
        
      
    } else{
      echo json_encode(array("code"=>2,"msg"=>"Meal with same name already exists try another name!"));
    } 
    

   //add attachment
  }elseif(isset($_FILES['attachment']) && isset($_POST['post_attachment'])){
      $id = addslashes($_POST['post_attachment']);
      $where ="meal_id = '$id'";
      //check if id exists
      if($operation->countAll("SELECT *FROM meals WHERE meal_id = '$id'") > 0){
         
          //check if attachment was added earlier
          $checkImg = $operation->retrieveSingle("SELECT *FROM meals WHERE meal_id = '$id'");

        chmod("../images/", 0755);  // octal; correct value of mode
          
         
        $images = $_FILES['attachment']['name'];
        $image=strtolower(pathinfo($images,PATHINFO_EXTENSION));
        $filename=rand(1000, 1000000).".".$image;
        /* Location */
        $location = "../images/".$filename;
        $uploadOk = 1;
        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
        /* Valid Extensions */
        $valid_extensions = array("pdf");
        /* Check file extension */
        if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
           $uploadOk = 0;
        }


        if($_FILES['attachment']['size'] > 30000000 ){
            echo json_encode(array("code"=>2,"msg"=>"✖ File must be less than 30mb!"));
            die();
        }


        if($uploadOk == 0){
             echo json_encode(array("code"=>2,"msg"=>"✖ only pdf is allowed!"));
        }else{
           /* Upload file */
           if(move_uploaded_file($_FILES['attachment']['tmp_name'],$location)){
                   $table = "meals";
                   $data = [
                       'attachment_url' => "$filename"  
                   ];               
                   if($operation->updateData($table,$data,$where) == 1){
                       echo json_encode(array("code"=>1,"msg"=>"Attachment uploaded, please wait!"));
                        if($checkImg['attachment_url'] != ''){
                            $directory1 = "../images/".$checkImg['attachment_url'];
                            if(unlink($directory1)){}
                        }
                   }else{
                       echo json_encode(array("code"=>2,"msg"=>"Attachment upload failed!"));
                   }
          }else{
              echo json_encode(array("code"=>2,"msg"=>"Uploading failed!"));
          }
        }
      }else{
          echo json_encode(array("code"=>2,"msg"=>"Requested Post does not exist!"));
      }
       //delete news article
  }elseif(isset($_POST['delUser']) && !empty($_POST['delUser'])){
    $id = addslashes($_POST['delUser']);
    
        //check for the news article
    if($operation->countAll("SELECT *FROM meals WHERE meal_id = '$id'") > 0){
        //get the news article
        $checkImg = $operation->retrieveSingle("SELECT *FROM meals WHERE meal_id = '$id'");
        //delete the news article from the location
        $table = "meals";
        $where = "meals_id = '$id'";
        
        
        if($checkImg['img_url'] != ''){
            $directory = "../images/".$checkImg['img_url'];
            chmod($directory, 0755);  // octal; correct value of mode

           if(unlink($directory)){
               
               if($checkImg['attachment_url'] != ''){
                    $directory1 = "../images/".$checkImg['attachment_url'];
                    chmod($directory1, 0755);  // octal; correct value of mode
                    if(unlink($directory1)){}
                }
              
               if($operation->deleteData($table,$where) == 1){
    //                       echo $filename;
                   echo json_encode(array("code"=>1,"msg"=>"Meal Deleted, please wait!"));
               }else{
                   echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while deleting!"));
               }
           }else{
                echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while deleting!"));
           }
        }else{
            if($operation->deleteData($table,$where) == 1){
    //                       echo $filename;
               echo json_encode(array("code"=>1,"msg"=>"Meal Deleted, please wait!"));
           }else{
               echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while deleting!"));
           }
        }
     
    }else{
        echo json_encode(array("code"=>2,"msg"=>"✖ Meal not found!"));
    }
      
      
    //edit meal
  }elseif(isset($_POST['e_news_id']) && isset($_POST['etitle']) && isset($_POST['eprice']) && !empty($_POST['e_news_id']) && !empty($_POST['etitle']) && !empty($_POST['eprice']) ){
    
    $title = addslashes($_POST['etitle']);
    $price = addslashes($_POST['eprice']);
    $id = addslashes($_POST['e_news_id']);
    
    $table = "meals";
    $where = "meal_id = '$id'";
        
          //save meal
        $data = [
          'meal_name'=>"$title",
            'meal_price'=>"$price",
        ];
        //print out response
        if($operation->updateData($table,$data,$where)==1){
          echo json_encode(array("code"=>1,"msg"=>"Meal updated, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while updating meal"));
        }
        
 
   

    //change meal picture
  }elseif(isset($_POST['img_update']) && isset($_POST['img_id']) && !empty($_POST['img_update']) && !empty($_POST['img_id'])){
      $img = $_POST['img_update'];
      $id = addslashes($_POST['img_id']);
      
      $where = "meal_id = '$id'";
      $table = "meals";
      
      
              //check for the meal 
    if($operation->countAll("SELECT *FROM meals WHERE meal_id = '$id'") > 0){
        //get the staff
        $checkImg = $operation->retrieveSingle("SELECT *FROM meals WHERE meal_id = '$id'");
        //delete the staff image from the location
        $table = "meals";
        $where = "meals_id = '$id'";

          //upload photo
        $data =$img;

        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);


        $photo_id=str_replace("-", "_",date("Y-m-d")."".time());
        $filename = $photo_id.'.png';

        /* Location */
        $location = "../images/".$filename;

        //check if directory exist
        if (!file_exists("../images/")) {
            mkdir("../images/", 0777,true);
            chmod("../images/", 0777);
        }else{
          chmod("../images/", 0755);  // octal; correct value of mode
        }

        file_put_contents($location, $data);

        $data_="n_image='".$filename."'";

           //save admin user
        $data = [
          'img_url'=>"$filename",
        ];
        
        
        if($checkImg['img_url'] != ''){
            $directory = "../images/".$checkImg['img_url'];
           if(unlink($directory)){
              if($operation->updateData($table,$data,$where)==1){
                  echo json_encode(array("code"=>1,"msg"=>"Meal picture saved, please wait!"));
              }else{
                  echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while changing picture!"));
              }
           }else{
                echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while changing picture!"));
           }
        }else{
            if($operation->updateData($table,$data,$where)==1){
                echo json_encode(array("code"=>1,"msg"=>"Meal picture saved, please wait!"));
            }else{
                echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while changing picture!"));
            }
        }
     
    }else{
        echo json_encode(array("code"=>2,"msg"=>"✖ Selected Meal not found!"));
    }
  }

?>