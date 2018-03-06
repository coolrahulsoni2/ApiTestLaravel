<?php

ob_start();

/********  Photo Like Request  ***/
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}


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
	
	
$req=$_POST['req'];
include "dao.php";	

/*** Add Post Enquiries */
if($req=="postEnquiriesReq"){
	
	$categoryId=trim(test_input($_POST['categoryId']));	
	$subcat=trim(test_input($_POST['subcat']));	
	$fullName=trim(test_input($_POST['fullName']));	
	$companyName=trim(test_input($_POST['companyName']));	
	$email=trim(test_input($_POST['email']));	
	$phoneno=trim(test_input($_POST['phoneno']));	
	$city=trim(test_input($_POST['city']));	
	$message=trim(test_input($_POST['message']));	
		$i="0";
	
	
		
		if($categoryId=="" || $subcat == "" || $companyName == "" || $fullName =="" || $email =="" || $phoneno=="" || $message==""){
		
		$result['data']='Please Enter All Field';
		header('Content-type: application/json');
        echo json_encode($result);
		}
		else{
					
	
			
			$getVisitorIP=getVisitorIP();
			$date = date('Y-m-d H:i:s');
			
			$sqlAddquery="INSERT INTO `query` (`name`,`companyName`,`email`, `phone`,`city`,`message`,`categoryId`,`addedon`,`subcat`,`enquirerIp`) VALUES ('".$fullName."','".$companyName."','".$email."','".$phoneno."','".$city."','".$message."','".$categoryId."','".$date."','".$subcat."','".$getVisitorIP."')";
			
			if(mysqli_query($con,$sqlAddquery)){
				
				
				$resultfindVendor = mysqli_query($con,"SELECT `id`,`Name`,`email`,`phone`  FROM  `user` where `catId` = '".$categoryId."' AND `city`= '".$city."'  ORDER BY id DESC ");
				
					while($row = mysqli_fetch_array($resultfindVendor))
						{

						$cat['id']=$row['id'];
						 $cat['Name']=$row['Name'];
						 $cat['email']=$row['email'];
						 $cat_arr[$i]=$cat;
						$i=$i+1;
							
							
					$to = $cat['email'];


						$subject = "You Got New enquiry";
					include 'email.php';

							
							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= "From: info@fmwconnect.in";

						mail($to,$subject,$txt,$headers);



							
					  }
					  
					  
					  			
					$to =$email;


						$subject = "Thanks For Posting Enquiry in FMW Connect";
							include 'emailCustomer.php';

							
							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= "From: info@fmwconnect.in";

						mail($to,$subject,$txt,$headers);



					  

						 mysqli_close($con);
				$result['data']='Your Query Send to All Vendor and You will get response in Short Time';
					  header('Content-type: application/json');
					 // echo json_encode($cat_arr);
					  echo json_encode($result);
 
				
				
			
			}
			else{
				$result['data']='Oops ! Sorry There is some Error Ocuured Please try Again In Some Time';
				header('Content-type: application/json');
				echo json_encode($result);
			}
				
				}
	
}
/*** Add Email Subbscription Ends*/
/*
/*
/*
/*
/*** Show Sub Category Function*/

else if($req=="getAjaxSubCategoryReq") {
	$i="0";
$categoryId=trim(test_input($_POST['categoryId']));;
$resultfindCategory = mysqli_query($con,"Select id,name from subcategory where cateId=".$categoryId);
while($row = mysqli_fetch_array($resultfindCategory))
	{

	$cat['id']=$row['id'];
	 $cat['name']=$row['name'];
	 $cat_arr[$i]=$cat;
	$i=$i+1;
  }
   
     mysqli_close($con);
  header('Content-type: application/json');
  echo json_encode($cat_arr);
 
}


