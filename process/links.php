<?php
   include("../connection/Functions.php");
	$operation = new Functions();
  //add user
  if(isset($_POST['name']) && isset($_POST['url']) && !empty($_POST['name']) && !empty($_POST['url']) ){
    
    $name = addslashes($_POST['name']);
    $url = addslashes($_POST['url']);

    $table = "links";
    
    
    //check email existance
    if($operation->countAll("SELECT *FROM links WHERE link_name = '$name'") == 0){
      //check id user role is admin or chef    
  
     
           //save admin user
        $data = [
          'link_name'=>"$name",
          'url'=>"$url",
          
        ];
        //print out response
        if($operation->insertData($table,$data)==1){
          echo json_encode(array("code"=>1,"msg"=>"Link saved, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while saving !"));
        }
        
      
    } else{
      echo json_encode(array("code"=>2,"msg"=>"Link already exists try another name!"));
    } 
    

    //suspend user
  }elseif(isset($_POST['delUser']) && !empty($_POST['delUser'])){
    $id = addslashes($_POST['delUser']);
    
    $table = "links";
    
    $where = "links_id = '$id'";
    
    //print out response
    if($operation->deleteData($table,$where)==1){
      echo json_encode(array("code"=>1,"msg"=>"Link deleted, please wait!"));
    }else{
      echo json_encode(array("code"=>2,"msg"=>"An error occured while deleting!"));
    }
    
    //edit user
  }elseif(isset($_POST['e_user_id']) && isset($_POST['efullname']) && isset($_POST['eemail']) && !empty($_POST['e_user_id']) && !empty($_POST['efullname']) && !empty($_POST['eemail']) ){
    
    $link_name = addslashes($_POST['efullname']);
    $url = addslashes($_POST['eemail']);

    $id = addslashes($_POST['e_user_id']);
    
    $table = "links";
    $where = "links_id = '$id'";
    
    //check email existance
    if($operation->countAll("SELECT *FROM links WHERE link_name = '$link_name' AND links_id = '$id'") > 0){
            
          //save user
        $data = [
          'link_name'=>"$link_name",
          'url'=>"$url"
     
        ];
        //print out response
        if($operation->updateData($table,$data,$where)==1){
          echo json_encode(array("code"=>1,"msg"=>"Link saved, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while saving!"));
        }
        
 
    } else{
      echo json_encode(array("code"=>2,"msg"=>"Link does not exist try another name!"));
    } 
    

    //suspend user
  }

?>