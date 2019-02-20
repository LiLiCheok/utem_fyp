<?php
	
	include_once '../db_conn.php';

	$query = "SELECT COUNT(*) as number FROM category WHERE status='active'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$count_row = $stmt->rowCount();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if ($count_row == 1) {
		
		foreach($result as $row) {
		
			$number = $row['number'];
			
		}
		
		$_SESSION['numberOfCategory'] = $number;
	}

?>