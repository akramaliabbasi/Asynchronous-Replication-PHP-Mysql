<?php

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
@include("class/server1.class.php");
$server1 = new server1();
$output = $server1->getdbupdate();

echo "<pre>";
print_r($output);
echo "</pre>";

?>