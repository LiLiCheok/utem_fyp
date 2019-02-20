<?php
	
try {
		
	include_once("db_conn.php");
	
	$query = "SELECT catID, catName FROM category WHERE status='active'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$count_row = $stmt->rowCount();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if($count_row>0) {

		foreach($result as $row) {
		
			echo "<option value='".$row['catID']."'>".$row['catName']."</option>";
		
		}
	}
	
} catch(PDOException $e) {
	
    echo "Error: " . $e->getMessage();
	
}
	
?>