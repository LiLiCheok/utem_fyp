<?php

try {
	
	include_once '../db_conn.php';
	
	echo '<table class="tablestyle" style="margin-top:15px;">
		<tr>
			<th style="width: 250px;">Product Image</th>
			<th style="width: 500px;">Product Information</th>
			<th style="width: 100px;">Unblock?</th>
		</tr>';
	
	if(isset($_POST['search'])) {
		
		if(isset($_GET['page'])) {
			$page=$_GET['page'];
			if($page==""||$page==1) {
				$page1=0;
			} else {
				$page1=($page*4)-4;
			}
		
			$searchDate = mysql_real_escape_string($_POST['date_box']);
			
			$query = "SELECT DISTINCT p.*, s.*, u.user_id, u.user_name FROM product p, shop s, user u WHERE p.shop_id = s.shop_id AND s.user_id = u.user_id AND product_status='block' AND post_at = '$searchDate' LIMIT $page1, 4";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			
			$count_row = $stmt->rowCount();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if ($count_row != 0) {
				
				foreach($result as $row) {
					
					$location = $row['shop_location'];
					$business_hour_1 = $row['business_hour'];
					$check_day = substr($business_hour_1, 0, strpos($business_hour_1, '(,1)'));
					
					if($check_day=="Daily") {
						$monday = str_replace("(,1)", " ", $business_hour_1);
						$monday_start = str_replace("(-1)", " - ", $monday);
						$business_hour = str_replace("(.1)", "", $monday_start);
						
					} else {
						$monday = str_replace("(,1)", " ", $business_hour_1);
						$monday_start = str_replace("(-1)", " - ", $monday);
						$monday_end = str_replace("(.1)", nl2br("\\n"), $monday_start);
						$tuesday = str_replace("(,2)", " ", $monday_end);
						$tuesday_start = str_replace("(-2)", " - ", $tuesday);
						$tuesday_end = str_replace("(.2)", nl2br("\\n"), $tuesday_start);
						$wednesday = str_replace("(,3)", " ", $tuesday_end);
						$wednesday_start = str_replace("(-3)", " - ", $wednesday);
						$wednesday_end = str_replace("(.3)", nl2br("\\n"), $wednesday_start);
						$thursday = str_replace("(,4)", " ", $wednesday_end);
						$thursday_start = str_replace("(-4)", " - ", $thursday);
						$thursday_end = str_replace("(.4)", nl2br("\\n"), $thursday_start);
						$friday = str_replace("(,5)", " ", $thursday_end);
						$friday_start = str_replace("(-5)", " - ", $friday);
						$friday_end = str_replace("(.5)", nl2br("\\n"), $friday_start);
						$saturday = str_replace("(,6)", " ", $friday_end);
						$saturday_start = str_replace("(-6)", " - ", $saturday);
						$saturday_end = str_replace("(.6)", nl2br("\\n"), $saturday_start);
						$sunday = str_replace("(,7)", " ", $saturday_end);
						$sunday_start = str_replace("(-7)", " - ", $sunday);
						$business_hour = str_replace("(.7)", "", $sunday_start);
					}
					
					if($location!="") {
						echo "<tr>";
						echo "<td><img style='max-width:350px; max-height:400px;' src='".$row['product_image']."'/></td>";
						echo 
						"<td style='text-align:left;'>Product ID : ".$row['product_id']."<br>
						Product Name : ".$row['product_name']."<br>
						Product Description : ".$row['product_desc']."<br>
						Product Price : RM ".$row['product_price']."<br>
						Sell at : <a href='#shopform' data-toggle='modal' data-target='#shopform'
						onclick=\"javascript: $(document).ready(function(){
									$('.modal-body #shopimage').attr('src', '".$row['shop_image']."');
									$('.modal-body #shopid').val('".$row['ssm_no']."');
									$('.modal-body #shopname').val('".$row['shop_name']."');
									$('.modal-body #shopdesc').val('".$row['shop_desc']."');
									$('.modal-body #shopadd').val('".$row['shop_location']."');
									$('.modal-body #shopbusi').val('$business_hour');
									$('.modal-body #owner').val('".$row['user_name']."');
								});\">".$row['shop_name']."</a>
						</td>";
						echo "<td><a onClick=\"javascript: return confirm('Are you sure that you want to unblock this product?');\"
							href='unblockProduct.php?productID=".$row['product_id']."' >
							<img src='/BuyMe/image/unblock.png' /></a></td>";
						echo "</tr>";
						
					}  else {
						
						$query_1 = "SELECT * FROM address WHERE user_id = '".$row['user_id']."'";
						$stmt_1 = $conn->prepare($query_1);
						$stmt_1->execute();
						
						$result_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);
						foreach($result_1 as $row_1) {
							$shop_address = $row_1['address']." ".$row_1['postcode']." ".$row_1['city']." ".$row_1['state'];
						}
						
						echo "<tr>";
						echo "<td><img style='max-width:350px; max-height:400px;' src='".$row['product_image']."'/></td>";
						echo 
						"<td style='text-align:left;'>Product ID : ".$row['product_id']."<br>
						Product Name : ".$row['product_name']."<br>
						Product Description : ".$row['product_desc']."<br>
						Product Price : RM ".$row['product_price']."<br>
						Sell at : <a href='#shopform' data-toggle='modal' data-target='#shopform'
						onclick=\"javascript: $(document).ready(function(){
									$('.modal-body #shopimage').attr('src', '".$row['shop_image']."');
									$('.modal-body #shopid').val('".$row['ssm_no']."');
									$('.modal-body #shopname').val('".$row['shop_name']."');
									$('.modal-body #shopdesc').val('".$row['shop_desc']."');
									$('.modal-body #shopadd').val('$shop_address');
									$('.modal-body #shopbusi').val('$business_hour');
									$('.modal-body #owner').val('".$row['user_name']."');
								});\">".$row['shop_name']."</a>
						</td>";
						echo "<td><a onClick=\"javascript: return confirm('Are you sure that you want to unblock this product?');\"
							href='unblockProduct.php?productID=".$row['product_id']."' >
							<img src='/BuyMe/image/unblock.png' /></a></td>";
						echo "</tr>";
					}
				}
			
			} else if($count_row==0) {
				
				echo "<tr><td colspan='3'>
					<p></p>
					<label>No products are blocked on the selected date.</label>
					<p></p>
				  </td></tr>";
				
			}
			
			echo '</table>';
			
			$query1 = "SELECT DISTINCT p.*, s.*, u.user_id, u.user_name FROM product p, shop s, user u WHERE p.shop_id = s.shop_id AND s.user_id = u.user_id AND product_status='block' AND post_at = '$searchDate'";
			$stmt1 = $conn->prepare($query1);
			$stmt1->execute();
			$count_row1 = $stmt1->rowCount();
			$page = ceil($count_row1/4);
			echo '<nav style="float:right;margin-right:15px;">';
			echo '<ul class="pagination">';
			for($page_next=1;$page_next<=$page;$page_next++) {
				echo "<li class='page-item'><a class='page-link' href='block.php?page=$page_next'>$page_next</a></li>";
			}
			echo '</ul>';
			echo '</nav>';
		}		
		
	} else if (!isset($_POST['search'])){
		
		if(isset($_GET['page'])) {
			$page=$_GET['page'];
			if($page==""||$page==1) {
				$page1=0;
			} else {
				$page1=($page*4)-4;
			}
			
			$curr_date = date("Y-m-d");
			$query = "SELECT DISTINCT p.*, s.*, u.user_id, u.user_name FROM product p, shop s, user u  WHERE p.shop_id = s.shop_id AND s.user_id = u.user_id AND product_status='block' AND post_at = '$curr_date' LIMIT $page1, 4";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			
			$count_row = $stmt->rowCount();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if ($count_row != 0) {
				
				foreach($result as $row) {
					
					$location = $row['shop_location'];
					$business_hour_1 = $row['business_hour'];
					$check_day = substr($business_hour_1, 0, strpos($business_hour_1, '(,1)'));
					
					if($check_day=="Daily") {
						$monday = str_replace("(,1)", " ", $business_hour_1);
						$monday_start = str_replace("(-1)", " - ", $monday);
						$business_hour = str_replace("(.1)", "", $monday_start);
						
					} else {
						$monday = str_replace("(,1)", " ", $business_hour_1);
						$monday_start = str_replace("(-1)", " - ", $monday);
						$monday_end = str_replace("(.1)", nl2br("\\n"), $monday_start);
						$tuesday = str_replace("(,2)", " ", $monday_end);
						$tuesday_start = str_replace("(-2)", " - ", $tuesday);
						$tuesday_end = str_replace("(.2)", nl2br("\\n"), $tuesday_start);
						$wednesday = str_replace("(,3)", " ", $tuesday_end);
						$wednesday_start = str_replace("(-3)", " - ", $wednesday);
						$wednesday_end = str_replace("(.3)", nl2br("\\n"), $wednesday_start);
						$thursday = str_replace("(,4)", " ", $wednesday_end);
						$thursday_start = str_replace("(-4)", " - ", $thursday);
						$thursday_end = str_replace("(.4)", nl2br("\\n"), $thursday_start);
						$friday = str_replace("(,5)", " ", $thursday_end);
						$friday_start = str_replace("(-5)", " - ", $friday);
						$friday_end = str_replace("(.5)", nl2br("\\n"), $friday_start);
						$saturday = str_replace("(,6)", " ", $friday_end);
						$saturday_start = str_replace("(-6)", " - ", $saturday);
						$saturday_end = str_replace("(.6)", nl2br("\\n"), $saturday_start);
						$sunday = str_replace("(,7)", " ", $saturday_end);
						$sunday_start = str_replace("(-7)", " - ", $sunday);
						$business_hour = str_replace("(.7)", "", $sunday_start);
					}
					
					if($location!="") {
						echo "<tr>";
						echo "<td><img style='max-width:350px; max-height:400px;' src='".$row['product_image']."'/></td>";
						echo 
						"<td style='text-align:left;'>Product ID : ".$row['product_id']."<br>
						Product Name : ".$row['product_name']."<br>
						Product Description : ".$row['product_desc']."<br>
						Product Price : RM ".$row['product_price']."<br>
						Sell at : <a href='#shopform' data-toggle='modal' data-target='#shopform'
						onclick=\"javascript: $(document).ready(function(){
									$('.modal-body #shopimage').attr('src', '".$row['shop_image']."');
									$('.modal-body #shopid').val('".$row['ssm_no']."');
									$('.modal-body #shopname').val('".$row['shop_name']."');
									$('.modal-body #shopdesc').val('".$row['shop_desc']."');
									$('.modal-body #shopadd').val('".$row['shop_location']."');
									$('.modal-body #shopbusi').val('$business_hour');
									$('.modal-body #owner').val('".$row['user_name']."');
								});\">".$row['shop_name']."</a>
						</td>";
						echo "<td><a onClick=\"javascript: return confirm('Are you sure that you want to unblock this product?');\"
							href='unblockProduct.php?productID=".$row['product_id']."' >
							<img src='/BuyMe/image/unblock.png' /></a></td>";
						echo "</tr>";
						
					}  else {
						
						$query_1 = "SELECT * FROM address WHERE user_id = '".$row['user_id']."'";
						$stmt_1 = $conn->prepare($query_1);
						$stmt_1->execute();
						
						$result_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);
						foreach($result_1 as $row_1) {
							$shop_address = $row_1['address']." ".$row_1['postcode']." ".$row_1['city']." ".$row_1['state'];
						}
						
						echo "<tr>";
						echo "<td><img style='max-width:350px; max-height:400px;' src='".$row['product_image']."'/></td>";
						echo 
						"<td style='text-align:left;'>Product ID : ".$row['product_id']."<br>
						Product Name : ".$row['product_name']."<br>
						Product Description : ".$row['product_desc']."<br>
						Product Price : RM ".$row['product_price']."<br>
						Sell at : <a href='#shopform' data-toggle='modal' data-target='#shopform'
						onclick=\"javascript: $(document).ready(function(){
									$('.modal-body #shopimage').attr('src', '".$row['shop_image']."');
									$('.modal-body #shopid').val('".$row['ssm_no']."');
									$('.modal-body #shopname').val('".$row['shop_name']."');
									$('.modal-body #shopdesc').val('".$row['shop_desc']."');
									$('.modal-body #shopadd').val('$shop_address');
									$('.modal-body #shopbusi').val('$business_hour');
									$('.modal-body #owner').val('".$row['user_name']."');
								});\">".$row['shop_name']."</a>
						</td>";
						echo "<td><a onClick=\"javascript: return confirm('Are you sure that you want to unblock this product?');\"
							href='unblockProduct.php?productID=".$row['product_id']."' >
							<img src='/BuyMe/image/unblock.png' /></a></td>";
						echo "</tr>";
					}
				}
			
			} else if($count_row==0) {
				
					echo "<tr><td colspan='3'>
							<p></p>
							<label>No products are blocked today.</label>
							<p></p>
						  </td></tr>";
				
			}
			
			echo '</table>';
			
			$query1 = "SELECT DISTINCT p.*, s.*, u.user_id, u.user_name FROM product p, shop s, user u  WHERE p.shop_id = s.shop_id AND s.user_id = u.user_id AND product_status='block' AND post_at = '$curr_date'";
			$stmt1 = $conn->prepare($query1);
			$stmt1->execute();
			$count_row1 = $stmt1->rowCount();
			$page = ceil($count_row1/4);
			echo '<nav style="float:right;margin-right:15px;">';
			echo '<ul class="pagination">';
			for($page_next=1;$page_next<=$page;$page_next++) {
				echo "<li class='page-item'><a class='page-link' href='block.php?page=$page_next'>$page_next</a></li>";
			}
			echo '</ul>';
			echo '</nav>';
		}		
	} else {
		
		if(isset($_GET['page'])) {
			$page=$_GET['page'];
			if($page==""||$page==1) {
				$page1=0;
			} else {
				$page1=($page*4)-4;
			}
			
			$query = "SELECT DISTINCT p.*, s.*, u.user_id, u.user_name FROM product p, shop s, user u  WHERE p.shop_id = s.shop_id AND s.user_id = u.user_id AND product_status='block' LIMIT $page1, 4";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			
			$count_row = $stmt->rowCount();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if ($count_row != 0) {
				
				foreach($result as $row) {
					
					$location = $row['shop_location'];
					$business_hour_1 = $row['business_hour'];
					$check_day = substr($business_hour_1, 0, strpos($business_hour_1, '(,1)'));
					
					if($check_day=="Daily") {
						$monday = str_replace("(,1)", " ", $business_hour_1);
						$monday_start = str_replace("(-1)", " - ", $monday);
						$business_hour = str_replace("(.1)", "", $monday_start);
						
					} else {
						$monday = str_replace("(,1)", " ", $business_hour_1);
						$monday_start = str_replace("(-1)", " - ", $monday);
						$monday_end = str_replace("(.1)", nl2br("\\n"), $monday_start);
						$tuesday = str_replace("(,2)", " ", $monday_end);
						$tuesday_start = str_replace("(-2)", " - ", $tuesday);
						$tuesday_end = str_replace("(.2)", nl2br("\\n"), $tuesday_start);
						$wednesday = str_replace("(,3)", " ", $tuesday_end);
						$wednesday_start = str_replace("(-3)", " - ", $wednesday);
						$wednesday_end = str_replace("(.3)", nl2br("\\n"), $wednesday_start);
						$thursday = str_replace("(,4)", " ", $wednesday_end);
						$thursday_start = str_replace("(-4)", " - ", $thursday);
						$thursday_end = str_replace("(.4)", nl2br("\\n"), $thursday_start);
						$friday = str_replace("(,5)", " ", $thursday_end);
						$friday_start = str_replace("(-5)", " - ", $friday);
						$friday_end = str_replace("(.5)", nl2br("\\n"), $friday_start);
						$saturday = str_replace("(,6)", " ", $friday_end);
						$saturday_start = str_replace("(-6)", " - ", $saturday);
						$saturday_end = str_replace("(.6)", nl2br("\\n"), $saturday_start);
						$sunday = str_replace("(,7)", " ", $saturday_end);
						$sunday_start = str_replace("(-7)", " - ", $sunday);
						$business_hour = str_replace("(.7)", "", $sunday_start);
					}
					
					if($location!="") {
						echo "<tr>";
						echo "<td><img style='max-width:350px; max-height:400px;' src='".$row['product_image']."'/></td>";
						echo 
						"<td style='text-align:left;'>Product ID : ".$row['product_id']."<br>
						Product Name : ".$row['product_name']."<br>
						Product Description : ".$row['product_desc']."<br>
						Product Price : RM ".$row['product_price']."<br>
						Sell at : <a href='#shopform' data-toggle='modal' data-target='#shopform'
						onclick=\"javascript: $(document).ready(function(){
									$('.modal-body #shopimage').attr('src', '".$row['shop_image']."');
									$('.modal-body #shopid').val('".$row['ssm_no']."');
									$('.modal-body #shopname').val('".$row['shop_name']."');
									$('.modal-body #shopdesc').val('".$row['shop_desc']."');
									$('.modal-body #shopadd').val('".$row['shop_location']."');
									$('.modal-body #shopbusi').val('$business_hour');
									$('.modal-body #owner').val('".$row['user_name']."');
								});\">".$row['shop_name']."</a>
						</td>";
						echo "<td><a onClick=\"javascript: return confirm('Are you sure that you want to unblock this product?');\"
							href='unblockProduct.php?productID=".$row['product_id']."' >
							<img src='/BuyMe/image/unblock.png' /></a></td>";
						echo "</tr>";
						
					}  else {
						
						$query_1 = "SELECT * FROM address WHERE user_id = '".$row['user_id']."'";
						$stmt_1 = $conn->prepare($query_1);
						$stmt_1->execute();
						
						$result_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);
						foreach($result_1 as $row_1) {
							$shop_address = $row_1['address']." ".$row_1['postcode']." ".$row_1['city']." ".$row_1['state'];
						}
						
						echo "<tr>";
						echo "<td><img style='max-width:350px; max-height:400px;' src='".$row['product_image']."'/></td>";
						echo 
						"<td style='text-align:left;'>Product ID : ".$row['product_id']."<br>
						Product Name : ".$row['product_name']."<br>
						Product Description : ".$row['product_desc']."<br>
						Product Price : RM ".$row['product_price']."<br>
						Sell at : <a href='#shopform' data-toggle='modal' data-target='#shopform'
						onclick=\"javascript: $(document).ready(function(){
									$('.modal-body #shopimage').attr('src', '".$row['shop_image']."');
									$('.modal-body #shopid').val('".$row['ssm_no']."');
									$('.modal-body #shopname').val('".$row['shop_name']."');
									$('.modal-body #shopdesc').val('".$row['shop_desc']."');
									$('.modal-body #shopadd').val('$shop_address');
									$('.modal-body #shopbusi').val('$business_hour');
									$('.modal-body #owner').val('".$row['user_name']."');
								});\">".$row['shop_name']."</a>
						</td>";
						echo "<td><a onClick=\"javascript: return confirm('Are you sure that you want to unblock this product?');\"
							href='unblockProduct.php?productID=".$row['product_id']."' >
							<img src='/BuyMe/image/unblock.png' /></a></td>";
						echo "</tr>";
					}
				}
			}
			
			echo '</table>';
			
			$query1 = "SELECT DISTINCT p.*, s.*, u.user_id, u.user_name FROM product p, shop s, user u  WHERE p.shop_id = s.shop_id AND s.user_id = u.user_id AND product_status='block'";
			$stmt1 = $conn->prepare($query1);
			$stmt1->execute();
			$count_row1 = $stmt1->rowCount();
			$page = ceil($count_row1/4);
			echo '<nav style="float:right;margin-right:15px;">';
			echo '<ul class="pagination">';
			for($page_next=1;$page_next<=$page;$page_next++) {
				echo "<li class='page-item'><a class='page-link' href='block.php?page=$page_next'>$page_next</a></li>";
			}
			echo '</ul>';
			echo '</nav>';
		}		
	}
} catch(PDOException $e) {

	echo "Error: " . $e->getMessage();
}
?>