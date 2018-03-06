<?php

ob_start();

/**** Function for get visitor Ip Address **/

function getVisitorIP() {
	
		//Just get the headers if we can or else use the SERVER global
		if ( function_exists( 'apache_request_headers' ) ) {
			$headers = apache_request_headers();
		} else {
			$headers = $_SERVER;
		}
		//Get the forwarded IP if it exists
		if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			$the_ip = $headers['X-Forwarded-For'];
		} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
		) {
			$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
		} else {
			
			$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
		}
		return $the_ip;
	}
	
session_start();
if (isset($_SESSION['emailFMW'])) 
{
				$resultMain['data']='Already Login';
			     header('Content-type: application/json');
                echo json_encode($resultMain);
}
else{	
$req=$_POST['req'];	
if($req=="validation") {
include 'dao.php';

$result = mysqli_query($con,"SELECT * FROM  `user` where `password`='".mysqli_real_escape_string($con, $_POST['password'])."' and `email`='".mysqli_real_escape_string($con,$_POST['email'] )."' ");
	//echo "SELECT * FROM  `email` where password='".mysqli_real_escape_string($con, $_POST['password'])."' and `username`='".mysqli_real_escape_string($con,$_POST['email'] )."' where validationRemainingDay!=0 ";

$row=mysqli_fetch_array($result);
if($row)
  {
   $validationRemainingDay=$row['validationRemainingDay'];
	   $getVisitorIp=getVisitorIP();	 
	
		$sqlEdituser=mysqli_query($con,"Update `user` Set `	ip_address`='".$getVisitorIp."', `lastLoginTime`='".time()."' Where `email`='".$_POST['email']."'");
	 if( $validationRemainingDay=="0"){
		 
		mysqli_close($con);
			// Sending JSON-encoded response
					$resultMain['data']='Sorry Your Account is Expired Please Contact Admin For ReActivate it';
			     header('Content-type: application/json');
                echo json_encode($resultMain);
	 } 
	  else{
		  
		  
		  
$_SESSION["emailFMW"] = $_POST['email'];
	
	 
	
		mysqli_close($con);
			// Sending JSON-encoded response
					$resultMain['data']='Login SuccessFull';
			     header('Content-type: application/json');
                echo json_encode($resultMain);
	  }
  }
    else{
	mysqli_close($con);
	//$Active1=$row['ActivationStatus'];
			// Sending JSON-encoded response
	   $resultMain['data']='Either Your Email Or password Is Wrong ';
		header('Content-type: application/json');
         echo json_encode($resultMain);
}
 }
 
else{
	// Sending JSON-encoded response
					mysqli_close($con);
					$resultMain['data']='Unknown Request';
			     header('Content-type: application/json');
                echo json_encode($resultMain);
				
	
}
 
}
ob_flush();
 ?>