<?php
//start session.
session_start();




define('SITEURL','http://localhost/food-order/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','new_password');
define('DB_NAME','food-order');
$conn= mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD);



 if(!$conn) { die("Connection failed: ".mysqli_connect_error());
}
$db_select=mysqli_select_db($conn,DB_NAME) or die("DB Selection failed: ".mysqli_error($conn));

?>