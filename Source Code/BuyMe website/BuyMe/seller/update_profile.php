<?php

try {
	
	include '../db_conn.php';
	
	$user_id=$_POST['user_id'];
	$shop_contact=$_POST['shop_contact'];
	$shop_desc=$_POST['shop_desc'];
	$postcode=$_POST['postcode'];
	$city=$_POST['city'];
	$contact_no=$_POST['contact_no'];
	$user_name=$_POST['user_name'];
	$shop_name=$_POST['shop_name'];
	$address=$_POST['address'];
	$ic_no=$_POST['ic_no'];
	$ssm_no=$_POST['ssm_no'];
	$delivery_service=$_POST['delivery_service'];
	$shop_image=$_POST['shop_image'];
	$address=$_POST['address'];
	$state=$_POST['state'];
	
	$shop_location=$_POST['shop_location'];
	$new_loc=$_POST['new_loc'];
	
	$day = $_POST['daily'];
	$time_start = $_POST['daily_start'];
	$time_end = $_POST['daily_end'];
	$business_hour = $day."(,1)".$time_start."(-1)".$time_end."(.1)";
	$day_1 = $_POST['day_1'];
	$time_start_1 = $_POST['time_start_1'];
	$time_end_1 = $_POST['time_end_1'];
	$new_business_hour = $day_1."(,1)".$time_start_1."(-1)".$time_end_1."(.1)";
	
	$mday = $_POST['new_monday'];
	$mtime_start = $_POST['new_mon_start'];
	$mtime_end = $_POST['new_mon_end'];
	$tday = $_POST['new_tuesday'];
	$ttime_start = $_POST['new_tue_start'];
	$ttime_end = $_POST['new_tue_end'];
	$wday = $_POST['new_wednesday'];
	$wtime_start = $_POST['new_wed_start'];
	$wtime_end = $_POST['new_wed_end'];
	$hday = $_POST['new_thursday'];
	$htime_start = $_POST['new_thur_start'];
	$htime_end = $_POST['new_thur_end'];
	$fday = $_POST['new_friday'];
	$ftime_start = $_POST['new_fri_start'];
	$ftime_end = $_POST['new_fri_end'];
	$sday = $_POST['new_saturday'];
	$stime_start = $_POST['new_sat_start'];
	$stime_end = $_POST['new_sat_end'];
	$uday = $_POST['new_sunday'];
	$utime_start = $_POST['new_sun_start'];
	$utime_end = $_POST['new_sun_end'];
	$all_business_hour = $mday."(,1)".$mtime_start."(-1)".$mtime_end."(.1)".$tday."(,2)".$ttime_start."(-2)".$ttime_end."(.2)".
						 $wday."(,3)".$wtime_start."(-3)".$wtime_end."(.3)".$hday."(,4)".$htime_start."(-4)".$htime_end."(.4)".
						 $fday."(,5)".$ftime_start."(-5)".$ftime_end."(.5)".$sday."(,6)".$stime_start."(-6)".$stime_end."(.6)".
						 $uday."(,7)".$utime_start."(-7)".$utime_end."(.7)";
	$urmday = $_POST['ur_monday'];
	$urmtime_start = $_POST['ur_mon_start'];
	$urmtime_end = $_POST['ur_mon_end'];
	$urtday = $_POST['ur_tuesday'];
	$urttime_start = $_POST['ur_tue_start'];
	$urttime_end = $_POST['ur_tue_end'];
	$urwday = $_POST['ur_wednesday'];
	$urwtime_start = $_POST['ur_wed_start'];
	$urwtime_end = $_POST['ur_wed_end'];
	$urhday = $_POST['ur_thursday'];
	$urhtime_start = $_POST['ur_thur_start'];
	$urhtime_end = $_POST['ur_thur_end'];
	$urfday = $_POST['ur_friday'];
	$urftime_start = $_POST['ur_fri_start'];
	$urftime_end = $_POST['ur_fri_end'];
	$ursday = $_POST['ur_saturday'];
	$urstime_start = $_POST['ur_sat_start'];
	$urstime_end = $_POST['ur_sat_end'];
	$uruday = $_POST['ur_sunday'];
	$urutime_start = $_POST['ur_sun_start'];
	$urutime_end = $_POST['ur_sun_end'];
	
	$delivery_info = $_POST['del_info'];
	
	if($user_id!=""&&$shop_contact!="") {
		$query = "Update shop SET shop_contact='$shop_contact' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$shop_desc!="") {
		$query = "Update shop SET shop_desc='$shop_desc' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$postcode!="") {
		$query = "Update address SET postcode='$postcode' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$city!="") {
		$query = "Update address SET city='$city' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$contact_no!="") {
		$query = "Update user SET contact_no='$contact_no' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$user_name!="") {
		$query = "Update user SET user_name='$user_name' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$shop_name!="") {
		$query = "Update shop SET shop_name='$shop_name' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$address!="") {
		$query = "Update address SET address='$address' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$ic_no!="") {
		$query = "Update user SET ic_no='$ic_no' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$ssm_no!="") {
		$query = "Update shop SET ssm_no='$ssm_no' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$delivery_service!="") {
		if($delivery_service=="no") {
			$query = "Update shop SET delivery_service='$delivery_service', delivery_info='$delivery_info' WHERE user_id = '$user_id'";
			$stmt = $conn->prepare($query);
			$stmt->execute();
		} else {
			$query = "Update shop SET delivery_service='$delivery_service' WHERE user_id = '$user_id'";
			$stmt = $conn->prepare($query);
			$stmt->execute();
		}
		echo "updated";
	}
	
	if($user_id!=""&&$shop_image!="") {
		$query = "Update shop SET shop_image='$shop_image' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$address!=""&&$postcode!=""&&$city!=""&&$state!="") {
		$query_check_id = "SELECT COUNT(address_id) FROM address as num_address";
	
		$stmt_check_id = $conn->prepare($query_check_id);
		$stmt_check_id->execute();
		
		$result_check_id = $stmt_check_id->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($result_check_id as $row_check_id) {
			$old_aid = $row_check_id['num_address'];
		}
		
		if($old_aid!=0||$old_aid==0) {
			$new_aid = 'A'.sprintf("%09s", $old_aid+1);
			$query = "INSERT INTO address (address_id, address, postcode, city, state, user_id) VALUES ('$new_aid', '$address', '$postcode', '$city', '$state', '$user_id')";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			$query_1 = "Update shop SET shop_location=NULL WHERE user_id = '$user_id'";
			$stmt_1 = $conn->prepare($query_1);
			$stmt_1->execute();
			echo "updated";
		}
	}
	
	if($user_id!=""&&$shop_location!="") {
		$query = "Update shop SET shop_location='$shop_location' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$new_loc!="") {
		$query = "Update shop SET shop_location='$new_loc' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$query_1 = "DELETE FROM address WHERE user_id = '$user_id'";
		$stmt_1 = $conn->prepare($query_1);
		$stmt_1->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$day!=""&&$time_start!=""&&$time_end!="") {
		$query = "Update shop SET business_hour='$business_hour' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$day_1!=""&&$time_start_1!=""&&$time_end_1!="") {
		$query = "Update shop SET business_hour='$new_business_hour' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$mtime_start!=""&&$mtime_end!=""&&$ttime_start!=""&&$ttime_end!=""&&$wtime_start!=""&&$wtime_end!=""&&$htime_start!=""&&$htime_end!=""&&$ftime_start!=""&&$ftime_end!=""&&$stime_start!=""&&$stime_end!=""&&$utime_start!=""&&$utime_end!="") {
		$query = "Update shop SET business_hour='$all_business_hour' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}

	if($user_id!=""&&$urmtime_start!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urmtime_start,strpos($bh, "(,1)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urmtime_end!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urmtime_end,strpos($bh, "(-1)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urttime_start!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urttime_start,strpos($bh, "(,2)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urttime_end!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urttime_end,strpos($bh, "(-2)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urwtime_start!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urwtime_start,strpos($bh, "(,3)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urwtime_end!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urwtime_end,strpos($bh, "(-3)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urhtime_start!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urhtime_start,strpos($bh, "(,4)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urhtime_end!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urhtime_end,strpos($bh, "(-4)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urftime_start!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urftime_start,strpos($bh, "(,5)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urftime_end!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urftime_end,strpos($bh, "(-5)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urstime_start!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urstime_start,strpos($bh, "(,6)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urstime_end!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urstime_end,strpos($bh, "(-6)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urutime_start!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urutime_start,strpos($bh, "(,7)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$urutime_end!="") {
		$ur_query = "SELECT business_hour FROM shop WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$ur_result = $ur_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ur_result as $row) {
			$bh = $row['business_hour'];
		}
		$new_bh = substr_replace($bh,$urutime_end,strpos($bh, "(-7)")+4,8);
		
		$query = "Update shop SET business_hour='$new_bh' WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		echo "updated";
	}
	
	if($user_id!=""&&$delivery_info!="") {
		$ur_query = "UPDATE shop SET delivery_info = '$delivery_info' WHERE user_id = '$user_id'";
		$ur_stmt = $conn->prepare($ur_query);
		$ur_stmt->execute();
		$stmt->execute();
		echo "updated";
	}
	
} catch(PDOExeption $e) {
	
	echo "Error: " . $e->getMessage();
}

?>