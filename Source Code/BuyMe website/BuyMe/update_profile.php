<?php

try {
	
	include 'db_conn.php';
	
	$user_id = $_POST['user_id'];
	$new_name = $_POST['new_name']; 
	$new_ic = $_POST['new_ic'];
	$new_contact = $_POST['new_contact'];
	$new_address = $_POST['new_address'];
	$new_postcode = $_POST['new_postcode'];
	$new_city = $_POST['new_city'];
	$new_state = $_POST['new_state'];
	
	$query = "UPDATE user SET user_name='$new_name', contact_no='$new_contact', ic_no='$new_ic' WHERE user_id='$user_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$query2 = "SELECT * FROM address";
	$stmt2 = $conn->prepare($query2);
	$stmt2->execute();
	$row = $stmt2->rowCount();
	$address_id = 'A'.sprintf("%09s", $row+1);
	
	$query1 = "INSERT INTO address (address_id, address, postcode, city, state, user_id) VALUES ('$address_id', '$new_address', '$new_postcode', '$new_city', '$new_state', '$user_id')";
	$stmt1 = $conn->prepare($query1);
	$stmt1->execute();
	
	echo "updated";
	
} catch(PDOException $e) {

	echo "Error : " . $e->getMessage();
}

?>