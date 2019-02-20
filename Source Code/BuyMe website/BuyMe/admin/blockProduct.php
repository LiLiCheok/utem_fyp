<?php
try {
	include_once '../db_conn.php';
	
	if(isset($_GET['productID'])) {
	
		$productID = $_GET['productID'];
		
		$id="";
		$name="";
		$img="";
		$desc="";
		$date="";
		$userEmail="";
		
		$query = "SELECT p.product_id, p.product_name, p.product_desc, p.post_at, u.user_email FROM product p, shop s, user u WHERE product_id = '$productID' && p.shop_id=s.shop_id AND s.user_id=u.user_id";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		$count_row = $stmt->rowCount();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if ($count_row == 1) {
			
			foreach($result as $row) {
				$id = $row['product_id'];
				$name = $row['product_name'];
				$desc = $row['product_desc'];
				$date = $row['post_at'];
				$userEmail = $row['user_email'];
			}
			
			$to = $userEmail;
			$subject = "Products Blocked from BuyMe";
			$body = "Dear user,\n\nThis is an automated email. Please Do Not reply to this email as you will not receive a response.\n\nYour products:\n\nProduct ID : " . $id . "\nProduct Name : " . $name . "\nProduct Description : " . $desc . "\n which posted on " . $date . " at our website http://localhost:82/BuyMe/ has been blocked by admin, as this product contains harmful information.\n\nFrom,\nThe Administration";
		
			$query_1="UPDATE product SET product_status='block' WHERE product_id='$productID'";
			$stmt_1 = $conn->prepare($query_1);
			$stmt_1->execute();
			
			// send email
			mail($to, $subject, $body);
			
			echo "<script type=\"text/javascript\">alert('Automated Email Sent.');
					window.location.href='selling.php?page=';</script>";
					
		}
					
	}
} catch(PDOException $e) {

	echo "Error: " . $e->getMessage();
}
?>