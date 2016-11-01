<?php
header('Access-Control-Allow-Origin: *');

require_once "core.inc.php";
require 'connect.inc.php';
error_reporting(E_ALL);
global $connection;

if( isset($_POST['subject']) && isset($_POST['message'])){
	$s = mysqli_real_escape_string($connection, $_POST['subject']);
	$m = mysqli_real_escape_string($connection, nl2br($_POST['message']));
	$to = "info@sqaaps.co.za";	
	
	$query = "SELECT * FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."' ";
	if ($query_run = mysqli_query($connection, $query)) {
		$query_num_rows = mysqli_num_rows($query_run);
			
		if ($query_num_rows == 1 ) {
			while($rows = mysqli_fetch_array($query_run)) {
				$firstName = $rows["firstName"];
				$surname = $rows["surname"];
				$e = $rows["email"];
				$p = $rows["phoneNumber"];
			}	
		}
	}
	$from = $e;
	
	$subject = 'LAISA ERROR: '.$s;
	$message = '<b>Name:</b> '.$firstName.' '.$surname.'<br><b>Email:</b> '.$e.' <b>Phone_Number: '.$p.' <p>'.$m.'</p>';
	$headers = "From: $from\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	if( mail($to, $subject, $message, $headers) ){
		echo "success";
	} else {
		echo "The server failed to send the message. Please try again later.";
	}
}
?>