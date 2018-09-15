<?php  ini_set('max_input_vars', 3000);

/*
=================================================================================================
FILE NAME : example.php
LOCATION : example.php
BASIC DETAILS : This file is the example file for the database synchronization for server2.
CO-AUTHOR: Akram Abbasi
VERSION : 1.1,
CREATED DATE : 15-09-2018 
NOTE: In Basic version 1.0 has limited memory issue and also with insertion special character issue in server2
=================================================================================================
*/

//DATABASE DETAILS
define("HOST","localhost");
define("DBNAME","DBName");
define("DBUSER","root");
define("DBPASSWORD","");


// SERVER URL WHERE YOU WANT TO SYCN DATABASE
define("SYNC_URL","http://localhost:81/mysql-database-synchronization-with-php-master/server2/example.php"); 

//SET TIMEZONE
//date_default_timezone_set("asia/karachi");
?>