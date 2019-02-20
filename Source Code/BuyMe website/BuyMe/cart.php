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
<link rel="stylesheet" href="css/sweetalert.min.css" />
<link rel="stylesheet" href="css/buyme_style.css" />
<!-- JS -->
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="js/bootstrap-spinner.js"></script>
<script type="text/javascript" src="js/cart.js"></script>
</head>

<body>
<div class="container">
	<?php
        session_start();
        include_once 'header.php';
        if (isset($_SESSION['username'])) {
            if($_SESSION['username']=="") {
                include_once 'menu/home_menu.php';
            } else {
                if($_SESSION['role']=="user") {
                    include_once 'menu/login_cart.php';
                    echo "<p style='float:left;color:#900C3F;'>Welcome, ".$_SESSION['username']."</p>";
                    echo "<p style='float:right;color:#900C3F;'>Last Login : ".$_SESSION['lastlogin']."</p>";
                    echo "<label style='display:none;' id='buyer_id_1'>".$_SESSION['userid']."</label>";
                } else {
                    include_once 'seller/menu/home_menu.php';
                }
            }
        } else {
            include_once 'menu/home_menu.php';
        }
    ?>
    <br /><br />
    <div id="no_cart">
    	<!--<img src="image/cart_empty.png" alt="No Cart Currently" width="300px" height="300px"/>-->
        <br /><br />
        <label>Your cart is empty.</label>
        <br /><br />
		<a href="/BuyMe"><input type="submit" class="btn" id="shop_now_btn" value="Shop Now" /></a>
    </div>
    <div id="user_cart">
        <table id="cart_order_info" class="table table-hover">
        	<thead>
            	<tr>
                	<th>Product</th>
                    <th class="position" width="150px">Price (MYR)</th>
                    <th class="position" width="150px">Quantity</th>
                    <th class="position" width="150px">Subtotal (MYR)</th>
                    <th class="position" width="200px"><img width="30px" height="30px" src="image/deliver.png" /></th>
                    <th width="50px"></th>
                </tr>
            </thead>
        </table>
        <table class="table">
        	<tr>
            	<td width="700px"><a href="/BuyMe"><input type="submit" class="btn btn_continue" value="Continue Shopping" /></a></td>
                <td width="150px"></td>
               	<td width="150px"><h4 align="right">Total (MYR) :</h4></td>
                <td width="200px"><h4 align="center" id="cart_total"></h4></td>
                <td width="100px"></td>
                <td><a href="checkout.php"><input type="submit" class="btn btn_checkout" value="Checkout Now" /></a></td>
			</tr>
        </table>
    </div>
</div>
<br /><br />
</body>
</html>