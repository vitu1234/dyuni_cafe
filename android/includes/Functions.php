<?php

Class Functions{
    
    private $con;
    public $records;
    public $numlinks;
    public $item_per_page =10;
    
    function __construct(){
        
        require_once dirname(__FILE__).'/connection.php';
        
        
        $database = new Connection();
        
        $this->con = $database->openConnection();
    }
    
    //INSERTING DATA TO DATABASE
    public function InsertInfo(){
		$args="";
//		$query="";
        $table ="";
		if(func_get_args()){
			$args=func_get_args();
		}
		
		//overloading
		if (func_num_args()==2) { //($table,$data,$db)     SELECT data FROM TABLE
	        $table=$args[0];
	        $value1=$args[1];
	        

	        $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1)");
            $stmt->bindParam(':value1',$value1);
            
            
	    }elseif(func_num_args()==3){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            
	    }elseif(func_num_args()==4){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            
	    }elseif(func_num_args()==5){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            
	    }elseif(func_num_args()==6){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            
	    }elseif(func_num_args()==7){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
	        $value6=$args[6];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5,:value6)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            $stmt->bindParam(':value6',$value6);
            
	    }elseif(func_num_args()==8){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
	        $value6=$args[6];
	        $value7=$args[7];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5,:value6,:value7)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            $stmt->bindParam(':value6',$value6);
            $stmt->bindParam(':value7',$value7);
            
	    }elseif(func_num_args()==9){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
	        $value6=$args[6];
	        $value7=$args[7];
	        $value8=$args[8];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5,:value6,:value7,:value8)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            $stmt->bindParam(':value6',$value6);
            $stmt->bindParam(':value7',$value7);
            $stmt->bindParam(':value8',$value8);
            
	    }elseif(func_num_args()==10){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
	        $value6=$args[6];
	        $value7=$args[7];
	        $value8=$args[8];
	        $value9=$args[9];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5,:value6,:value7,:value8,:value9)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            $stmt->bindParam(':value6',$value6);
            $stmt->bindParam(':value7',$value7);
            $stmt->bindParam(':value8',$value8);
            $stmt->bindParam(':value9',$value9);
            
	    }elseif(func_num_args()==11){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
	        $value6=$args[6];
	        $value7=$args[7];
	        $value8=$args[8];
	        $value9=$args[9];
	        $value10=$args[10];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5,:value6,:value7,:value8,:value9,:value10)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            $stmt->bindParam(':value6',$value6);
            $stmt->bindParam(':value7',$value7);
            $stmt->bindParam(':value8',$value8);
            $stmt->bindParam(':value9',$value9);
            $stmt->bindParam(':value10',$value10);
            
	    }elseif(func_num_args()==12){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
	        $value6=$args[6];
	        $value7=$args[7];
	        $value8=$args[8];
	        $value9=$args[9];
	        $value10=$args[10];
	        $value11=$args[11];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5,:value6,:value7,:value8,:value9,:value10,:value11)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            $stmt->bindParam(':value6',$value6);
            $stmt->bindParam(':value7',$value7);
            $stmt->bindParam(':value8',$value8);
            $stmt->bindParam(':value9',$value9);
            $stmt->bindParam(':value10',$value10);
            $stmt->bindParam(':value11',$value11);
            
	    }elseif(func_num_args()==13){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
	        $value6=$args[6];
	        $value7=$args[7];
	        $value8=$args[8];
	        $value9=$args[9];
	        $value10=$args[10];
	        $value11=$args[11];
	        $value12=$args[12];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5,:value6,:value7,:value8,:value9,:value10,:value11,:value12)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            $stmt->bindParam(':value6',$value6);
            $stmt->bindParam(':value7',$value7);
            $stmt->bindParam(':value8',$value8);
            $stmt->bindParam(':value9',$value9);
            $stmt->bindParam(':value10',$value10);
            $stmt->bindParam(':value11',$value11);
            $stmt->bindParam(':value12',$value12);
            
	    }elseif(func_num_args()==14){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
	        $value6=$args[6];
	        $value7=$args[7];
	        $value8=$args[8];
	        $value9=$args[9];
	        $value10=$args[10];
	        $value11=$args[11];
	        $value12=$args[12];
	        $value13=$args[13];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5,:value6,:value7,:value8,:value9,:value10,:value11,:value12,:value13)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            $stmt->bindParam(':value6',$value6);
            $stmt->bindParam(':value7',$value7);
            $stmt->bindParam(':value8',$value8);
            $stmt->bindParam(':value9',$value9);
            $stmt->bindParam(':value10',$value10);
            $stmt->bindParam(':value11',$value11);
            $stmt->bindParam(':value12',$value12);
            $stmt->bindParam(':value13',$value13);
            
	    }elseif(func_num_args()==15){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
	        $value6=$args[6];
	        $value7=$args[7];
	        $value8=$args[8];
	        $value9=$args[9];
	        $value10=$args[10];
	        $value11=$args[11];
	        $value12=$args[12];
	        $value13=$args[13];
	        $value14=$args[14];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5,:value6,:value7,:value8,:value9,:value10,:value11,:value12,:value13,:value14)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            $stmt->bindParam(':value6',$value6);
            $stmt->bindParam(':value7',$value7);
            $stmt->bindParam(':value8',$value8);
            $stmt->bindParam(':value9',$value9);
            $stmt->bindParam(':value10',$value10);
            $stmt->bindParam(':value11',$value11);
            $stmt->bindParam(':value12',$value12);
            $stmt->bindParam(':value13',$value13);
            $stmt->bindParam(':value14',$value14);
            
	    }elseif(func_num_args()==16){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
	        $value6=$args[6];
	        $value7=$args[7];
	        $value8=$args[8];
	        $value9=$args[9];
	        $value10=$args[10];
	        $value11=$args[11];
	        $value12=$args[12];
	        $value13=$args[13];
	        $value14=$args[14];
	        $value15=$args[15];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5,:value6,:value7,:value8,:value9,:value10,:value11,:value12,:value13,:value14,:value15)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            $stmt->bindParam(':value6',$value6);
            $stmt->bindParam(':value7',$value7);
            $stmt->bindParam(':value8',$value8);
            $stmt->bindParam(':value9',$value9);
            $stmt->bindParam(':value10',$value10);
            $stmt->bindParam(':value11',$value11);
            $stmt->bindParam(':value12',$value12);
            $stmt->bindParam(':value13',$value13);
            $stmt->bindParam(':value14',$value14);
            $stmt->bindParam(':value15',$value15);
            
	    }elseif(func_num_args()==17){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
	        $value6=$args[6];
	        $value7=$args[7];
	        $value8=$args[8];
	        $value9=$args[9];
	        $value10=$args[10];
	        $value11=$args[11];
	        $value12=$args[12];
	        $value13=$args[13];
	        $value14=$args[14];
	        $value15=$args[15];
	        $value16=$args[16];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5,:value6,:value7,:value8,:value9,:value10,:value11,:value12,:value13,:value14,:value15,:value16)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            $stmt->bindParam(':value6',$value6);
            $stmt->bindParam(':value7',$value7);
            $stmt->bindParam(':value8',$value8);
            $stmt->bindParam(':value9',$value9);
            $stmt->bindParam(':value10',$value10);
            $stmt->bindParam(':value11',$value11);
            $stmt->bindParam(':value12',$value12);
            $stmt->bindParam(':value13',$value13);
            $stmt->bindParam(':value14',$value14);
            $stmt->bindParam(':value15',$value15);
            $stmt->bindParam(':value16',$value16);
            
	    }elseif(func_num_args()==18){ //($table,$data,$where,$whereValues,$db)     SELECT WITH WHERE 
	    	$table=$args[0];
	        $value1=$args[1];
	        $value2=$args[2];
	        $value3=$args[3];
	        $value4=$args[4];
	        $value5=$args[5];
	        $value6=$args[6];
	        $value7=$args[7];
	        $value8=$args[8];
	        $value9=$args[9];
	        $value10=$args[10];
	        $value11=$args[11];
	        $value12=$args[12];
	        $value13=$args[13];
	        $value14=$args[14];
	        $value15=$args[15];
	        $value16=$args[16];
	        $value17=$args[17];
            
            $stmt = $this->con->prepare("INSERT INTO $table VALUES (NULL, :value1,:value2,:value3,:value4,:value5,:value6,:value7,:value8,:value9,:value10,:value11,:value12,:value13,:value14,:value15,:value16,:value17)");
            $stmt->bindParam(':value1',$value1);
            $stmt->bindParam(':value2',$value2);
            $stmt->bindParam(':value3',$value3);
            $stmt->bindParam(':value4',$value4);
            $stmt->bindParam(':value5',$value5);
            $stmt->bindParam(':value6',$value6);
            $stmt->bindParam(':value7',$value7);
            $stmt->bindParam(':value8',$value8);
            $stmt->bindParam(':value9',$value9);
            $stmt->bindParam(':value10',$value10);
            $stmt->bindParam(':value11',$value11);
            $stmt->bindParam(':value12',$value12);
            $stmt->bindParam(':value13',$value13);
            $stmt->bindParam(':value14',$value14);
            $stmt->bindParam(':value15',$value15);
            $stmt->bindParam(':value16',$value16);
            $stmt->bindParam(':value17',$value17);
            
	    }
	   
	   
		if($stmt->execute()){
            return 1;
        }else{
            return 2;
        }
	}
    
    
    
       //count total records
    function countAll($query){
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
    }
    //pagination
    function pagenate($query, $page_number){
        $per_page = $this->item_per_page;
        //$this->item_per_page = $per_page;
        
        $numrecords = $this->countAll($query);
        
        $this->pages = $numrecords;  
        
        $position = (($page_number-1) * $per_page);
        
        $sql_pagination = $this->con->prepare($query." LIMIT ".  $position.",".$per_page);
        //echo "SELECT id,fullname FROM users LIMIT $start,$numperpage";
        $sql_pagination->execute();
        
        return $sql_pagination->fetchAll();
    }
	 
    
    //RETRIEVE SINGLE RECORD
    function retrieveSingle($query){
            $stmt = $this->con->prepare($query);
            $stmt->execute();
            return $stmt->fetch();
            
    }
    
    //RETRIEVE SINGLE RECORD
    function retrieveMany($query){
            $stmt = $this->con->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
            
    }
	
     /* function to UPDATE sql data*/
    function updateData($table, $data, $where){
        $cols = array();

        foreach($data as $key=>$val) {
            $cols[] = "$key = '$val'";
        }
        $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";
        
        
        $stmt = $this->con->prepare($sql);
        if($stmt->execute()){
            return 1;
        }else{
            return 2;
        }

        
    }
    
     /* function to insert into table */
    function insertData($table, $data) {
        $key = array_keys($data);
        $val = array_values($data);
        $sql = "INSERT INTO $table (" . implode(', ', $key) . ") "
             . "VALUES ('" . implode("', '", $val) . "')";

        $stmt = $this->con->prepare($sql);
        
        if($stmt->execute()){
            return 1;
        }else{
            return 2;
        }
    }
    
    function deleteData($table,$where){
        
        $sql = "DELETE FROM $table WHERE $where";
        
        
        $stmt = $this->con->prepare($sql);
        if($stmt->execute()){
            return 1;
        }else{
            return 2;
        }
    }
    
    function random_code(){
        
        $returned =  substr(base_convert(sha1(uniqid(mt_rand())),16,36),0,4);
//        $returned =  substr(base_convert(sha1(uniqid(mt_rand())),16,36),0,$limit);
        $string = mt_rand(1000,9000).$returned;
        return strtoupper($string);
    }
}

?>