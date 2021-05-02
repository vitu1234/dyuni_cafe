<?php
   include("../connection/Functions.php");
	$operation = new Functions();

//print_r($_POST);
  //add post
  if(isset($_POST['title']) && isset($_POST['content'])  && isset($_POST['period'])  && !empty($_POST['title'])  && !empty($_POST['content']) && !empty($_POST['period'])){
    
    $title = addslashes($_POST['title']);
    $content = $_POST['content'];
    $period = $_POST['period'];

    $table = "projects";
    
           //save admin user
        $data = [
          'project_name'=>"$title",
             'project_summary'=>"$content",
          'project_period'=>"$period",
        ];
        //print out response
        if($operation->insertData($table,$data)==1){
            //get the recent id
            $id = $operation->retrieveSingle("SELECT *FROM projects ORDER BY project_id DESC");
          echo json_encode(array("code"=>1,"msg"=>"New Project saved, please wait!","id"=>$id['project_id']));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while saving project!"));
        }
  
   //add attachment
  }elseif(isset($_FILES['attachment']) && isset($_POST['post_attachment'])){
      $id = addslashes($_POST['post_attachment']);
      $where ="project_id = '$id'";
      //check if id exists
      if($operation->countAll("SELECT *FROM projects WHERE project_id = '$id'") > 0){
         
          //check if attachment was added earlier
          $checkImg = $operation->retrieveSingle("SELECT *FROM projects WHERE project_id = '$id'");

        
          
         
        $images = $_FILES['attachment']['name'];
        $image=strtolower(pathinfo($images,PATHINFO_EXTENSION));
        $filename=rand(1000, 1000000).".".$image;
        /* Location */
        $location = "../../images/projects/".$filename;
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
                   $table = "projects";
                   $data = [
                       'project_file' => "$filename"  
                   ];               
                   if($operation->updateData($table,$data,$where) == 1){
                       echo json_encode(array("code"=>1,"msg"=>"Attachment uploaded, please wait!"));
                        if($checkImg['project_file'] != ''){
                            $directory1 = "../../images/projects/".$checkImg['project_file'];
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
       //delete projects article
  }elseif(isset($_POST['delUser']) && !empty($_POST['delUser'])){
    $id = addslashes($_POST['delUser']);
    
        //check for the projects article
    if($operation->countAll("SELECT *FROM projects WHERE project_id = '$id'") > 0){
        //get the projects article
        $checkImg = $operation->retrieveSingle("SELECT *FROM projects WHERE project_id = '$id'");
        //delete the projects article from the location
        $table = "projects";
        $where = "project_id = '$id'";

               
               if($checkImg['project_file'] != ''){
                    $directory1 = "../../images/projects/".$checkImg['project_file'];
                    if(unlink($directory1)){}
                }
              
               if($operation->deleteData($table,$where) == 1){
    //                       echo $filename;
                   echo json_encode(array("code"=>1,"msg"=>"projects Article Deleted, please wait!"));
               }else{
                   echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while deleting!"));
               }
           
     
    }else{
        echo json_encode(array("code"=>2,"msg"=>"✖ projects article not found!"));
    }
      
      
    //edit staff member
  }elseif(isset($_POST['e_news_id']) && isset($_POST['etitle']) && isset($_POST['econtent']) && isset($_POST['eperiod']) && !empty($_POST['e_news_id']) && !empty($_POST['etitle']) && !empty($_POST['econtent']) && !empty($_POST['eperiod'])){
    
    $title = addslashes($_POST['etitle']);
    $content = addslashes($_POST['econtent']);
    $period = addslashes($_POST['eperiod']);
    $id = addslashes($_POST['e_news_id']);
    
    $table = "projects";
    $where = "project_id = '$id'";
        
          //save projects 
        $data = [
          'project_name'=>"$title",
            'project_summary'=>"$content",
            'project_period'=>"$period",
        ];
        //print out response
        if($operation->updateData($table,$data,$where)==1){
          echo json_encode(array("code"=>1,"msg"=>"projects Article saved, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while projects Article!"));
        }
        
 
   

    //change staff member picture
  }
?>