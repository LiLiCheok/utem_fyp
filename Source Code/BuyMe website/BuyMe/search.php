<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- META -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- TITLE -->
<title>Welcome to BuyMe</title>
<!--<link rel="icon" type="image/gif/png" href="image/buyme_logo.png">-->
<!-- CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/buyme_style.css" />
<!-- JS -->
<script type='text/javascript' src='js/jquery-1.8.3.js'></script>
<script type='text/javascript' src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</head>

<body>
	<div class="container">
        <?php
        	include_once 'header.php';
			if (isset($_SESSION['username'])) {
				if($_SESSION['username']=="") {
					include_once 'home_menu.php';
					include_once 'search_category.php';
				} else {
					include_once 'login_menu.php';
					include_once 'search_category.php';
				}
			} else {
				include_once 'home_menu.php';
				include_once 'search_category.php';
			}
		
			echo "<br><br><br>";
		
			try {
			
				include_once 'db_conn.php';
				
				if(isset($_POST['search'])) {
					
					$catID = $_POST['category'];
					
					if($catID!="all") {
						
						$query = "SELECT DISTINCT p.*, s.*, CONCAT_WS(' ', userFirstName, userLastName) as name
						FROM product p, shop s, user u
						WHERE p.categoryID = '$catID' AND p.shopID = s.shopID AND s.userID = u.userID AND status='active'
						ORDER BY postedAt";
						
						$stmt = $conn->prepare($query);
						$stmt->execute();
						
						$count_row = $stmt->rowCount();
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
						if($count_row!=0) {
							
							$startrow = 0;
							$endrow = 4;
							
							while($startrow < $count_row) {
							
								$query = "SELECT DISTINCT p.*, s.*, CONCAT_WS(' ', userFirstName, userLastName) as name
								FROM product p, shop s, user u
								WHERE p.categoryID = '$catID' AND p.shopID = s.shopID AND s.userID = u.userID AND status='active'
								ORDER BY postedAt
								LIMIT $startrow, $endrow";
								
								$stmt = $conn->prepare($query);
								$stmt->execute();
								
								$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
								
								echo "
									<div class='card-deck'>
										<div class='col-xs-6 col-sm-4 col-lg-3'>
								";
								
								foreach($result as $row) {
									
									echo "
										<div class='card'>
										<img class='card-img-top' src='data:image;base64,".base64_encode($row['productImage'])."'
										alt='Product Image' />
											<div class='card-block'>
												<h4 class='card-title'>".$row['productName']."</h4>
												<p class='card-text'>Product Description :<br>".$row['productDescription']."</p>
												<p class='card-text'>Product Price(RM) : ".$row['productPrice']."</p>
												<label>Available at : <a href='#shopform' data-toggle='modal' data-target='#shopform'
													onclick=\"javascript: $(document).ready(function(){
														$('.modal-body #shopimage').attr('src', 'data:image;base64,".base64_encode($row['shopImage'])."');
														$('.modal-body #shopid').val('".$row['shopID']."');
														$('.modal-body #shopname').val('".$row['shopName']."');
														$('.modal-body #shopdesc').val('".$row['shopDescription']."');
														$('.modal-body #shopadd').val('".$row['shopAddress']."');
														$('.modal-body #shopbusi').val('".$row['shopBusiness']."');
														$('.modal-body #owner').val('".$row['name']."');
													});\">".$row['shopName']."</a></label>
												<br>
												<form class='form-inline'>
													<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'
														id='cart_box' class='form-control' value='1' />
													<input type='submit' class='btn btn-default' name='addtocart' id='addtocart' value='Add to cart' />
												</form>
											</div>
										</div>
									";
								}
							
								echo "</div></div><br />";
								
								$startrow = $startrow + 4;
							}
							
						} else if($count_row==0) {
							
							echo "<p>There are no products in the selected category.</p>";	
						}
						
					} else {
					
						header('location: /BuyMe');
						
					}
				}
				
			} catch(PDOException $e) {
	
				echo "Error: " . $e->getMessage();
			}
			
			include_once 'shop_form.php';
        ?>
        <br /><br /><br />
    </div>
</body>
</html>