<?php

/*
=================================================================================================
FILE NAME : example.php
LOCATION : example.php
BASIC DETAILS : This file is the example file for the database synchronization for server2.
AUTHOR : Bharat Parmar
CO-AUTHOR: Akram Abbasi
VERSION : 1.1,
CREATED DATE : 15-09-2018 
NOTE: In Basic version 1.0 has memory issue and also with insertion special character issue in server2
=================================================================================================
*/


if(isset($_POST['table_name']) && $_POST['table_name']!=""){
	@include("class/server2.class.php");
	$server2 = new server2();
	$output = $server2->table_update($_POST);
	print_r($output);
	exit;
} else {
	echo "Parameter Missings.";
	exit;
}

?>