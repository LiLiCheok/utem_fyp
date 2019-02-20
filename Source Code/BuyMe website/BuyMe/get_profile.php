<?php

try {
	
	include_once 'db_conn.php';
	
	$user_id = $_POST['user_id'];
	
	$query = "SELECT * FROM address WHERE user_id = '$user_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$count = $stmt->rowCount();
	if($count!=0) {
		$query = "SELECT u.*, a.* FROM user u, address a WHERE u.user_id = a.user_id AND u.user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);

	} else {
		$query = "SELECT * FROM user WHERE user_id = '$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	}
} catch(PDOException $e) {
	
	echo "Error : " . $e->getMessage();
}

?>