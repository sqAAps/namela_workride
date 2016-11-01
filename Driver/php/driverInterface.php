<?php
header('Access-Control-Allow-Origin: *');

require_once "core.inc.php";
require 'connect.inc.php';
error_reporting(E_ALL);
global $connection;

if (isset($_POST["load_requests"])){
	$query = "SELECT * FROM `user_requests` ";
	if ($query_run = mysqli_query($connection, $query)) {
		$query_num_rows = mysqli_num_rows($query_run);
		if($query_num_rows == 0){
			?>
			<p id="no_requests">No request(s)</p>
			<?php
		}
		else{
			$i = 1;
			while ($rows = mysqli_fetch_array($query_run)) {
				$ad_id = $rows ['id'];

				$user_id = $rows ['user_id'];
				
				$date = $rows ['date'];
				$dateArray = explode(".", $date);
				$month = intval($dateArray[1]);
				switch ($month) {
					case 0:
						$month="JAN";
						break;
					case 1:
						$month="FEB";
						break;
					case 2:
						$month="MAR";
						break;
					case 3:
						$month="APR";
						break;
					case 4:
						$month="MAY";
						break;
					case 5:
						$month="JUN";
						break;
					case 6:
						$month="JUL";
						break;
					case 7:
						$month="AUG";
						break;
					case 8:
						$month="SEP";
						break;
					case 9:
						$month="OCT";
						break;
					case 10:
						$month="NOV";
						break;
					case 11:
						$month="DEC";
						break;
					default:
						
						break;
				}
				$day = $dateArray[3];
				
				$type = $rows ['type'];
				
				//Check todays date
				$today = getdate();
				$d = $today['mday'];
     			$m = $today['mon'];
				
				//show todays and tomorrows requests
				if(($m === (intval($dateArray[1])) + 1) && ($d === intval($dateArray[3]) || $d < (intval($dateArray[3]) + 1))){
					//ad owbers details
					$sql = "SELECT * FROM `user_details` WHERE `user_id`='".mysqli_real_escape_string($connection, $user_id)."' LIMIT 3";
					if($sql_run = mysqli_query($connection, $sql)){
						$sql_num_rows = mysqli_num_rows($sql_run);

						if ($sql_num_rows == 1) {                            
							while ($rows = mysqli_fetch_array($sql_run)) {
								$home_address = $rows ['home_address'];
								$work_address = $rows ['work_address'];
								$work_login_time = $rows ['work_login_time'];
								$work_logout_time = $rows ['work_logout_time'];
							}
						}
					}


					//ad owbers details
					$query2 = "SELECT * FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $user_id)."' ";
					if($query_run2 = mysqli_query($connection, $query2)){
						$query_num_rows2 = mysqli_num_rows($query_run2);

						if ($query_num_rows2===1) {                            
							while ($rows = mysqli_fetch_array($query_run2)) {
								$id = $rows['id'];
								$firstName =  $rows['firstName'];
								$surname = $rows['surname'];
								$phoneNumber = $rows['phoneNumber'];
							}
						}
					}

					?>
					<div class="request_holder" onclick='toggle_menu("<?php echo $i;?>", "<?php echo $home_address;?>", "<?php echo $work_address;?>", "<?php echo $work_login_time;?>", "<?php echo $work_logout_time;?>")'>
						<div class="request_container" id="request_container<?php echo $i;?>">
							<p id="full_names">
								<?php echo $firstName." ".$surname;?>

								<img class="add" id="add<?php echo $i;?>" src="images/add.png" onclick='addRequest("<?php echo $i;?>")'/>

								<img class="remove" id="remove<?php echo $i;?>" src="images/remove.png" onclick='removeRequest("<?php echo $i;?>")'/>
							</p>

							<p id="contact_details">
								<?php echo "Cell Number: ".$phoneNumber;?>
							</p>

							<div class="request_pickup">
								<div class="request_pickup_details">
									<p class="request_pickup_text">PickUp Point:</p>
									<p class="request_pickup_selected">d-_-b</p>
								</div>

								<div class="request_pickup_details">
									<p class="request_pickup_text">Valid Until:</p>
									<p class="request_pickup_selected"><?php echo $day."-".$month."-16";?></p>
								</div>

								<div class="request_pickup_details">
									<p class="request_pickup_text">Type:</p>
									<p class="request_pickup_selected"><?php echo $type;?></p>
								</div>
							</div>

							<div id="work">
								<div id="work_time">
									<div id="work_login_time">
										<?php echo '<span id="work_check">
											<img class="location_img" src="images/in.png"/>
											Check-In:
										</span>
										<p class="work_times">'.$work_login_time.'</p>';?>
										<!--</span>-->
									</div>

									<div id="work_logout_time">
										<?php echo '<span id="work_check">
										<img class="location_img" src="images/out.png"/> Check-Out:</span><p class="work_times"> '.$work_login_time.'</p>';?>
									</div>
								</div>
							</div>

						</div>
					</div>

					<!--    map     
					<div class="map-canvas" id="< ?php echo $i; ?>"></div>
					-->
					<?php
				} else if($m < intval($dateArray[1])) {
					//ad owbers details
					$sql = "SELECT * FROM `user_details` WHERE `user_id`='".mysqli_real_escape_string($connection, $user_id)."' LIMIT 3";
					if($sql_run = mysqli_query($connection, $sql)){
						$sql_num_rows = mysqli_num_rows($sql_run);

						if ($sql_num_rows == 1) {                            
							while ($rows = mysqli_fetch_array($sql_run)) {
								$home_address = $rows ['home_address'];
								$work_address = $rows ['work_address'];
								$work_login_time = $rows ['work_login_time'];
								$work_logout_time = $rows ['work_logout_time'];
							}
						}
					}


					//ad owbers details
					$query2 = "SELECT * FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $user_id)."' ";
					if($query_run2 = mysqli_query($connection, $query2)){
						$query_num_rows2 = mysqli_num_rows($query_run2);

						if ($query_num_rows2===1) {                            
							while ($rows = mysqli_fetch_array($query_run2)) {
								$id = $rows['id'];
								$firstName =  $rows['firstName'];
								$surname = $rows['surname'];
								$phoneNumber = $rows['phoneNumber'];
							}
						}
					}

					?>
					<div class="request_holder" onclick='toggle_menu("<?php echo $i;?>", "<?php echo $home_address;?>", "<?php echo $work_address;?>", "<?php echo $work_login_time;?>", "<?php echo $work_logout_time;?>")'>
						<div class="request_container" id="request_container<?php echo $i;?>">
							<p id="full_names">
								<?php echo $firstName." ".$surname;?>

								<img class="add" id="add<?php echo $i;?>" src="images/add.png" onclick='addRequest("<?php echo $i;?>")'/>

								<img class="remove" id="remove<?php echo $i;?>" src="images/remove.png" onclick='removeRequest("<?php echo $i;?>")'/>
							</p>

							<p id="contact_details">
								<?php echo "Cell Number: ".$phoneNumber;?>
							</p>

							<div class="request_pickup">
								<div class="request_pickup_details">
									<p class="request_pickup_text">PickUp Point:</p>
									<p class="request_pickup_selected">d-_-b</p>
								</div>

								<div class="request_pickup_details">
									<p class="request_pickup_text">Valid Until:</p>
									<p class="request_pickup_selected"><?php echo $day."-".$month."-16";?></p>
								</div>

								<div class="request_pickup_details">
									<p class="request_pickup_text">Type:</p>
									<p class="request_pickup_selected"><?php echo $type;?></p>
								</div>
							</div>

							<div id="work">
								<div id="work_time">
									<div id="work_login_time">
										<?php echo '<span id="work_check">
											<img class="location_img" src="images/in.png"/>
											Check-In:
										</span>
										<p class="work_times">'.$work_login_time.'</p>';?>
										<!--</span>-->
									</div>

									<div id="work_logout_time">
										<?php echo '<span id="work_check">
										<img class="location_img" src="images/out.png"/> Check-Out:</span><p class="work_times"> '.$work_login_time.'</p>';?>
									</div>
								</div>
							</div>

						</div>
					</div>

					<!--    map     
					<div class="map-canvas" id="< ?php echo $i; ?>"></div>
					-->
					<?php
				}
				$i ++;
			}
			?>
			<button id="confirm_page">Confirm PickUps</button>
			<?php		
		}
		
	}
}
            

if(isset($_POST["addRequest"])){
	$addRequest = $_POST["addRequest"];
	
	$query2 = " INSERT INTO `wishlist` VALUES 
				(
				'',
				'".mysqli_real_escape_string($connection, $_SESSION['user_id'])."',
				'".mysqli_real_escape_string($connection, $ad_id)."'
				)";
    mysqli_query($connection, $query2);
}