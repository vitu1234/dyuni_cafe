<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

require '../../connection/Functions.php';


$app = new \Slim\App([
    'settings'=>[
        'displayErrorDetails'=>true
    ]
]);

//$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
//    "secure"=>false,
//    "users" => [
//        "belalkhan" => "123456",
//    ]
//]));


//user login
$app->post('/userlogin', function(Request $request, Response $response){

    if(!haveEmptyParameters(array('email', 'password'), $request, $response)){
        $request_data = $request->getParsedBody(); 

        $email = $request_data['email'];
        $password = $request_data['password'];

        $operation = new Functions();
        
        $query = "SELECT * FROM `users` WHERE email = '$email' AND user_role <> 'admin' ";
        $count = $operation->countAll($query);
        if($count>0){
            //get the user
            $user = $operation->retrieveSingle($query);
            $hashed_password = $user['password'];

            if(password_verify($password, $hashed_password)){
                
                if($user['account_status'] == 1){
                    
                    //get user but filter out some values
                    $user = $operation->retrieveSingle("SELECT *FROM `users` WHERE email = '$email' AND user_role <> 'admin' ");
                    $user_id = $user['user_id'];

                    $response_data = array();
                    
                    $response_data['error']=false; 
                    $response_data['message'] = 'Login Successful';
                    $response_data['user'] = $user;

                    $response->write(json_encode($response_data));

                    return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(200); 
                }else{
                    $response_data = array();

                    $response_data['error']=true; 
                    $response_data['message'] = 'Account Suspended';

                    $response->write(json_encode($response_data));

                    return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(201); 
                }
            }else{
                $response_data = array();

                $response_data['error']=true; 
                $response_data['message'] = 'Invalid credential';

                $response->write(json_encode($response_data));

                return $response
                    ->withHeader('Content-type', 'application/json')
                    ->withStatus(201);  
            }
            
        }else{
           $response_data = array();

            $response_data['error']=true; 
            $response_data['message'] = 'User does not exist';

            $response->write(json_encode($response_data));

            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);  
        }        
    }

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);    
});

//user register
$app->post('/userregister', function(Request $request, Response $response){

    if(!haveEmptyParameters(array('fullname','phone','email', 'password','user_role'), $request, $response)){
        $request_data = $request->getParsedBody(); 

        $fullname = $request_data['fullname'];
        $phone = $request_data['phone'];
        $user_role = $request_data['user_role'];
        $email = $request_data['email'];
        $pass = $request_data['password'];
        //encyrpt password
        $password=password_hash($pass, PASSWORD_DEFAULT);

        $operation = new Functions();
        
        $query = "SELECT * FROM `users` WHERE email = '$email' AND user_role <> 'admin' ";
        $count = $operation->countAll($query);
        if($count==0){

            $table = "users";
            $data = [
                'fullname'=>"$fullname",
                'phone'=>"$phone",
                'email'=>"$email",
                'password'=>"$password",
                'user_role'=>"$user_role"
            ];

            if ($operation->insertData($table,$data) == 1) {
                # code...
                 $response_data = array();
            
                $response_data['error']=false; 
                $response_data['message'] = 'Account created, please login to continue!';

                $response->write(json_encode($response_data));

                return $response
                    ->withHeader('Content-type', 'application/json')
                    ->withStatus(200); 
            }else{
                 $response_data = array();

                $response_data['error']=true; 
                $response_data['message'] = 'An error occured while registering, try again later!';

                $response->write(json_encode($response_data));

                return $response
                    ->withHeader('Content-type', 'application/json')
                    ->withStatus(201); 
            }

           
      
            
        }else{
           $response_data = array();

            $response_data['error']=true; 
            $response_data['message'] = 'Email is taken, try another email';

            $response->write(json_encode($response_data));

            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);  
        }        
    }

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);    
});

