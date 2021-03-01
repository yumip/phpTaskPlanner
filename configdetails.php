<?php
$servername = "localhost:3307";//name of the server
$username = "root";//username
$password = "root";//password
$dbname = "tplanner";//name of the database

// code to create connection
$conn = mysqli_connect($servername,$username, $password, $dbname);
//check connection
if(!$conn){
    die("Connection failed: " .mysqli_connect_error());
    
} else{
    //echo "connected successfully";
}
?>