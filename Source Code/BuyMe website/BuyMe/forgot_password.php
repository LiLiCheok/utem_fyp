<?php

try {

	include_once 'db_conn.php';
	
	$email = $_POST['email_link'];
	
	$query = "SELECT * FROM user WHERE user_email = '$email'";
	
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$count_row = $stmt->rowCount();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if($count_row!=0) {
		
		foreach($result as $row) {
			
			$db_email = $row['user_email'];
		}
		
		if($email == $db_email) {
		
			$code = rand(10000, 1000000);
			$to = $db_email;
			$subject = "Password Reset from BuyMe";
			$pwrurl = "http://localhost:82/BuyMe/reset_password.php?code=$code&user_email=$email";
			$body = "Dear user,\n\nThis is an automated email. Please Do Not reply to this email as you will not receive a response.\n\nIf this e-mail does not apply to you please ignore it. It appears that you have requested a password reset at our website http://localhost:82/BuyMe/\n\nTo reset your password, please click the link below. If you cannot click it, please paste it into your web browser's address bar.\n\n" . $pwrurl . "\n\nThanks,\nThe Administration";
		
			$query1 = ("UPDATE user SET reset_code='$code' WHERE user_email='$email'");
			$stmt = $conn->prepare($query1);
			$stmt->execute();
			
			// send email
			mail($to, $subject, $body);
		}
		
		echo "register_email";
		
	} else {
		
		echo "non_register_email";
	}
	
} catch(PDOException $e) {

	echo "Error: " . $e->getMessage();
}

?>