<?php
try {
	include_once '../db_conn.php';
	
	$query = "SELECT * FROM user WHERE user_role='seller'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$count_row = $stmt->rowCount();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if ($count_row != 0) {
		
		foreach($result as $row) {
			
			echo "<tr>";
			echo "<td>".$row['user_id']."</td>";
			echo "<td>".$row['user_email']."</td>";
			echo "<td>".$row['user_name']."</td>";
			echo "<td>".$row['create_at']."</td>";
			echo "</tr>";	
		}
	}
} catch(PDOException $e) {

	echo "Error: " . $e->getMessage();
}
?>