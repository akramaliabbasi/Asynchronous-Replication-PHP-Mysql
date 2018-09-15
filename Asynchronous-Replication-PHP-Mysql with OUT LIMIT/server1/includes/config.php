<?php  ini_set('max_input_vars', 3000);

/*
FILE NAME : config.php
LOCATION : includes/config.php
BASIC DETAILS : This file includes details about the database connections and basic settings.
AUTHOR : Bharat Parmar
VERSION : 1.0
CREATED DATE : 08-12-2016 

*/

//DATABASE DETAILS
define("HOST","localhost");
define("DBNAME","dd_classifieds2");
define("DBUSER","root");
define("DBPASSWORD","");


// SERVER URL WHERE YOU WANT TO SYCN DATABASE
define("SYNC_URL","http://localhost:81/mysql-database-synchronization-with-php-master/server2/example.php"); 

//SET TIMEZONE
//date_default_timezone_set("Asia/Kolkata");
?>