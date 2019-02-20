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
<script type="text/javascript" src="js/order.js"></script>
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
                    include_once 'menu/login_order.php';
                    echo "<p style='float:left;color:#900C3F;'>Welcome, ".$_SESSION['username']."</p>";
                    echo "<p style='float:right;color:#900C3F;'>Last Login : ".$_SESSION['lastlogin']."</p>";
                    echo "<label style='display:none;' id='buyer_id_2'>".$_SESSION['userid']."</label>";
                } else {
                    include_once 'seller/menu/home_menu.php';
                }
            }
        } else {
            include_once 'menu/home_menu.php';
        }
    ?>
    <div id="no_order">
        <br /><br />
        <label>Your order is empty.</label>
        <br /><br />
		<a href="/BuyMe"><input type="submit" class="btn" id="shop_now_btn" value="Shop Now" /></a>
    </div>
    <div id="user_order">
        <table id="order_info" class="table table-hover">
            <thead>
                <tr>
                    <th class="position" width="25px">No</th>
                    <th class="position" width="200px">Order ID</th>
                    <th class="position" width="200px">Order Time</th>
                    <th class="position" width="200px">Order's Detail</th>
                    <th class="position" width="200px">Order Status</th>
                </tr>
            </thead>
        </table>
    </div>
    <div id="order_detail">
    	<br /><br />
        <a href="order.php" class="btn_right">Back to Previous Page</a>
        <br /><br />
        <div id="order_detail_1">
            <div class="row">
            	<p class="col-sm-2"></p>
                <p class="col-sm-4 label_btw">Order ID : <b><span id="uoid"></span></b></p>
                <p class="col-sm-4 label_btw">Order Time : <b><span id="uotime"></span></b></p>
            	<p class="col-sm-2"></p>
            </div>
            <div class="seperate"></div>
            <table id="userorder_dinfo" class="table table-hover">
                <thead>
                    <tr>
                        <th class="position" width="5px">No</th>
                        <th class="position" width="150px">Product ID</th>
                        <th class="position" width="250px">Name</th>
                        <th class="position" width="150px">Price</th>
                        <th class="position" width="100px">Quantity</th>
                        <th class="position" width="150px">Subtotal</th>
                        <th class="position" width="150px">Delivery?</th>
                        <th class="position" width="160px">Subtotal<br />- after charge -</th>
                        <th class="position" width="150px">Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<br /><br />
</body>
</html>