/*** Show Sub Category Function Ends*/
/*
/*
/*
/*
/*
/*
/*** Add New Vendor Registration*/
else if($req=="newVendorRegistration"){
	
	$categoryId=trim(test_input($_POST['categoryId']));	
	$status=trim(test_input($_POST['status']));	
	$subcat=trim(test_input($_POST['subcat']));	
	$fullName=trim(test_input($_POST['fullName']));	
	$companyName=trim(test_input($_POST['companyName']));	
	$email=trim(test_input($_POST['email']));	
	$phoneno=trim(test_input($_POST['phoneno']));	
	$city=trim(test_input($_POST['city']));	
	$passwords=trim(test_input($_POST['passwords']));	
	$cpassword=trim(test_input($_POST['cpassword']));	
	$enga=trim(test_input($_POST['enga']));	
	//$message=trim(test_input($_POST['message']));	
		$i="0";
	$dayRemaining=0;
		if($enga==1){
		$dayRemaining=7;
		}
		else if($enga=2){
			$dayRemaining=180;
		}
		else if($enga=3){
			$dayRemaining=365;
		}
	
	
		
		if($categoryId=="" || $subcat == "" || $companyName == "" || $fullName =="" || $email =="" || $phoneno=="" || $passwords=="" || $cpassword=="" || $enga=="" ){
		
		$result['data']='Please Enter All Field';
		header('Content-type: application/json');
        echo json_encode($result);
		}
		else{
			$resultDb = mysqli_query($con,"SELECT `id`,`email` FROM  `user` where `email`='".$email."'");
		if(!(mysqli_num_rows($resultDb) > 0) ){	
				
	
			
			$getVisitorIP=getVisitorIP();
			$date = date('Y-m-d H:i:s');
			
			$sqlAddquery="INSERT INTO user (catID,subSetId,Name,email,phone,city,password,enga,status,cname,ip_address,validationRemainingDay) VALUES ('".$categoryId."','".$subcat."','".$fullName."','".$email."','".$phoneno."','".$city."','".$passwords."','".$enga."','".$status."','".$companyName."','".$getVisitorIP."','".$dayRemaining."')";
			//echo $sqlAddquery;
			if(mysqli_query($con,$sqlAddquery)){
				
				$last_id = mysqli_insert_id($con);
				
					 session_start();
					 $_SESSION["name"] = $fullName;
					 $_SESSION["cname"] = $companyName;
					 $_SESSION["status"] = $status;
					$_SESSION["id"] = $last_id;
					$_SESSION["emailFMW"] = $email;

							
					$to = $email;

						$subject = "You Account is Successfully Registered";
						include 'email_reg.php';

						
							
							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= "From: info@fmwconnect.in";

						mail($to,$subject,$txt,$headers);
				
				
			 $sqlmailprevquery ="select * from query where date(`addedon`) >= date(now()-interval 5 day) where categoryId='".$categoryId."'";
					while($row = mysqli_fetch_array($sqlmailprevquery))
						{

						$cat['id']=$row['id'];
						 $cat['name']=$row['name'];
						 $cat['email']=$row['email'];
						 $cat['companyName']=$row['companyName'];
						 $cat['phone']=$row['phone'];
						 $cat['message']=$row['message'];
						 $cat['addedon']=$row['addedon'];
						 $cat_arr[$i]=$cat;
						$i=$i+1;
						
							
									
							$to = $email;


						$subject = "You Got New enquiry";
					include 'email2.php';

							
							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= "From: info@fmwconnect.in";

						mail($to,$subject,$txt,$headers);


							
						}
			
				

						 mysqli_close($con);
				$result['data']='You Are Successfully Registered with our site';
					  header('Content-type: application/json');
					 // echo json_encode($cat_arr);
					  echo json_encode($result);
 


							
					  }

				else{
				$result['data']='Oops ! Sorry Some Error Occured';
				header('Content-type: application/json');
				echo json_encode($result);
			}
				
				
			
			}
			
			else{
				$result['data']='Oops ! Sorry You Already Registered with this id before';
				header('Content-type: application/json');
				echo json_encode($result);
			}
				
				
				}
			
			
}
/*** Add Email Subbscription Ends*/
/*
/*
/*** Edit Account Info */

else if($req=="updateAinfo") {
	$i="0";
$profileId=trim(test_input($_POST['profileId']));;
$fullName=trim(test_input($_POST['fullName']));;
$phone=trim(test_input($_POST['phone']));;
$about=trim(test_input($_POST['about']));;
$address=trim(test_input($_POST['address']));;
$designation=trim(test_input($_POST['designation']));;
$resultupdateAccount = "UPDATE `user` SET `Name` = '".$fullName."', `phone` = '".$phone."', `designation` = '".$designation."', `about` = '".$about."', `address` = '".$address."' WHERE `user`.`id` = '".$profileId."'";
//	echo $resultupdateAccount;
 if(mysqli_query($con,$resultupdateAccount)){
	    mysqli_close($con);
 $result['data']='Your Profile Successfully Updated';
					  header('Content-type: application/json');
					 // echo json_encode($cat_arr);
					  echo json_encode($result);
 
 
 }
	else {
		 mysqli_close($con);
				$result['data']='Oops! Some Error Occured';
					  header('Content-type: application/json');
					 // echo json_encode($cat_arr);
					  echo json_encode($result);
 
	}
	
  
}


/*** Edit Account Info  Function Ends*/
/*
/*
/*
/*** Edit Account Info */