//get meals
$app->get('/get_menu_items',function(Request $request, Response $response){
    //get all incomplete
    $today = date('Y-m-d');

    $operation = new Functions();
    $query = "SELECT *FROM menu_items INNER JOIN meals ON menu_items.meal_id = meals.meal_id
    WHERE menu_items.menu_expiry_date >= '$today'";
    
    if($operation->countAll($query) > 0 ){
        $my_orders = $operation->retrieveMany($query);
        $response_data = array();

        $response_data['error']=false; 
        $response_data['message'] = 'Meals';
        $response_data['meals'] = $my_orders;
        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
        
    }else{
        $response_data = array();
                    
        $response_data['error']=true; 
        $response_data['message'] = 'Nothing found in menu!';

        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
    }
     return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422); 
    
});

//get dashboard meals
$app->get('/get_dash_menu_items',function(Request $request, Response $response){
    //get all incomplete
    $today = date('Y-m-d');

    $operation = new Functions();
    $query = "SELECT *FROM menu_items INNER JOIN meals ON menu_items.meal_id = meals.meal_id
    WHERE menu_items.menu_expiry_date >= '$today' LIMIT 5";
    
    if($operation->countAll($query) > 0 ){
        $my_orders = $operation->retrieveMany($query);
        $response_data = array();

        $response_data['error']=false; 
        $response_data['message'] = 'Meals';
        $response_data['meals'] = $my_orders;
        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
        
    }else{
        $response_data = array();
                    
        $response_data['error']=true; 
        $response_data['message'] = 'Nothing found in menu!';

        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
    }
     return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422); 
    
});

//get my orders
$app->get('/myorders/{user_id}',function(Request $request, Response $response, array $args){
    $id = $args['user_id'];
    //get all completed orders
    $operation = new Functions();
   $query = "SELECT * FROM `orders` 
                INNER JOIN menu_items ON menu_items.menu_id = orders.menu_id
                INNER JOIN meals ON menu_items.meal_id = meals.meal_id WHERE orders.user_id = '$id'
                ";
    
    if($operation->countAll($query) > 0 ){
        $my_orders = $operation->retrieveMany($query);
        $response_data = array();

        $response_data['error']=false; 
        $response_data['message'] = 'My Orders';
        $response_data['orders'] = $my_orders;
        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
        
    }else{
        $response_data = array();
                    
        $response_data['error']=true; 
        $response_data['message'] = 'Your orders will appear here!';

        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
    }
     return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);   
});

//get my orders
$app->get('/dashboard_orders',function(Request $request, Response $response){
    //get all completed orders
    $operation = new Functions();
   $query = "SELECT * FROM `orders` 
                INNER JOIN menu_items ON menu_items.menu_id = orders.menu_id
                INNER JOIN meals ON menu_items.meal_id = meals.meal_id LIMIT 5
                ";
    
    if($operation->countAll($query) > 0 ){
        $my_orders = $operation->retrieveMany($query);
        $response_data = array();

        $response_data['error']=false; 
        $response_data['message'] = 'Orders';
        $response_data['orders'] = $my_orders;
        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
        
    }else{
        $response_data = array();
                    
        $response_data['error']=true; 
        $response_data['message'] = 'Your orders will appear here!';

        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
    }
     return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);   
});




















