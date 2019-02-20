<?php

try {
	
	include 'db_conn.php';
	
	$user_id = $_POST['user_id'];
	$address = $_POST['address'];
	$postcode = $_POST['postcode'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	
	$query = "SELECT COUNT(address_id) as num_address FROM address";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row) {
		$old_aid = $row['num_address'];
	}
	
	$address_id = 'A'.sprintf("%09s", $old_aid+1);
	$query1 = "INSERT INTO address (address_id, address, postcode, city, state, user_id) VALUES ('$address_id', '$address', '$postcode', '$city', '$state', '$user_id')";
	$stmt1 = $conn->prepare($query1);
	$stmt1->execute();
	
	echo "added";
	
} catch(PDOException $e) {
	echo "Error : " . $e->getMessage();
}

?>