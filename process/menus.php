<?php
   include("../connection/Functions.php");
	$operation = new Functions();
  // echo "<pre>";print_r($_POST);echo "</pre>";
  //add menu item
  if(isset($_POST['meal_id_add']) && isset($_POST['meal_id_type']) && isset($_POST['menu_expiry']) && !empty($_POST['meal_id_add']) && !empty($_POST['meal_id_type']) && !empty($_POST['menu_expiry']) ){
    
    $meal_id_add = addslashes($_POST['meal_id_add']);
    $meal_type_add = addslashes($_POST['meal_id_type']);
    $menu_expiry = addslashes($_POST['menu_expiry']);
      
    $table = "menu_items";
           //save admin user
        $data = [
          'meal_id'=>"$meal_id_add",
          'meal_type'=>"$meal_type_add",
          'menu_expiry_date'=>"$menu_expiry",
        ];
        //print out response
        if($operation->insertData($table,$data)==1){
          echo json_encode(array("code"=>1,"msg"=>"Menu item saved, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while saving menu item!"));
        }

    //edit menu item
  }elseif(isset($_POST['meal_id_edit']) && isset($_POST['meal_type_edit']) && isset($_POST['menu_expiry_edit']) && isset($_POST['menu_id_edit']) && !empty($_POST['meal_id_edit']) && !empty($_POST['meal_type_edit']) && !empty($_POST['menu_expiry_edit']) && !empty($_POST['menu_id_edit'])){
    
    $meal_id_add = addslashes($_POST['meal_id_edit']);
    $meal_type_add = addslashes($_POST['meal_type_edit']);
    $menu_expiry = addslashes($_POST['menu_expiry_edit']);
    $menu_id = addslashes($_POST['menu_id_edit']);
      
    $table = "menu_items";
           //save admin user
        $data = [
          'meal_id'=>"$meal_id_add",
          'meal_type'=>"$meal_type_add",
          'menu_expiry_date'=>"$menu_expiry",
        ];
        $where = "menu_id = '$menu_id'";
        //print out response
        if($operation->updateData($table,$data,$where)==1){
          echo json_encode(array("code"=>1,"msg"=>"Menu item updated, please wait!"));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured while updating menu item!"));
        }

    //delete menu item
  }elseif(isset($_POST['delUser']) && !empty($_POST['delUser'])){
    $id = addslashes($_POST['delUser']);
    
    $table = "menu_items";
    
    $where = "menu_id = '$id'";
    
    //print out response
    if($operation->deleteData($table,$where)==1){
      echo json_encode(array("code"=>1,"msg"=>"Menu item deleted, please wait!"));
    }else{
      echo json_encode(array("code"=>2,"msg"=>"An error occured while deleting menu item!"));
    }
    
    //edit user
  }