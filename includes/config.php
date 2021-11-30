<?php
//error_reporting(0);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myapi";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}


/* Some Constant Variables*/
$imageFileSize=500000;
$returnData = array("status"=>"false", "message"=>" ", "data"=>[]);
$types=array('a'=>'jpg','b'=>'png','c'=>'jpeg','d'=>'gif','e'=>'JPG','f'=>'PNG','g'=>'JPEG','h'=>'GIF');


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>