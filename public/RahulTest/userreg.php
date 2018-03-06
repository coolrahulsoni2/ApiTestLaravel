<?php include 'head.php';?>
<?php
//if(isset($_POST['email1']) )
date_default_timezone_set('Asia/Kolkata');

if(isset($_POST['fullName']) )
{
         
		 
$data['modified'] = date("Y-m-d H:i:s");
 $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $db);
 
 $username = $_POST["fullName"];
 $email = $_POST["email"];
 $password = $_POST["password"];
 $cname = $_POST["cName"];
 $phone = $_POST["phoneno"];
 $status = $_POST["status"];
 $enga = $_POST["enga"];
 $dt = date("Y-m-d H:i:s");
 $sql="SELECT name,count FROM systable where name='user'";
 $stmt = $mysqli->prepare($sql);
 $stmt->execute();
 $stmt->bind_result($name, $count);
  echo $name."---".$count;
 while($stmt->fetch()) {
      //echo "$name, $count";
   }
   //echo "$name, $count";
   $stmt->close();
   $coun=(int)($count)+1;
   //$mysqli->close();
 $sql = "UPDATE systable SET count='".$coun."' WHERE name='User'";
if($mysqli->query($sql) === true){
    //echo "Records were updated successfully.";
} else{
    //echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}
 
 $stmt = $mysqli->prepare("INSERT INTO user (id,Name,email,phone,password,createdon,status,cname,enga) VALUES (?,?,?,?,?,?,?,?,?)");
 $stmt->bind_param("sssssssss", $coun,$username, $email, $phone, $password,$dt,$status,$cname,$enga);
 $stmt->execute();
 $stmt->close();
 $mysqli->close();
 
header("location:useradd.php");
 }
?>

