<?php
	
	try {
		include_once '../db_conn.php';
		
		$query = "SELECT COUNT(category_id) as cat_id FROM category";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$cat_id = $row['cat_id'];
		}
		
		if($cat_id!=0||$cat_id==0) {
			$new_cid = 'CTG'.sprintf("%03s", $cat_id);
		}
		
		$_SESSION['catID']=$new_cid;
		
		
	} catch(PDOException $e) {
	
		echo "Error: " . $e->getMessage();
	}

?>