//get delivered and assigned orders to this driver
$app->get('/myorders_complete/{user_id}',function(Request $request, Response $response, array $args){
    $id = $args['user_id'];
    //get all completed orders
    $operation = new Functions();
   $query = "SELECT 
    orders.order_id, users.fname, users.lname,users.email, users.phone, orders.user_id,orders.product_id, orders.quantity, orders.payment_status, orders.order_delivery_status,
    products.product_name, products.restaurant_id, products.product_price, products.availability, products.prep_mins, products.img_url,
    restaurant_info.city_id, restaurant_info.restaurant_name, restaurant_info.restaurant_phone, restaurant_info.restaurant_address, restaurant_info.placeID, restaurant_info.exact_location, 
    restaurant_info.longtude, restaurant_info.latitude, restaurant_info.img_url as rest_img,
    customer_location.placeID as cus_placeID, customer_location.exact_location as cus_exact_location, customer_location.longtude as cus_longtude, customer_location.latitude as cus_latitude,
    order_assign.date_created as date_assigned
     FROM `order_assign` 
    INNER JOIN orders ON order_assign.order_id = orders.order_id
    INNER JOIN products ON orders.product_id = products.product_id
    INNER JOIN restaurant_info ON products.restaurant_id = restaurant_info.restaurant_id
    INNER JOIN users ON users.user_id = orders.user_id
    INNER JOIN customer_location ON orders.order_id = customer_location.order_id
    WHERE order_assign.user_id = '$id' AND order_delivery_status = 1";
    
    if($operation->countAll($query) > 0 ){
        $my_orders = $operation->retrieveMany($query);
        $response_data = array();

        $response_data['error']=false; 
        $response_data['message'] = 'Completed Orders';
        $response_data['orders'] = $my_orders;
        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
        
    }else{
        $response_data = array();
                    
        $response_data['error']=true; 
        $response_data['message'] = 'You did not deliver anything!';

        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
    }
     return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422); 
    
});

//get order information
$app->get('/order_info/{order_id}',function(Request $request, Response $response, array $args){
    $order_id = $args['order_id'];
    $operation = new Functions();
    $query = "SELECT orders.order_id, users.fname, users.lname,users.email, users.phone, orders.user_id,orders.product_id, orders.quantity, orders.payment_status, orders.order_delivery_status,
    products.product_name, products.restaurant_id, products.product_price, products.availability, products.prep_mins, products.img_url,
    restaurant_info.city_id, restaurant_info.restaurant_name, restaurant_info.restaurant_phone,restaurant_info.restaurant_address, restaurant_info.placeID, restaurant_info.exact_location, 
    restaurant_info.longtude, restaurant_info.latitude, restaurant_info.img_url as rest_img, 
    customer_location.placeID as cus_placeID, customer_location.exact_location as cus_exact_location, customer_location.longtude as cus_longtude, customer_location.latitude as cus_latitude,
    order_assign.date_created as date_assigned
    FROM `orders` 
    INNER JOIN products ON products.product_id = orders.product_id
    INNER JOIN restaurant_info ON products.restaurant_id = restaurant_info.restaurant_id  
    INNER JOIN customer_location ON orders.order_id = customer_location.order_id
    INNER JOIN users ON orders.user_id = users.user_id    
    INNER JOIN order_assign ON orders.order_id = order_assign.order_id
    WHERE orders.order_id = '$order_id'";
    
    if($operation->countAll($query) > 0 ){
        $my_orders = $operation->retrieveSingle($query);
        $response_data = array();

        $response_data['error']=false; 
        $response_data['message'] = 'Order Details';
        $response_data['orders'] = $my_orders;
        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
        
    }else{
        $response_data = array();
                    
        $response_data['error']=true; 
        $response_data['message'] = 'Such order does not exist!';

        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
    }
     return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422); 
    
});

//view restaurant information
$app->get('/restaurant_info/{rest_id}',function(Request $request, Response $response, array $args){
    $id = $args['rest_id'];

    $operation = new Functions();
    $query = "SELECT * FROM `restaurant_info` WHERE restaurant_id = '$id'";
    
    if($operation->countAll($query) > 0 ){
        $my_orders = $operation->retrieveSingle($query);
        $response_data = array();

        $response_data['error']=false; 
        $response_data['message'] = 'Restaurant Info.';
        $response_data['restaurant_info'] = $my_orders;
        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
        
    }else{
        $response_data = array();
                    
        $response_data['error']=true; 
        $response_data['message'] = 'Such restaurant does not exist!';

        $response->write(json_encode($response_data));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
    }
     return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422); 
    
});

