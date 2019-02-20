<?php

include '../db_conn.php';

if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnUserLogin" ) {
	
	try {
		
		$user_email = $_REQUEST["user_email"];
		$user_password = $_REQUEST["user_password"];
		
		$sql = "SELECT * FROM user WHERE user_email='$user_email' AND user_password='$user_password'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$row_count = $stmt->rowCount();
		
		foreach($result as $row) {
			$user_id = $row['user_id'];
			$user_email = $row['user_email'];
			$user_password = $row['user_password'];
			$user_name = $row['user_name'];
			$user_role = $row['user_role'];
		}
		
		if($row_count!=0) {
			
			if($user_role=="user") {
				$msg = array("match"=>"match", "user_id"=>$user_id, "user_email"=>$user_email, "user_name"=>$user_name);
			} else {
				$msg = array("seller"=>"seller");
			}
			
		} else {
			$msg = array("not_match"=>"not_match");
		}
		
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnUserRegister" ) {
	
	try {
		
		$user_name = $_REQUEST["user_name"];
		$ic_no = $_REQUEST["ic_no"];
		$contact_no = $_REQUEST["contact_no"];
		$user_email = $_REQUEST["user_email"];
		$user_password = $_REQUEST["user_password"];
		
		$sql = "SELECT * FROM user WHERE user_email='$user_email'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$row_count = $stmt->rowCount();
		if($row_count!=0) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$exist_email = $row['user_email'];
			}
			if($user_email==$exist_email) {
				$msg = array("exist"=>"exist");
			} else {
				$sql_1 = "SELECT COUNT(user_id) as num_user FROM user";
				$stmt_1 = $conn->prepare($sql_1);
				$stmt_1->execute();
				$result_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);
				foreach($result_1 as $row_1) {
					$old_uid = $row_1['num_user'];
				}
				$user_id = 'U'.sprintf("%09s", $old_uid+1);
				
				$sql_2 = "INSERT INTO user (user_id, user_email, user_name, user_password, ic_no, contact_no, user_role, create_at) VALUES ('$user_id', '$user_email', '$user_name', '$user_password', '$ic_no', '$contact_no', 'user', CURRENT_TIMESTAMP)";
				$stmt_2 = $conn->prepare($sql_2);
				$stmt_2->execute();
				
				$msg = array("created"=>"created");
			}
		} else {
			$sql_1 = "SELECT COUNT(user_id)as num_user FROM user";
			$stmt_1 = $conn->prepare($sql_1);
			$stmt_1->execute();
			$result_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);
			foreach($result_1 as $row_1) {
				$old_uid = $row_1['num_user'];
			}
			$user_id = 'U'.sprintf("%09s", $old_uid+1);
			
			$sql_2 = "INSERT INTO user (user_id, user_email, user_name, user_password, ic_no, contact_no, user_role, create_at) VALUES ('$user_id', '$user_email', '$user_name', '$user_password', '$ic_no', '$contact_no', 'user', CURRENT_TIMESTAMP)";
			$stmt_2 = $conn->prepare($sql_2);
			$stmt_2->execute();
			
			$msg = array("created"=>"created");
		}
		
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnForgotPassword" ) {
	
	try{
		
		$user_email = $_REQUEST["user_email"];
		
		$sql = "SELECT * FROM user WHERE user_email='$user_email'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$row_count = $stmt->rowCount();
		
		if($row_count!=0) {
			foreach($result as $row) {
				$db_email = $row['user_email'];
			}
			
			if($user_email == $db_email) {
			
				$code = rand(10000, 1000000);
				$to = $db_email;
				$subject = "Password Reset from BuyMe";
				$pwrurl = "http://localhost:82/BuyMe/reset_password.php?code=$code&user_email=$user_email";
				$body = "Dear user,\n\nThis is an automated email. Please Do Not reply to this email as you will not receive a response.\n\nIf this e-mail does not apply to you please ignore it. It appears that you have requested a password reset at our website http://localhost:82/BuyMe/\n\nTo reset your password, please click the link below. If you cannot click it, please paste it into your web browser's address bar.\n\n" . $pwrurl . "\n\nThanks,\nThe Administration";
			
				$query1 = ("UPDATE user SET reset_code='$code' WHERE user_email='$user_email'");
				$stmt = $conn->prepare($query1);
				$stmt->execute();
				
				// send email
				mail($to, $subject, $body);
			}
			
			$msg = array("sent"=>"sent");
			
		} else {
			
			$msg = array("no"=>"no");
		}
		
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnGetCategory" ) {

	try {
		
		$status = $_REQUEST["status"];
		
		$sql = "SELECT * FROM category WHERE status=:status";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(":status", $status);
		$stmt->execute();
		$recordSetObj = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		echo "{'data':".json_encode($recordSetObj)."}";
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnGetProduct" ) {

	try {
		
		$category_name = $_REQUEST["category_name"];
		$sql = "SELECT * FROM category WHERE category_name=:category_name";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(":category_name", $category_name);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$category_id = $row['category_id'];
		}
		
		if($category_id=="CTG000") {
			$sql_1 = "SELECT p.*, s.* FROM product p, shop s WHERE p.shop_id = s.shop_id AND p.product_status='active' ORDER BY p.post_at DESC, p.product_id DESC";
			$stmt_1 = $conn->prepare($sql_1);
			$stmt_1->execute();
			$recordSetObj = $stmt_1->fetchAll(PDO::FETCH_OBJ);
			echo "{'data':".json_encode($recordSetObj)."}";
		} else {
			$sql_1 = "SELECT p.*, s.* FROM product p, shop s WHERE p.shop_id = s.shop_id AND p.product_status='active' AND p.category_id=:category_id ORDER BY p.post_at DESC, p.product_id DESC";
			$stmt_1 = $conn->prepare($sql_1);
			$stmt_1->bindParam(":category_id", $category_id);
			$stmt_1->execute();
			$recordSetObj = $stmt_1->fetchAll(PDO::FETCH_OBJ);
			echo "{'data':".json_encode($recordSetObj)."}";
			
		}
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnGetSpecificProduct" ) {

	try {
		
		$product_id = $_REQUEST["product_id"];
		
		$query1 = "SELECT DISTINCT p.*, s.* FROM product p, shop s WHERE p.shop_id = s.shop_id AND p.product_status='active' and p.product_id=:product_id";
		$stmt1 = $conn->prepare($query1);
		$stmt1->bindParam(":product_id", $product_id);
		$stmt1->execute();
		$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
		foreach($result1 as $row) {
			$shop_location = $row['shop_location'];
		}
		
		if($shop_location==null) {
			$query = "SELECT p.*, s.*, c.*, u.*, a.* FROM product p, shop s, category c, user u, address a WHERE p.shop_id = s.shop_id AND p.category_id=c.category_id AND s.user_id=u.user_id AND u.user_id=a.user_id AND p.product_status='active' AND p.product_id=:product_id";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(":product_id", $product_id);
			$stmt->execute();
			$count_row = $stmt->rowCount();
			$recordSetObj = $stmt->fetchAll(PDO::FETCH_OBJ);
			
			if($count_row!=0) {
				
				echo "{'data':".json_encode($recordSetObj)."}";
				
			} else if($count_row==0){
				$result=array("no_product"=>"no_product");
				echo "{'data':".json_encode($result)."}";
			}
		} else {
			$query = "SELECT p.*, s.*, c.*, u.* FROM product p, shop s, category c, user u WHERE p.shop_id = s.shop_id AND p.category_id=c.category_id AND s.user_id=u.user_id AND p.product_status='active' AND p.product_id=:product_id";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(":product_id", $product_id);
			$stmt->execute();
			$count_row = $stmt->rowCount();
			$recordSetObj = $stmt->fetchAll(PDO::FETCH_OBJ);
			
			if($count_row!=0) {
				
				echo "{'data':".json_encode($recordSetObj)."}";
				
			} else if($count_row==0){
				$result=array("no_product"=>"no_product");
				echo "{'data':".json_encode($result)."}";
			}
		}
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnGetUserProfile" ) {

	try{
		
		$user_id = $_REQUEST['user_id'];
	
		$query = "SELECT * FROM address WHERE user_id = :user_id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":user_id", $user_id);
		$stmt->execute();
		$count = $stmt->rowCount();
		if($count!=0) {
			$query = "SELECT u.*, a.* FROM user u, address a WHERE u.user_id = a.user_id AND u.user_id = :user_id";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(":user_id", $user_id);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo "{'data':".json_encode($result)."}";

		} else {
			$query = "SELECT * FROM user WHERE user_id = :user_id";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(":user_id", $user_id);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($result as $row) {
				$ic_no = $row['ic_no'];
				$contact_no = $row['contact_no'];
				$user_email = $row['user_email'];
				$user_password = $row['user_password'];
				$user_name = $row['user_name'];
			}
			$msg = array("user_name"=>$user_name, "user_email"=>$user_email, "user_password"=>$user_password, "contact_no"=>$contact_no, "ic_no"=>$ic_no,
			"address"=>"", "postcode"=>"", "city"=>"", "state"=>"Melaka");
			echo "{'data':[".json_encode($msg)."]}";
		}
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}

} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnUpdateUserProfile" ) {

	try{
		
		$user_id = $_REQUEST['user_id'];
		$user_name = $_REQUEST["user_name"];
		$ic_no = $_REQUEST["ic_no"];
		$contact_no = $_REQUEST["contact_no"];
		$address = $_REQUEST['address'];
		$postcode = $_REQUEST['postcode'];
		$city = $_REQUEST['city'];
		$state = $_REQUEST['state'];
		
		$query_2 = "SELECT * FROM address";
		$stmt_2 = $conn->prepare($query_2);
		$stmt_2->execute();
		$count_2 = $stmt_2->rowCount();
		$address_id = 'A' . sprintf('%09s', $count_2+1);
		
		$query = "SELECT * FROM address WHERE user_id = :user_id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":user_id", $user_id);
		$stmt->execute();
		$count = $stmt->rowCount();
		if($count!=0) {
			$query = "UPDATE address SET address='$address', postcode='$postcode', city='$city', state='$state' WHERE user_id=:user_id";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(":user_id", $user_id);
			$stmt->execute();
			
			$query_1 = "UPDATE user SET user_name='$user_name', ic_no='$ic_no', contact_no='$contact_no' WHERE user_id=:user_id";
			$stmt_1 = $conn->prepare($query_1);
			$stmt_1->bindParam(":user_id", $user_id);
			$stmt_1->execute();
			
			$msg = array("updated"=>"updated");
		} else {
			$query = "INSERT INTO address (address_id, address, postcode, city, state, user_id) VALUES ('$address_id', '$address', '$postcode', '$city', '$state', '$user_id')";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			
			$query_1 = "UPDATE user SET user_name='$user_name', ic_no='$ic_no', contact_no='$contact_no' WHERE user_id=:user_id";
			$stmt_1 = $conn->prepare($query_1);
			$stmt_1->bindParam(":user_id", $user_id);
			$stmt_1->execute();
			
			$msg = array("updated"=>"updated");
		}
		
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnUpdateUserEmail" ) {
	
	try {
		
		$user_id = $_REQUEST['user_id'];
		$new_email = $_REQUEST["user_email"];
		
		$query = "SELECT * FROM user WHERE user_email=:new_email";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":new_email", $new_email);
		$stmt->execute();
		$row_count = $stmt->rowCount();
		if($row_count!=0) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $row) {
				$user_email = $row['user_email'];
			}
			if($new_email==$user_email) {
				$msg = array("exist"=>"exist");
			} else {
				$query = "UPDATE user SET user_email='$new_email' WHERE user_id = :user_id";
				$stmt = $conn->prepare($query);
				$stmt->bindParam(":user_id", $user_id);
				$stmt->execute();
				$msg = array("updated"=>"updated");
			}
		} else {
			$query = "UPDATE user SET user_email='$new_email' WHERE user_id = :user_id";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(":user_id", $user_id);
			$stmt->execute();
			$msg = array("updated"=>"updated");
		}

		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
}  else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnUpdateUserPassword" ) {
	
	try {
		
		$user_id = $_REQUEST['user_id'];
		$old_password = $_REQUEST["old_password"];
		$new_password = $_REQUEST["new_password"];
		
		$query = "SELECT * FROM user WHERE user_id = :user_id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":user_id", $user_id);
		$stmt->execute();
		$row_count = $stmt->rowCount();
		if($row_count!=0) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $row) {
				$user_password = $row['user_password'];
			}
			if($old_password==$user_password) {
				$query = "UPDATE user SET user_password='$new_password' WHERE user_id = :user_id";
				$stmt = $conn->prepare($query);
				$stmt->bindParam(":user_id", $user_id);
				$stmt->execute();
				$msg = array("updated"=>"updated");
			} else {
				$msg = array("incorrect"=>"incorrect");
			}
		} else {}
		
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnCheckCart" ) {
	
	try {
		
		$user_id = $_REQUEST["user_id"];
		$product_id = $_REQUEST["product_id"];
		
		// Check Cart
		$query = "SELECT product_id FROM cart WHERE status = :user_id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":user_id", $user_id);
		$stmt->execute();
		$row_count = $stmt->rowCount();
		if($row_count!=0) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $row) {
				$pid = $row['product_id'];
				if($pid==$product_id) {
					$msg = array("exist"=>"exist");
					echo json_encode($msg);
				}
			}
			if($pid!=$product_id) {
				$msg = array("not_exist"=>"not_exist");
				echo json_encode($msg);
			} else {}
		} else {
			$msg = array("not_exist"=>"not_exist");
			echo json_encode($msg);
		}
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnAddToCart" ) {
	
	try {
		
		$user_id = $_REQUEST["user_id"];
		$product_id = $_REQUEST["product_id"];
		$product_price = $_REQUEST["product_price"];
		
		$quantity=0;
		$subtotal=0.00;
		$status="";
		
		// Check if any null column of the deleted cart (for reusing the column purpose)
		$cc_exist = "SELECT * FROM cart WHERE quantity=:quantity AND subtotal=:subtotal AND status=:status";
		$stmt_cc_exist = $conn->prepare($cc_exist);
		$stmt_cc_exist->bindParam(":quantity", $quantity);
		$stmt_cc_exist->bindParam(":subtotal", $subtotal);
		$stmt_cc_exist->bindParam(":status", $status);
		$stmt_cc_exist->execute();
		$row_cc_exist = $stmt_cc_exist->rowCount();
		
		// Get del_charge
		$query_dc = "SELECT shop_id FROM product p WHERE product_id=:product_id";
		$stmt_dc = $conn->prepare($query_dc);
		$stmt_dc->bindParam(":product_id", $product_id);
		$stmt_dc->execute();
		$result_dc = $stmt_dc->fetchAll(PDO::FETCH_ASSOC);
		foreach($result_dc as $row_dc) {
			$shop_id = $row_dc['shop_id'];
		}
		$query_dc1 = "SELECT c.del_charge FROM product p, cart c, shop s WHERE c.product_id=p.product_id AND p.shop_id=s.shop_id AND p.shop_id=:shop_id AND c.status=:user_id GROUP BY c.del_charge";
		$stmt_dc1 = $conn->prepare($query_dc1);
		$stmt_dc1->bindParam(":shop_id", $shop_id);
		$stmt_dc1->bindParam(":user_id", $user_id);
		$stmt_dc1->execute();
		$row_dc1 = $stmt_dc1->rowCount();
		
		if($row_cc_exist!=0) {
			
			$result_cc_exist = $stmt_cc_exist->fetchAll(PDO::FETCH_ASSOC);
			foreach($result_cc_exist as $row_cc_exist) {
				$cart_id_exist = $row_cc_exist['cart_id'];
				$product_id_exist = $row_cc_exist['product_id'];
				
				if($product_id_exist==$product_id) {
					if($row_dc1!=0) {
						$result_dc1 = $stmt_dc1->fetchAll(PDO::FETCH_ASSOC);
						foreach($result_dc1 as $r) {
							$del_charge = $r['del_charge'];
						}
						if($del_charge==NULL||$del_charge=="") {
							$query = "UPDATE cart SET quantity='1', subtotal='$product_price', del_charge=NULL, status='$user_id' WHERE cart_id=:cart_id_exist";
							$stmt = $conn->prepare($query);
							$stmt->bindParam(":cart_id_exist", $cart_id_exist);
							$stmt->execute();
							$msg = array("added"=>"added");
						} else {
							$query = "UPDATE cart SET quantity='1', subtotal='$product_price', del_charge='$del_charge', status='$user_id' WHERE cart_id=:cart_id_exist";
							$stmt = $conn->prepare($query);
							$stmt->bindParam(":cart_id_exist", $cart_id_exist);
							$stmt->execute();
							$msg = array("added"=>"added");
						}
					} else {
						$query = "UPDATE cart SET quantity='1', subtotal='$product_price', status='$user_id' WHERE cart_id=:cart_id_exist";
						$stmt = $conn->prepare($query);
						$stmt->bindParam(":cart_id_exist", $cart_id_exist);
						$stmt->execute();
						$msg = array("added"=>"added");
					}
					echo json_encode($msg);					
				}
			}
			if($product_id_exist!=$product_id) {
				$msg = array("again"=>"again");
				echo json_encode($msg);
			} else {}
		} else {
			$msg = array("again"=>"again");
			echo json_encode($msg);
		}
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnAddToCartAgain" ) {
	
	try {
		
		$user_id = $_REQUEST["user_id"];
		$product_id = $_REQUEST["product_id"];
		$product_price = $_REQUEST["product_price"];
		
		$query_1 = "SELECT COUNT(*) as num_cart FROM cart";
		$stmt_1 = $conn->prepare($query_1);
		$stmt_1->execute();
		$result_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result_1 as $row_1) {
			$cid = $row_1['num_cart'];
		}
		$cart_id = 'C' . sprintf('%019s', $cid+1);
		
		// Get del_charge
		$query_dc = "SELECT shop_id FROM product p WHERE product_id=:product_id";
		$stmt_dc = $conn->prepare($query_dc);
		$stmt_dc->bindParam(":product_id", $product_id);
		$stmt_dc->execute();
		$result_dc = $stmt_dc->fetchAll(PDO::FETCH_ASSOC);
		foreach($result_dc as $row_dc) {
			$shop_id = $row_dc['shop_id'];
		}
		$query_dc1 = "SELECT c.del_charge FROM product p, cart c, shop s WHERE c.product_id=p.product_id AND p.shop_id=s.shop_id AND p.shop_id=:shop_id AND c.status=:user_id GROUP BY c.del_charge";
		$stmt_dc1 = $conn->prepare($query_dc1);
		$stmt_dc1->bindParam(":shop_id", $shop_id);
		$stmt_dc1->bindParam(":user_id", $user_id);
		$stmt_dc1->execute();
		$row_dc1 = $stmt_dc1->rowCount();
		
		if($row_dc1!=0) {
			$result_dc1 = $stmt_dc1->fetchAll(PDO::FETCH_ASSOC);
			foreach($result_dc1 as $r) {
				$del_charge = $r['del_charge'];
			}
			if($del_charge==NULL||$del_charge=="") {
				$query = "INSERT INTO cart (cart_id, product_id, quantity, subtotal, del_charge, status) VALUES ('$cart_id', '$product_id', '1', '$product_price', NULL, '$user_id')";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$msg = array("added"=>"added");
			} else {
				$query = "INSERT INTO cart (cart_id, product_id, quantity, subtotal, del_charge, status) VALUES ('$cart_id', '$product_id', '1', '$product_price', '$del_charge', '$user_id')";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$msg = array("added"=>"added");
			}
		} else {
			$query = "INSERT INTO cart (cart_id, product_id, quantity, subtotal, status) VALUES ('$cart_id', '$product_id', '1', '$product_price', '$user_id')";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			$msg = array("added"=>"added");
		}
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnGetCart" ) {
	
	try{
		
		$user_id = $_POST['user_id'];
	
		$query = "SELECT c.*, p.product_id, p.product_name, p.product_price, p.product_image, s.shop_id, s.shop_name, s.delivery_service, s.delivery_info from product p, cart c, shop s WHERE p.product_id = c.product_id AND status=:user_id AND p.shop_id = s.shop_id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":user_id", $user_id);
		$stmt->execute();
		$recordSetObj = $stmt->fetchAll(PDO::FETCH_OBJ);
		echo "{'data':".json_encode($recordSetObj)."}";
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnGetCartOrderNo" ) {
	
	try{
		
		$user_id = $_POST['user_id'];
	
		$query = "SELECT (SELECT COUNT(*) FROM orders WHERE user_id =:user_id) AS num_order, (SELECT COUNT(*) FROM cart WHERE status =:user_id) AS num_cart";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":user_id", $user_id);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$num_cart = $row['num_cart'];
			$num_order = $row['num_order'];
		}
		$msg = array("num_cart"=>$num_cart, "num_order"=>$num_order);
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnDeleteCart" ) {
	
	try {
		
		$user_id = $_POST['user_id'];
		$product_id = $_POST['product_id'];
		$shop_id = $_POST['shop_id'];
		$shop_item = $_POST['shop_item'];
		
		$query = "UPDATE cart SET quantity='', subtotal='', del_charge=NULL, status='' WHERE product_id=:product_id AND status=:user_id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":user_id", $user_id);
		$stmt->bindParam(":product_id", $product_id);
		$stmt->execute();
		
		$query1 = "SELECT SUM(c.subtotal) as total FROM cart c, product p, shop s WHERE p.shop_id = s.shop_id AND c.product_id=p.product_id AND p.shop_id = :shop_id AND status=:user_id";
		$stmt1 = $conn->prepare($query1);
		$stmt1->bindParam(":user_id", $user_id);
		$stmt1->bindParam(":shop_id", $shop_id);
		$stmt1->execute();
		$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
		foreach($result1 as $row1) {
			$del_qty = $row1['total'];
		}
		if($shop_item!="") {
			if($shop_item<=$del_qty) {
				
			} else {
				$q = "SELECT c.* FROM cart c, product p, shop s WHERE c.status=:user_id AND c.product_id=p.product_id AND p.shop_id=s.shop_id AND s.shop_id=:shop_id";
				$s = $conn->prepare($q);
				$s->bindParam(":user_id", $user_id);
				$s->bindParam(":shop_id", $shop_id);
				$s->execute();
				$r=$s->fetchAll(PDO::FETCH_ASSOC);
				foreach($r as $row) {
					$cart_id=$row['cart_id'];
					$query = "UPDATE cart SET del_charge=NULL WHERE cart_id=:cart_id";
					$stmt = $conn->prepare($query);
					$stmt->bindParam(":cart_id", $cart_id);
					$stmt->execute();
				}
			}
		} else {}
		
		$msg=array("result"=>"deleted");
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnGetOrder" ) {
	
	try{
		
		$user_id = $_POST['user_id'];
	
		$query = "SELECT * FROM orders WHERE user_id =:user_id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":user_id", $user_id);
		$stmt->execute();
		$recordSetObj = $stmt->fetchAll(PDO::FETCH_OBJ);
		echo "{'data':".json_encode($recordSetObj)."}";
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnSetOrderStatus" ) {
	
	try{
		
		$order_id = $_POST['order_id'];
	
		$query = "select * from cart where status='' AND order_id=:order_id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":order_id", $order_id);
		$stmt->execute();
		$row = $stmt->rowCount();
		if($row!=0) {
			$msg=array("order_status"=>"not_settle");
		} else {
			$msg=array("order_status"=>"settle");
		}
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnOrderFrom" ) {
	
	try{
		
		$user_id = $_REQUEST['user_id'];
		$order_id = $_REQUEST['order_id'];
		
		$query = "SELECT s.shop_name FROM orders o, cart c, product p, shop s WHERE o.order_id = c.order_id AND c.product_id = p.product_id AND p.shop_id = s.shop_id AND o.user_id = :user_id AND o.order_id = :order_id GROUP BY s.shop_name ORDER BY c.cart_id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":user_id", $user_id);
		$stmt->bindParam(":order_id", $order_id);
		$stmt->execute();
		$recordSetObj = $stmt->fetchAll(PDO::FETCH_OBJ);
		echo "{'data':".json_encode($recordSetObj)."}";
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if(isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnGetTotalOrderFromShop") {
	
	try {
		
		$user_id = $_POST['user_id'];
		$shop_id = $_POST['shop_id'];
		
		$query = "SELECT SUM(c.subtotal) as total_order FROM cart c, product p, shop s WHERE p.shop_id = s.shop_id AND c.product_id=p.product_id AND p.shop_id = :shop_id AND status=:user_id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":user_id", $user_id);
		$stmt->bindParam(":shop_id", $shop_id);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($result as $row) {
			$total_order = $row['total_order'];
		}
		$msg = array("total_order"=>$total_order);
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
}  else if(isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnUpdateQuantity") {
	
	try {
		
		$cart_id = $_POST['cart_id'];
		$product_id = $_POST['product_id'];
		$product_price = $_POST['product_price'];
		$quantity = $_POST['quantity'];
		
		$subtotal = $product_price*$quantity;
		
		$query = "UPDATE cart SET quantity='$quantity', subtotal='$subtotal' WHERE product_id=:product_id AND cart_id=:cart_id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":product_id", $product_id);
		$stmt->bindParam(":cart_id", $cart_id);
		$stmt->execute();
		
		$msg = array("result"=>"ordered", "quantity"=>$quantity, "subtotal"=>$subtotal);
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if(isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnUpdateCart") {
	
	try {
		
		$cart_id = $_POST['cart_id'];
		$quantity = $_POST['quantity'];
		$subtotal = $_POST['subtotal'];
		$del_charge = $_POST['del_charge'];
		
		$shop_id = $_POST['shop_id'];
		$user_id = $_POST['user_id'];
		
		if($del_charge=="") {
			$query = "UPDATE cart SET quantity='$quantity', subtotal='$subtotal', del_charge=NULL WHERE cart_id=:cart_id";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(":cart_id", $cart_id);
			$stmt->execute();
			$q = "SELECT c.* FROM cart c, product p, shop s WHERE c.status=:user_id AND c.product_id=p.product_id AND p.shop_id=s.shop_id AND s.shop_id=:shop_id";
			$s = $conn->prepare($q);
			$s->bindParam(":user_id", $user_id);
			$s->bindParam(":shop_id", $shop_id);
			$s->execute();
			$r=$s->fetchAll(PDO::FETCH_ASSOC);
			foreach($r as $row) {
				$cart_id=$row['cart_id'];
				$query = "UPDATE cart SET del_charge=NULL WHERE cart_id=:cart_id";
				$stmt = $conn->prepare($query);
				$stmt->bindParam(":cart_id", $cart_id);
				$stmt->execute();
			}
		} else {
			$query = "UPDATE cart SET quantity='$quantity', subtotal='$subtotal', del_charge='$del_charge' WHERE cart_id=:cart_id";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(":cart_id", $cart_id);
			$stmt->execute();
			$q = "SELECT c.* FROM cart c, product p, shop s WHERE c.status=:user_id AND c.product_id=p.product_id AND p.shop_id=s.shop_id AND s.shop_id=:shop_id";
			$s = $conn->prepare($q);
			$s->bindParam(":user_id", $user_id);
			$s->bindParam(":shop_id", $shop_id);
			$s->execute();
			$r=$s->fetchAll(PDO::FETCH_ASSOC);
			foreach($r as $row) {
				$cart_id=$row['cart_id'];
				$query = "UPDATE cart SET del_charge='$del_charge' WHERE cart_id=:cart_id";
				$stmt = $conn->prepare($query);
				$stmt->bindParam(":cart_id", $cart_id);
				$stmt->execute();
			}
		}
		
		$msg=array("result"=>"updated");
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnUpdateAddress" ) {

	try{
		
		$user_id = $_REQUEST['user_id'];
		$address = $_REQUEST['address'];
		$postcode = $_REQUEST['postcode'];
		$city = $_REQUEST['city'];
		$state = $_REQUEST['state'];
		
		$query_2 = "SELECT * FROM address";
		$stmt_2 = $conn->prepare($query_2);
		$stmt_2->execute();
		$count_2 = $stmt_2->rowCount();
		$address_id = 'A' . sprintf('%09s', $count_2+1);
		
		$query = "INSERT INTO address (address_id, address, postcode, city, state, user_id) VALUES ('$address_id', '$address', '$postcode', '$city', '$state', '$user_id')";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		$msg = array("updated"=>"updated");
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnCheckAddress" ) {

	try{
		
		$user_id = $_REQUEST['user_id'];
		
		$query_2 = "SELECT * FROM address WHERE user_id=:user_id";
		$stmt_2 = $conn->prepare($query_2);
		$stmt_2->bindParam(":user_id", $user_id);
		$stmt_2->execute();
		$count_2 = $stmt_2->rowCount();
		
		if($count_2!=0) {
			$msg = array("yes"=>"yes");
		} else {
			$msg = array("no"=>"no");
		}
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnCreateOrder" ) {

	try{
		
		$user_id = $_REQUEST['user_id'];
		$order_total = $_REQUEST['order_total'];
		
		// Create order id
		$query = "SELECT * FROM orders";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$row = $stmt->rowCount();
		$order_id = 'OD'.sprintf("%018s", $row+1);
		
		$query1 = "INSERT INTO orders (order_id, order_time, order_total, order_status, user_id) VALUE ('$order_id', CURRENT_TIMESTAMP, '$order_total', 'sent', '$user_id')";
		$stmt1 = $conn->prepare($query1);
		$stmt1->execute();
		
		$query2 = "UPDATE cart SET status='', order_id='$order_id' WHERE status=:user_id";
		$stmt2 = $conn->prepare($query2);
		$stmt2->bindParam(":user_id", $user_id);
		$stmt2->execute();
		
		$msg = array("sent"=>"sent");
		echo json_encode($msg);
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnGetCurrentCart" ) {
	
	try{
		
		$user_id = $_REQUEST['user_id'];
		
		$query = "SELECT c.*, p.product_name FROM cart c, product p, shop s WHERE c.product_id = p.product_id AND p.shop_id = s.shop_id AND c.status = :user_id ORDER BY c.cart_id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":user_id", $user_id);
		$stmt->execute();
		$recordSetObj = $stmt->fetchAll(PDO::FETCH_OBJ);
		echo "{'data':".json_encode($recordSetObj)."}";
		
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
} else if( isset($_REQUEST['fn']) && $_REQUEST['fn'] == "fnGetSpecificShop" ) {
	
	try{
		
		$user_id = $_REQUEST['user_id'];
		$order_id = $_REQUEST['order_id'];
		$shop_name = $_REQUEST['shop_name'];
		
		if ($shop_name=="-- Reviewing receipt according shop --") {
			$query = "SELECT c.*, p.product_name FROM orders o, cart c, product p, shop s WHERE o.order_id = c.order_id AND c.product_id = p.product_id AND p.shop_id = s.shop_id AND o.user_id = :user_id AND o.order_id = :order_id ORDER BY c.cart_id";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(":user_id", $user_id);
			$stmt->bindParam(":order_id", $order_id);
			$stmt->execute();
			$recordSetObj = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo "{'data':".json_encode($recordSetObj)."}";
		} else {
			$query = "SELECT c.*, p.product_name FROM orders o, cart c, product p, shop s WHERE o.order_id = c.order_id AND c.product_id = p.product_id AND p.shop_id = s.shop_id AND s.shop_name=:shop_name AND o.user_id = :user_id AND o.order_id = :order_id ORDER BY c.cart_id";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(":user_id", $user_id);
			$stmt->bindParam(":order_id", $order_id);
			$stmt->bindParam(":shop_name", $shop_name);
			$stmt->execute();
			$recordSetObj = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo "{'data':".json_encode($recordSetObj)."}";
		}
	} catch(PDOException $e) {
		
		$msg = array("error"=>$e->getMessage());
		echo json_encode($msg);
	}
	
}

?>