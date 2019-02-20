<?php
	
	try {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$catID = $_POST['catID'];
			$catName = $_POST['catName'];
			$createdAt = $_POST['createdAt'];
			
			if (isset($_POST['create'])) {
		
				include_once '../db_conn.php';
				
				$query = "INSERT INTO category (category_id, category_name, create_at, status) VALUES ('$catID', '$catName', '$createdAt', 'active')";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				
				include_once('getCategoryTotal.php');
				header("location: home.php");
					
			} else if (isset($_POST['update'])) {
				
				include_once '../db_conn.php';
				
				$query = "UPDATE category SET category_name = '$catName' WHERE category_id = '$catID'";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				
				header("location: home.php");
				
			}
		}
	} catch(PDOException $e) {

		echo "Error: " . $e->getMessage();
	}
?>