//change driver online status
$app->put('/change_driver_availability', function(Request $request, Response $response){

//check if parameters been passed
    if(!haveEmptyParameters(array('user_id', 'online_status'), $request, $response)){
        $request_data = $request->getParsedBody(); 

        $user_id = $request_data['user_id'];
        $online_status = $request_data['online_status'];
        
        $operation = new Functions();
        
        $table = "driver_availability";
        $data = [
            'availability_status'=>"$online_status"
        ];
        $where = "user_id = '$user_id'";

        //check driver records
        $countDriver = $operation->countAll("SELECT * FROM `driver_availability` WHERE user_id = '$user_id'");
        if($countDriver > 0){
             if($operation->updateData($table,$data,$where) == 1){
                    $response_data['error']=false; 
                    $response_data['message'] = 'Status Changed';
                    $response->write(json_encode($response_data));

                    return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(200);

                }else{
                    $response_data['error']=true; 
                    $response_data['message'] = 'Status not Changed';
                    $response->write(json_encode($response_data));

                    return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(200);
                }
        }else{
            $response_data['error']=true; 
            $response_data['message'] = 'Oops logout and login again!';
            $response->write(json_encode($response_data));

            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);
        }

   

        
        
    }

    $response_data['error']=true; 
    $response_data['message'] = 'Empty data';
    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);    
});

// change password
$app->put('/changepassword', function(Request $request, Response $response){

    if(!haveEmptyParameters(array('user_id', 'password1', 'password2'), $request, $response)){
        $request_data = $request->getParsedBody(); 

        $user_id = $request_data['user_id'];
        $password1 = $request_data['password1'];
        $password2 = $request_data['password2'];
        
        $operation = new Functions();
        
        $query = "SELECT * FROM `users` WHERE user_id = '$user_id' AND user_role = 'driver' ";
        $count = $operation->countAll($query);
        if($count>0){
            
            //get the user
            $user = $operation->retrieveSingle($query);
            $hashed_password = $user['password'];

            if(password_verify($password1, $hashed_password)){
                
                if($user['account_status'] == 1){
                    
                    //update the password
                    $new_password = password_hash($password2, PASSWORD_DEFAULT);

                    if(password_verify($password2, $hashed_password)){
                        $response_data = array();

                        $response_data['error']=true; 
                        $response_data['message'] = 'New password cannot be equal to current password';

                        $response->write(json_encode($response_data));

                        return $response
                            ->withHeader('Content-type', 'application/json')
                            ->withStatus(201); 
                    }else{
                      $table ="users";
                      $data = [
                          'password'=>"$new_password"
                      ];

                      $where = "user_id = '$user_id'";
                      $response_data = array();

                      if($operation->updateData($table,$data,$where) == 1){
                        $response_data['error']=false; 
                        $response_data['message'] = 'Password changed';
                      }else{
                        $response_data['error']=false; 
                        $response_data['message'] = 'An error occured while changing password';
                      }

                      $response->write(json_encode($response_data));

                      return $response
                          ->withHeader('Content-type', 'application/json')
                          ->withStatus(200); 
                    }

                  
         
                }else{
                    $response_data = array();

                    $response_data['error']=true; 
                    $response_data['message'] = 'Account Suspended';

                    $response->write(json_encode($response_data));

                    return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(201); 
                }
                
           
            }else{
                $response_data = array();

                $response_data['error']=true; 
                $response_data['message'] = 'Enter correct current password';

                $response->write(json_encode($response_data));

                return $response
                    ->withHeader('Content-type', 'application/json')
                    ->withStatus(201);  
            }
            
            
        }else{
           $response_data = array();

            $response_data['error']=true; 
            $response_data['message'] = 'User does not exist';

            $response->write(json_encode($response_data));

            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);  
        }
        
        
    }

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);    
});

