<?php
	session_start();
	
	$user_id = $_POST['admin_id'];
	$user_password = $_POST['admin_password'];
	
	try {

		include_once '../db_conn.php';
		
		$query = "SELECT * FROM user WHERE user_role='admin' AND user_email = '$user_id' AND user_password = '$user_password'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		$count_row = $stmt->rowCount();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if ($count_row == 1) {
			
			foreach($result as $row) {
			
				$name = $row['user_name'];
				$role = $row['user_role'];
				$last_login = $row['create_at'];
				
			}
			
			$_SESSION['curr_user'] = $name;
			$_SESSION['curr_role'] = $role;
			$_SESSION['last_login'] = $last_login;
			
			echo "login_successfully";
				
		} else {
	
			echo "login_error";
		
		}
		
	} catch(PDOException $e) {

		echo "Error: " . $e->getMessage();
	}
?>