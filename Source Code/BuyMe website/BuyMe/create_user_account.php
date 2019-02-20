<?php

session_start();

try {

	include_once 'db_conn.php';
		
	$user_name = $_POST['register_name'];
	$user_email = $_POST['register_email'];
	$user_password = $_POST['confirm_password'];
	$user_ic = $_POST['register_ic'];
	$user_contact = $_POST['register_contact'];
	$user_role = "user";
		
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
	
		$query_check_id = "SELECT COUNT(user_id) as num_user FROM user";
	
		$stmt_check_id = $conn->prepare($query_check_id);
		$stmt_check_id->execute();
		
		$result_check_id = $stmt_check_id->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($result_check_id as $row_check_id) {
			$old_uid = $row_check_id['num_user'];
		}
	
		if($old_uid!=0) {
		
			$new_uid = 'U'.sprintf("%09s", $old_uid+1);
			
			$query = "INSERT INTO user (user_id, user_email, user_name, user_password, ic_no, contact_no, user_role, create_at)
			VALUES ('$new_uid', '$user_email', '$user_name', '$user_password', '$user_ic', '$user_contact', '$user_role', CURRENT_TIMESTAMP)";
			
			$stmt = $conn->prepare($query);
			$stmt->execute();
				
			echo "user_registered";
		}
	}
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}
		
?>