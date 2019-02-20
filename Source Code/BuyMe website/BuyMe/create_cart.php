<?php

try {

	include_once 'db_conn.php';
		
	$user_id = $_POST['user_id'];
	$product_id = $_POST['product_id'];
	$quantity = $_POST['quantity'];
	
	// Create a new cart id
	$query = "SELECT * FROM cart";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$row = $stmt->rowCount();
	$cart_id = 'C'.sprintf("%019s", $row+1);
	
	// Select product price
	$query2 = "SELECT product_price FROM product WHERE product_id='$product_id'";
	$stmt2 = $conn->prepare($query2);
	$stmt2->execute();
	$result = $stmt2->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$product_price=$row['product_price'];
	}
	$subtotal = $quantity * $product_price;
	
	// Get del_charge
	$query_dcc = "SELECT shop_id FROM product p WHERE product_id='$product_id'";
	$stmt_dcc = $conn->prepare($query_dcc);
	$stmt_dcc->execute();
	$result_dcc = $stmt_dcc->fetchAll(PDO::FETCH_ASSOC);
	foreach($result_dcc as $row_dcc) {
		$shop_id = $row_dcc['shop_id'];
	}
	$query_dc1 = "SELECT c.del_charge FROM product p, cart c, shop s WHERE c.product_id=p.product_id AND p.shop_id=s.shop_id AND p.shop_id='$shop_id' AND c.status='$user_id' GROUP BY c.del_charge";
	$stmt_dc1 = $conn->prepare($query_dc1);
	$stmt_dc1->execute();
	$row_dc1 = $stmt_dc1->rowCount();
	
	// Check whether the user have add the product
	$check_exist = "SELECT product_id FROM cart WHERE status='$user_id' AND product_id='$product_id'";
	$check_stmt = $conn->prepare($check_exist);
	$check_stmt->execute();
	$row_check = $check_stmt->rowCount();
	if($row_check!=0) {
		$result_check = $check_stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result_check as $row) {
			$p_id = $row['product_id'];
			if($p_id==$product_id) {
				echo "exist";
			}
		}
	} else {
		// Check if any null column of the deleted cart (for reusing the column purpose)
		$cc_exist = "SELECT * FROM cart WHERE quantity=0 AND subtotal=0.00 AND status='' AND product_id='$product_id'";
		$stmt_cc_exist = $conn->prepare($cc_exist);
		$stmt_cc_exist->execute();
		$row_cc_exist = $stmt_cc_exist->rowCount();
		
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
							// Update the exist cart (reuse the deleted cart)
							$query = "UPDATE cart SET quantity='$quantity', subtotal='$subtotal', del_charge=NULL, status='$user_id' WHERE cart_id='$cart_id_exist'";
							$stmt = $conn->prepare($query);
							$stmt->execute();
							echo "added";
						} else {
							// Update the exist cart (reuse the deleted cart)
							$query = "UPDATE cart SET quantity='$quantity', subtotal='$subtotal', del_charge='$del_charge', status='$user_id' WHERE cart_id='$cart_id_exist'";
							$stmt = $conn->prepare($query);
							$stmt->execute();
							echo "added";
						}						
					} else {
						$query = "UPDATE cart SET quantity='$quantity', subtotal='$subtotal', status='$user_id' WHERE cart_id='$cart_id_exist'";
						$stmt = $conn->prepare($query);
						$stmt->execute();
						echo "added";
					}
				}
			}
		} else {
			if($row_dc1!=0) {
				$result_dc1 = $stmt_dc1->fetchAll(PDO::FETCH_ASSOC);
				foreach($result_dc1 as $r) {
					$del_charge = $r['del_charge'];
				}
				if($del_charge==NULL||$del_charge=="") {
					$query1 = "INSERT INTO cart (cart_id, product_id, quantity, subtotal, del_charge, status) VALUES ('$cart_id', '$product_id', '$quantity', '$subtotal', NULL, '$user_id')";
					$stmt1 = $conn->prepare($query1);
					$stmt1->execute();
					echo "added";
				} else {
					$query1 = "INSERT INTO cart (cart_id, product_id, quantity, subtotal, del_charge, status) VALUES ('$cart_id', '$product_id', '$quantity', '$subtotal', '$del_charge', '$user_id')";
					$stmt1 = $conn->prepare($query1);
					$stmt1->execute();
					echo "added";
				}						
			} else {
				$query1 = "INSERT INTO cart (cart_id, product_id, quantity, subtotal, status) VALUES ('$cart_id', '$product_id', '$quantity', '$subtotal', '$user_id')";
				$stmt1 = $conn->prepare($query1);
				$stmt1->execute();
				echo "added";
			}
		}
	}		
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>