//change phone
$app->put('/changephone', function(Request $request, Response $response){

    if(!haveEmptyParameters(array('user_id', 'new_phone'), $request, $response)){
        $request_data = $request->getParsedBody(); 

        $user_id = $request_data['user_id'];
        $new_phone = $request_data['new_phone'];
        
        
        $operation = new Functions();
        
        $query = "SELECT * FROM `users` WHERE user_id = '$user_id' AND user_role = 'driver' ";
        $count = $operation->countAll($query);
        if($count>0){
            
            //get the user
            $user = $operation->retrieveSingle($query);
                
                if($user['account_status'] == 1){
                    
                      $table ="users";
                      $data = [
                          'phone'=>"$new_phone"
                      ];

                      $where = "user_id = '$user_id'";
                      $response_data = array();

                      if($operation->updateData($table,$data,$where) == 1){
                        $response_data['error']=false; 
                        $response_data['message'] = 'Phone number changed';
                      }else{
                        $response_data['error']=false; 
                        $response_data['message'] = 'An error occured while changing phone number';
                      }

                      $response->write(json_encode($response_data));

                      return $response
                          ->withHeader('Content-type', 'application/json')
                          ->withStatus(200); 
                  
                }else{
                    $response_data = array();

                    $response_data['error']=true; 
                    $response_data['message'] = 'Account is Suspended';

                    $response->write(json_encode($response_data));

                    return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(201); 
                }
                
           
      
            
            
        }else{
           $response_data = array();

            $response_data['error']=true; 
            $response_data['message'] = 'User does not exist';

            $response->write(json_encode($response_data));

            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);  
        }
        
        
    }

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);    
});

//change order status
$app->put('/change_order_status', function(Request $request, Response $response){

    if(!haveEmptyParameters(array('order_id'), $request, $response)){
        $request_data = $request->getParsedBody(); 

        $order_id = $request_data['order_id'];
        
        
        $operation = new Functions();
        
        $query = "SELECT * FROM `orders` WHERE order_id = '$order_id'";
        $count = $operation->countAll($query);
        if($count>0){
            
            //get the user
            $user = $operation->retrieveSingle($query);
                
              
                    
                      $table ="orders";
                      $data = [
                          'order_delivery_status'=>1
                      ];

                      $where = "order_id = '$order_id'";
                      $response_data = array();

                      if($operation->updateData($table,$data,$where) == 1){
                        $response_data['error']=false; 
                        $response_data['message'] = 'Order Delivered';
                      }else{
                        $response_data['error']=false; 
                        $response_data['message'] = 'An error occured while changing order status';
                      }

                      $response->write(json_encode($response_data));

                      return $response
                          ->withHeader('Content-type', 'application/json')
                          ->withStatus(200); 
                  
                
                
           
      
            
            
        }else{
           $response_data = array();

            $response_data['error']=true; 
            $response_data['message'] = 'We cannot find this order, try again later';

            $response->write(json_encode($response_data));

            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);  
        }
        
        
    }

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);    
});

