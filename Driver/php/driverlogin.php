<?php
header('Access-Control-Allow-Origin: *');

require_once "core.inc.php";
require 'connect.inc.php';
error_reporting(E_ALL);
global $connection;

$v = mysqli_real_escape_string($connection, $_POST['v']);
$p = mysqli_real_escape_string($connection, $_POST['p']);
$p = md5($p);
$query = "SELECT * FROM `driverdetails` WHERE `VIN`='".mysqli_real_escape_string($connection, $v)."'";
if ($query_run = mysqli_query($connection, $query)) {
	$query_num_rows = mysqli_num_rows($query_run);
	
	if($query_num_rows == 0){
		echo '<span style="color: #ff0000;font-family: sans-serif;font-size: 13px;">Vehicle not registered</span>';
		exit();
	}
	else if ($query_num_rows == 1) {
		while ($rows = mysqli_fetch_array($query_run)) {
			$serverPassword = $rows['password'];
		}
		
		if ($p == $serverPassword){
			while ($rows = mysqli_fetch_array($query_run)) {
				$_SESSION['user_id'] = $rows['id'];
			}
			echo 'Success';
			exit();
		}
		else{
			echo '<span style="color: #ff0000;font-family: sans-serif;font-size: 13px;">Incorrect Password</span>';
			exit();
		}
	}
}
		