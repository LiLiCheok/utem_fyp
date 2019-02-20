<?php
	
session_start();

$email = $_POST['loginEmail'];
$password = $_POST['loginPassword'];

$email = stripslashes($email);
$password = stripslashes($password);

try {

	include_once 'db_conn.php';
	
	$query = "SELECT user_id, user_email, user_password, user_name, user_role, create_at
	FROM user WHERE user_email = '$email' AND user_password = '$password'";
	
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$count_row = $stmt->rowCount();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if ($count_row == 1) {
		
		foreach($result as $row) {
		
			$id = $row['user_id'];
			$email = $row['user_email'];
			$role = $row['user_role'];
			$lastlogin = $row['create_at'];
			
		}
		
		$_SESSION['userid'] = $id;
		$_SESSION['username'] = $email;
		$_SESSION['role'] = $role;
		$_SESSION['lastlogin'] = $lastlogin;
		
		if($role=="user")
			echo "user";
		else if($role=="seller")
			echo "seller";
			
	} else {

		echo "login_error";
	
	}
	
} catch(PDOException $e) {

	echo "Error: " . $e->getMessage();
}

?>