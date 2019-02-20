<?php

session_start();

try {

	include_once 'db_conn.php';
		
	// attribute of user entity
	$user_name = $_POST['register_name'];
	$user_email = $_POST['register_email'];
	$user_password = $_POST['confirm_password'];
	$user_ic = $_POST['register_ic'];
	$user_contact = $_POST['register_contact'];
	$user_role = "seller";
	
	// attribute of shop entity
	$shop_image = $_POST['shop_image'];
	$shop_name = $_POST['reg_company'];
	$ssm_no = $_POST['reg_ssm'];
	$shop_desc = $_POST['reg_desc'];
	$shop_contact = $_POST['reg_phone'];
	
	$day = $_POST['daily'];
	$time_start = $_POST['reg_start'];
	$time_end = $_POST['reg_end'];
	$business_hour = $day."(,1)".$time_start."(-1)".$time_end."(.1)";
	
	$mday = $_POST['monday'];
	$mtime_start = $_POST['mon_start'];
	$mtime_end = $_POST['mon_end'];
	$tday = $_POST['tuesday'];
	$ttime_start = $_POST['tue_start'];
	$ttime_end = $_POST['tue_end'];
	$wday = $_POST['wednesday'];
	$wtime_start = $_POST['wed_start'];
	$wtime_end = $_POST['wed_end'];
	$hday = $_POST['thursday'];
	$htime_start = $_POST['thur_start'];
	$htime_end = $_POST['thur_end'];
	$fday = $_POST['friday'];
	$ftime_start = $_POST['fri_start'];
	$ftime_end = $_POST['fri_end'];
	$sday = $_POST['saturday'];
	$stime_start = $_POST['sat_start'];
	$stime_end = $_POST['sat_end'];
	$uday = $_POST['sunday'];
	$utime_start = $_POST['sun_start'];
	$utime_end = $_POST['sun_end'];
	$all_business_hour = $mday."(,1)".$mtime_start."(-1)".$mtime_end."(.1)".$tday."(,2)".$ttime_start."(-2)".$ttime_end."(.2)".
						 $wday."(,3)".$wtime_start."(-3)".$wtime_end."(.3)".$hday."(,4)".$htime_start."(-4)".$htime_end."(.4)".
						 $fday."(,5)".$ftime_start."(-5)".$ftime_end."(.5)".$sday."(,6)".$stime_start."(-6)".$stime_end."(.6)".
						 $uday."(,7)".$utime_start."(-7)".$utime_end."(.7)";
	
	$delivery_service = $_POST['delivery'];
	$delivery_info = $_POST['delivery_info'];
	
	$shop_location = $_POST['reg_location'];
	
	// attribute of address entity
	$address = $_POST['reg_address'];
	$postcode = $_POST['reg_postcode'];
	$city = $_POST['reg_city'];
	$state = $_POST['reg_state'];
	
	$user_id = "";
	$user_email_true = "";
	
	$query = "SELECT user_id, user_email FROM user WHERE user_email = '$user_email'";
	
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($result as $row) {
		$user_id = $row['user_id'];
		$user_email_true = $row['user_email'];
	}
	
	if($user_email_true==$user_email) {
	
		echo "email_exist";
	
	} else {
	
		$query_check_id = "SELECT(SELECT COUNT(user_id) FROM user) as num_user,
		(SELECT COUNT(address_id) FROM address) as num_address, (SELECT COUNT(shop_id) FROM shop) as num_shop";
	
		$stmt_check_id = $conn->prepare($query_check_id);
		$stmt_check_id->execute();
		
		$result_check_id = $stmt_check_id->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($result_check_id as $row_check_id) {
			$old_uid = $row_check_id['num_user'];
			$old_aid = $row_check_id['num_address'];
			$old_sid = $row_check_id['num_shop'];
		}
	
		if($old_uid!=0||$old_uid==0) {
		
			$new_uid = 'U'.sprintf("%09s", $old_uid+1);
		
			if($shop_location=="") {
				
				$u_query = "INSERT INTO user (user_id, user_email, user_name, user_password, ic_no, contact_no, user_role, create_at)
				VALUES ('$new_uid', '$user_email', '$user_name', '$user_password', '$user_ic', '$user_contact', '$user_role', CURRENT_TIMESTAMP)";
				
				$u_stmt = $conn->prepare($u_query);
				$u_stmt->execute();
				
				if($old_aid!=0||$old_aid==0) {
					
					$new_aid = 'A'.sprintf("%09s", $old_aid+1);
								
					$a_query = "INSERT INTO address (address_id, address, postcode, city, state, user_id)
					VALUES ('$new_aid', '$address', '$postcode', '$city', '$state', '$new_uid')";
					
					$a_stmt = $conn->prepare($a_query);
					$a_stmt->execute();
					
					if($old_sid!=0||$old_sid==0) {
		
						$new_sid = 'S'.sprintf("%09s", $old_sid+1);
						
						if($day=="") {
							
							$s_query = "INSERT INTO shop (shop_id, shop_image, shop_name, ssm_no, shop_desc, shop_contact, business_hour, delivery_service, delivery_info, user_id)
							VALUES ('$new_sid', '$shop_image', '$shop_name', '$ssm_no', '$shop_desc', '$shop_contact', '$all_business_hour', '$delivery_service', '$delivery_info', '$new_uid')";
							
							$s_stmt = $conn->prepare($s_query);
							$s_stmt->execute();
							
							echo "user_registered";
							
						} else {
							
							$s_query = "INSERT INTO shop (shop_id, shop_image, shop_name, ssm_no, shop_desc, shop_contact, business_hour, delivery_service, delivery_info, user_id)
							VALUES ('$new_sid', '$shop_image', '$shop_name', '$ssm_no', '$shop_desc', '$shop_contact', '$business_hour', '$delivery_service', '$delivery_info', '$new_uid')";
							
							$s_stmt = $conn->prepare($s_query);
							$s_stmt->execute();
							
							echo "user_registered";
						}
					}
				}
			} else {
				
				$u_query = "INSERT INTO user (user_id, user_email, user_name, user_password, ic_no, contact_no, user_role, create_at)
				VALUES ('$new_uid', '$user_email', '$user_name', '$user_password', '$user_ic', '$user_contact', '$user_role', CURRENT_TIMESTAMP)";
				
				$u_stmt = $conn->prepare($u_query);
				$u_stmt->execute();
				
				if($old_sid!=0||$old_sid==0) {
				
					$new_sid = 'S'.sprintf("%09s", $old_sid+1);
								
					if($day=="") {
							
						$s_query = "INSERT INTO shop (shop_id, shop_image, shop_name, ssm_no, shop_desc, shop_contact, business_hour, shop_location, delivery_service, delivery_info, user_id)
						VALUES ('$new_sid', '$shop_image', '$shop_name', '$ssm_no', '$shop_desc', '$shop_contact', '$all_business_hour', '$shop_location', '$delivery_service',  '$delivery_info', '$new_uid')";
						
						$s_stmt = $conn->prepare($s_query);
						$s_stmt->execute();
						
					} else {
						
						$s_query = "INSERT INTO shop (shop_id, shop_image, shop_name, ssm_no, shop_desc, shop_contact, business_hour, shop_location, delivery_service, delivery_info, user_id)
						VALUES ('$new_sid', '$shop_image', '$shop_name', '$ssm_no', '$shop_desc', '$shop_contact', '$business_hour', '$shop_location', '$delivery_service', '$delivery_info', '$new_uid')";
						
						$s_stmt = $conn->prepare($s_query);
						$s_stmt->execute();
					}
				}
				echo "user_registered";
			}
			
		} else {}
	}
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}
		
?>