//PASSWORD RESET
//check email
$app->post('/reset_password1', function(Request $request, Response $response){
    require("../../mailing/vendor/phpmailer/phpmailer/src/PHPMailer.php");
    require("../../mailing/vendor/phpmailer/phpmailer/src/SMTP.php");
    require("../../mailing/vendor/phpmailer/phpmailer/src/Exception.php");

    if(!haveEmptyParameters(array('email'), $request, $response)){
        $request_data = $request->getParsedBody(); 

        $email = $request_data['email'];
        $response_data = array();
        $operation = new Functions();
        
        $query = "SELECT * FROM `users` WHERE email = '$email' AND user_role = 'driver' ";
        $count = $operation->countAll($query);
        if($count>0){
            
            //get the user
            $user = $operation->retrieveSingle($query);
                if($user['account_status'] == 1){
                    
                    //get user but filter out some values
                    $user = $operation->retrieveSingle("SELECT *FROM `users` WHERE email = '$email' AND user_role = 'driver' ");
                    $user_id = $user['user_id'];
                  
                    $expFormat = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+1, date("Y"));
                    $expDate = date("Y-m-d H:i:s",$expFormat);
                    $code = rand(1111,3333);
                    $role = "driver";
                    $table = "password_reset";
                    $data = [
                        'email' =>"$email",
                        'code' => "$code",
                        'expiry_date' => "$expDate",
                        'role' => "$role",
                    ];


                    if($operation->insertData($table,$data) == 1){
                        $output='<p>Dear '.$email.',</p>';
                       $output.='<p>Please enter the following code on the prompt to reset your password:</p>';
                       $output.='<br/><p align="center">    
                           '.$code.'
                       </p><br/>'; 
                       $output.='<p>
                       The reset session will expire after 1 day for security reason.</p>';
                       $output.='<p>If you did not request this forgotten password email, no action 
                       is needed, your password will not be reset. However, you may want to log into 
                       your account and change your security password.</p>';   
                       $output.='<p>Regards,</p>';
                       $output.='<p><strong>OrderIn Team</strong></p>';
                       $body = $output; 
                       $subject = "Password Recovery - OrderIn";

                       //echo $output;
                       //die();

                       $email_to = $email;
                       $fromserver = "noreply@Dyuni"; 
                        
               
                       $mail = new PHPMailer\PHPMailer\PHPMailer();
                       //$mail->IsSMTP(); // enable SMTP
                       $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
                       $mail->SMTPAuth = true; // authentication enabled
                       $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
                       $mail->Host = "mail.netsoftmw-test.com";
                       $mail->Port = 587; // or 587
                       $mail->IsHTML(true);
                       $mail->Username = "support@gdg.com";
                       $mail->Password = "xxxxx1";
                       $mail->setFrom("support@netsoftmw-test.com","OrderIn");
                       $mail->Subject = $subject;
                       $mail->Body = $body;
                       $mail->addAddress($email);

                        if(!$mail->Send()){
                                      
                    
                            $response_data['error']=true; 
                            $response_data['message'] = 'Failed to sent email with reset code';

                            $response->write(json_encode($response_data));

                            return $response
                                ->withHeader('Content-type', 'application/json')
                                ->withStatus(200); 
                        }else{
                              $response_data = array();
                    
                            $response_data['error']=false; 
                            $response_data['message'] = 'Reset code has been sent to your email';

                            $response->write(json_encode($response_data));

                            return $response
                                ->withHeader('Content-type', 'application/json')
                                ->withStatus(200); 
                        } 
                    }else{
                       echo json_encode(array("code"=>2,"msg"=>"An error occured please try again later!"));
                    }    
                                
                


                  
                }else{
                    $response_data = array();

                    $response_data['error']=true; 
                    $response_data['message'] = 'Account Suspended';

                    $response->write(json_encode($response_data));

                    return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(201); 
                }
                
           
     
            
            
        }else{
           $response_data = array();

            $response_data['error']=true; 
            $response_data['message'] = 'User does not exist';

            $response->write(json_encode($response_data));

            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);  
        }
        
        
    }
$response->write(json_encode($response_data));
    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);    
});

//check code
$app->post('/reset_password2', function(Request $request, Response $response){
     $response_data = array();
    if(!haveEmptyParameters(array('email','code'), $request, $response)){
        $request_data = $request->getParsedBody(); 

        $email = $request_data['email'];
        $code = $request_data['code'];

       
        $operation = new Functions();
        
            //check email
         $getEmail = $operation->retrieveSingle("SELECT * FROM `password_reset` WHERE email = '$email' AND role='driver' ORDER BY id DESC");
         $expDate = $getEmail['expiry_date'];
         $curDate = date("Y-m-d H:i:s");
         if ($expDate >= $curDate){
          if($getEmail['code'] == $code ){
                $response_data['error']=false; 
                $response_data['message'] = 'Matched';

            $response->write(json_encode($response_data));

            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);  
                 
             }else{
                $response_data['error']=true; 
                $response_data['message'] = 'Wrong code entered';

            $response->write(json_encode($response_data));

            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);  
             }



          }else{
            $response_data['error']=true; 
            $response_data['message'] = 'Sorry, the entered code has expired!';

            $response->write(json_encode($response_data));

            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);  
          }
    }else{
         $response_data['error']=true; 
            $response_data['message'] = 'Sorry, missing parameters!';

            $response->write(json_encode($response_data));

            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);  
    }
    $response->write(json_encode($response_data));
    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);    
});

