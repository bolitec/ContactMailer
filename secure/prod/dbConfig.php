<?php 
//  This establishes the database variables and initiates the db connection
$host     = "localhost";			// Host name 
$username = $_SERVER['DB_USER'];	// Mysql username 
$passpass = $_SERVER['DB_PASS'];	// Mysql password 
$db_name  = "lbolivar_JCLM";	// Database name 
$tbl_name = "member";				// member Table name
$tbl_name2 = "profile";				// user Table name
$tbl_name3 = "Emails";				// user Table name

// Connects to the Database in dbConfig.php
$link = mysqli_connect($host, $username, $passpass,$db_name) or die('MySQL DB '.$db_name.' Connection error: '.mysql_error().' '); 
mysqli_select_db($link, $db_name) or die('DB '.$db_name.' mysql_select_db error: '.mysql_error().' '); 


?>