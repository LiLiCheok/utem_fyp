<?php

try{
	
	include_once '../db_conn.php';
	
	$user_id = $_POST['user_id'];
	
	$query_2 = "SELECT * FROM address WHERE user_id='$user_id'";
	$stmt_2 = $conn->prepare($query_2);
	$stmt_2->execute();
	$count_row_2 = $stmt_2->rowCount();
	
	if ($count_row_2 == 0) {
		$query_1 = "SELECT DISTINCT * FROM user u, shop s WHERE u.user_id=s.user_id and u.user_id='$user_id'";
		$stmt_1 = $conn->prepare($query_1);
		$stmt_1->execute();
		$count_row_1 = $stmt_1->rowCount();
		$result_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);
		if ($count_row_1 == 1) {
			echo json_encode($result_1);
		}
	} else {
		$query = "SELECT DISTINCT * FROM user u, address a, shop s WHERE u.user_id=a.user_id and u.user_id=s.user_id and u.user_id='$user_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$count_row = $stmt->rowCount();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ($count_row == 1) {
			echo json_encode($result);
		}
	}
	
} catch (PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>