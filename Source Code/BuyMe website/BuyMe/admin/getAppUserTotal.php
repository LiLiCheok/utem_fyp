<?php
try {
	include_once'../db_conn.php';

	$query = "SELECT COUNT(*) as number FROM user WHERE user_role='user'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$count_row = $stmt->rowCount();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if ($count_row == 1) {
		
		foreach($result as $row) {
		
			$num = $row['number'];
		}
	}
	$_SESSION['num'] = $num;
	
} catch(PDOException $e) {

	echo "Error: " . $e->getMessage();
}
?>