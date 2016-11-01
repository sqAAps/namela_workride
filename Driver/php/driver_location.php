<?php
header('Access-Control-Allow-Origin: *');

require_once "core.inc.php";
require 'connect.inc.php';
error_reporting(E_ALL);
global $connection;


if(isset($_POST["request"])){
	$requests = 0;
	
	//today date
	$today = getdate();
	$d = intval($today['mday']);
    $m = intval($today['mon'] - 1);
	
	//user requested date
	$query = "SELECT * FROM `user_requests`";
	if ($query_run = mysqli_query($connection, $query)) {
		$query_num_rows = mysqli_num_rows($query_run);
		
		if($query_num_rows > 0){
			$i = 0;
			while ($rows = mysqli_fetch_array($query_run)) {
				$date = $rows ['date'];
				$dateArray = explode(".", $date);
				$month = intval($dateArray[1]);
				$day = intval($dateArray[3]);
				
				if ($month === $m && $day === $d){
					$requests = $requests + 1;
				}
				$i++;
			}
		}else{
			echo "no rows found";
			exit();
		}
		
		if ($requests > 0){
			echo 'success';
		}
	}
}


if(isset($_POST["lat"]) && isset($_POST["lng"])){
	$lat = $_POST["lat"];
	$lng = $_POST["lng"];
	$pos = $lat.", ".$lng;
	
	//today date
	$today = getdate();
	$d = intval($today['mday']);
    $m = intval($today['mon'] - 1);

	//user requested date
	$query = "SELECT * FROM `user_requests`";
	if ($query_run = mysqli_query($connection, $query)) {
		$query_num_rows = mysqli_num_rows($query_run);
		
		if($query_num_rows > 0){
			while ($rows = mysqli_fetch_array($query_run)) {
				$date = $rows ['date'];
				$dateArray = explode(".", $date);
				$month = intval($dateArray[1]);
				$day = intval($dateArray[3]);
				
				//send to people who requested a ride for that day
				if ($month === $m && $day === $d){
					$sql = "UPDATE `user_requests` SET `driver_location`='$pos' WHERE `date`='$date'";
					$query = mysqli_query($connection, $sql);
				}
			}
		}
	}
}