else if($req=="updateCatinfo") {
	$i="0";
$profileId=trim(test_input($_POST['profileId']));;
$categoryId=trim(test_input($_POST['categoryId']));;
$subcat=trim(test_input($_POST['subcat']));;

$resultupdateAccount = "UPDATE `user` SET `catID` = '".$categoryId."', `subSetId` = '".$subcat."' WHERE `user`.`id` = '".$profileId."'";
//	echo $resultupdateAccount;
 if(mysqli_query($con,$resultupdateAccount)){
	    mysqli_close($con);
 $result['data']='Your Profile Successfully Updated';
					  header('Content-type: application/json');
					 // echo json_encode($cat_arr);
					  echo json_encode($result);
 
 
 }
	else {
		 mysqli_close($con);
				$result['data']='Oops! Some Error Occured';
					  header('Content-type: application/json');
					 // echo json_encode($cat_arr);
					  echo json_encode($result);
 
	}
	
  
}


/*** Edit Account Info  Function Ends*/
/*
/*

/*** Show all Category Product Function*/

else if($req=="showallProduct") {
$i="0";
$resultfindProducts = mysqli_query($con,"SELECT `id`,`Name`,`PeacePerKG`,`Price`,`Ingredient`,`Description`,`Keywords`,`ImageThumb`  FROM  `products` ORDER BY id ASC LIMIT 4");
while($row = mysqli_fetch_array($resultfindProducts))
	{

	$cat['id']=$row['id'];
	 $cat['Name']=$row['Name'];
	 $cat['PeacePerKG']=$row['PeacePerKG'];
	 $cat['Price']=$row['Price'];
	 $cat['Ingredient']=$row['Ingredient'];
	 $cat['Description']=$row['Description'];
	 $cat['Keywords']=$row['Keywords'];
	 $cat['ImageThumb']=$row['ImageThumb'];
	 $cat_arr[$i]=$cat;
	$i=$i+1;
  }
   
     mysqli_close($con);
  header('Content-type: application/json');
  echo json_encode($cat_arr);
 
}


/*** Show all Category Product Function Ends*/
/*
/*
/*
/*** Show all Category Product Function*/















else if($req=="forgetpassword"){
	
	
	
	$MobileNumber=$_POST['MobileNumber'];
	$email=$_POST['email'];
	$regMob ="/^([0|\+[0-9]{1,5})?([7-9][0-9]{9})$/";					
	$regName ="/^[a-zA-Z ]+$/";
	

if (!filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
	
	if (preg_match($regMob,$MobileNumber )== 1){
		
	
		$resultDb = mysqli_query($con,"SELECT `id`,`Email`,`MobileNumber`,`Name`,`userPassword` FROM  `userregistration` where `MobileNumber`='".$MobileNumber."' AND `Email`='".$email."'");
				
			
				
				 if($row = mysqli_fetch_array($resultDb))
			  {
				  $userId=$row['id'];	 
				  $Name=$row['Name'];	 
				  $email=$row['Email'];	 
				$MobileNumber=$row['MobileNumber'];
				$userPassword=$row['userPassword'];
			  
			  
							
			// Sending JSON-encoded response
			
					
				  $ID = 'swarnpar'; 
				  $Pwd = 'sumerjai'; 
				  $sender='RFILMS';
				  $Name=urlencode($Name);
				  //$FName=urlencode($Fname);
				  $PhNo = $MobileNumber; 
				  $Text ='Dear%20'.$Name.'%0AYour%20Forget%20Password%20Detail%20is%0AYour%20Userid%20:'.$userId.'%0AYour%20Password%20:'.$userPassword.'%0Awww.RajasthanFilms.com';  
				  $url="http://sms.proactivesms.in/sendsms.jsp?user=$ID&password=$Pwd&mobiles=$PhNo&sms=$Text&senderid=$sender" ;
				  //echo $url;
				 // echo '<script>alert($url)</script>';
				 
				  $ret = file($url);
				  echo $ret[9]; 
				  
							mysqli_close($con);
							$result['data']="Your Id And Password is Send to Your Registered Mobile Number";
							header('Content-type: application/json');
							echo json_encode($result);
				
					
					
			
			}
			else {
					// Sending JSON-encoded response
					mysqli_close($con);
					$result['data']='We Did Not Find Any Profile From Mobile Number '.$MobileNumber.' And Email id '.$email.'';
					  header('Content-type: application/json');
                echo json_encode($result);
			}
	}
	else{
			mysqli_close($con);
					$result['data']='Please Enter Correct Mobile Number';
			     header('Content-type: application/json');
                echo json_encode($result);
				
	}

	}
	else{
		
		// Sending JSON-encoded response
					mysqli_close($con);
					$result['data']='Please Enter Email Id Correctly';
			     header('Content-type: application/json');
                echo json_encode($result);
				
	}
	

	
	

}




else{
	// Sending JSON-encoded response
					mysqli_close($con);
					$result['data']='Unknown Rqquest';
			     header('Content-type: application/json');
                echo json_encode($result);
				echo "<script>window.location='index';</script>";
	
}
ob_flush();

			?>