//finally create new password

// change password
$app->put('/resetpassword3', function(Request $request, Response $response){

    if(!haveEmptyParameters(array('email', 'password1', 'password2'), $request, $response)){
        $request_data = $request->getParsedBody(); 

        $user_id = $request_data['email'];
        $password1 = $request_data['password1'];
        $password2 = $request_data['password2'];
        
        $operation = new Functions();
        
        $query = "SELECT * FROM `users` WHERE email = '$user_id' AND user_role = 'driver' ";
        $count = $operation->countAll($query);
        if($count>0){
            
            //get the user
            $user = $operation->retrieveSingle($query);
            $hashed_password = $user['password'];

    
                if($user['account_status'] == 1){
                    
                    //update the password
                    $new_password = password_hash($password2, PASSWORD_DEFAULT);

            
                      $table ="users";
                      $data = [
                          'password'=>"$new_password"
                      ];

                      $where = "email = '$user_id' AND user_role = 'driver'";
                      $response_data = array();

                      if($operation->updateData($table,$data,$where) == 1){
                        $response_data['error']=false; 
                        $response_data['message'] = 'Password changed';
                          $response->write(json_encode($response_data));

                        return $response
                            ->withHeader('Content-type', 'application/json')
                            ->withStatus(201);
                      }else{
                        $response_data['error']=false; 
                        $response_data['message'] = 'An error occured while changing password';
                          $response->write(json_encode($response_data));

                        return $response
                            ->withHeader('Content-type', 'application/json')
                            ->withStatus(201);
                      }

                      $response->write(json_encode($response_data));

                      return $response
                          ->withHeader('Content-type', 'application/json')
                          ->withStatus(200); 
                    
                  
         
                }else{
                    $response_data = array();

                    $response_data['error']=true; 
                    $response_data['message'] = 'Account Suspended';

                    $response->write(json_encode($response_data));

                    return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(201); 
                }
                
           
           
            
            
        }else{
           $response_data = array();

            $response_data['error']=true; 
            $response_data['message'] = 'User does not exist';

            $response->write(json_encode($response_data));

            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);  
        }
        
        
    }

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);    
});









//getProfilePicture by user ID
$app->get('/viewprofile/{user_id}',function(Request $request, Response $response, array $args){
    $user_id= $args['user_id'];

    $operation = new Functions();
    $response_data = array();
      $getUser = $operation->retrieveSingle("SELECT photo FROM `users` WHERE user_id ='$user_id'");

      if($getUser['photo'] != '' || $getUser['photo'] != null){
        
        $response_data['error']=false; 
        $response_data['message'] = 'Loading photo';
        $response_data['photo']= $getUser['photo'];
      }else{
        $response_data['error']=true; 
        $response_data['message'] = 'No Profile photo found';
        $response_data['photo']= "";
      }
              

      
  
  
    
                    


    $response->write(json_encode($response_data));
    
     return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200); 
    
});



function haveEmptyParameters($required_params, $request, $response){
    $error = false; 
    $error_params = '';
    $request_params = $request->getParsedBody(); 

    foreach($required_params as $param){
        if(!isset($request_params[$param]) || strlen($request_params[$param])<=0){
            $error = true; 
            $error_params .= $param . ', ';
        }
    }

    if($error){
        $error_detail = array();
        $error_detail['error'] = true; 
        $error_detail['message'] = 'Required parameters ' . substr($error_params, 0, -2) . ' are missing or empty';
        $response->write(json_encode($error_detail));
    }
    return $error; 
}

$app->run();

