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
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/sweetalert.min.css" />
<link rel="stylesheet" href="../css/buyme_style.css" />
<!-- JS -->
<script type='text/javascript' src='../js/jquery-1.8.3.js'></script>
<script type='text/javascript' src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<script type="text/javascript" src="../js/seller/order.js"></script>
</head>

<body>
	<div class="container">
		<?php
            session_start();
            include_once '../header.php';
			if (isset($_SESSION['username'])) {
				if($_SESSION['username']=="") {
					include_once 'blank_page.php';
				} else {
					if($_SESSION['role']=="seller") {
						include_once 'menu/order_menu.php';
						echo "<p style='float:left;'>Welcome, ".$_SESSION['username']."</p>";
						echo "<p style='float:right;'>Last Login : ".$_SESSION['lastlogin']."</p>";
						echo "<label style='display:none;' id='user_id_1'>".$_SESSION['userid']."</label>";
					} else
						include_once 'blank_page.php';
				}
			} else {
				include_once 'blank_page.php';
			}
        ?>
        <br /><br />
        <div id="no_cusorder">
            <label>No customer order currently.</label>
        </div>
        <div id="cus_order">
			<table id="cusorder_info" class="table table-hover">
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
        <div id="cusorder_detail">
            <a href="customer_order.php" class="btn_right">Back to Previous Page</a>
            <br /><br />
            <div id="cusorder_detail_1">
                <div class="row">
            		<p class="col-sm-1"></p>
                    <p class="col-sm-5">Order ID : <b><span id="oid"></span></b></p>
                    <p class="col-sm-5">Order Time : <b><span id="otime"></span></b></p>
            		<p class="col-sm-1"></p>
                </div>
            	<div class="seperate"></div>
                <br />
                <div class="row">
                	<p class="col-sm-1"></p>
            		<p class="col-sm-5">Customer Name : <b><span id="cusname"></span></b></p>
                    <p class="col-sm-5">IC No. : <b><span id="cusic"></span></b></p>
                    <p class="col-sm-1"></p>
                </div>
                <div class="row">
                    <p class="col-sm-1"></p>
                    <p class="col-sm-5">Contact No. : <b><span id="cuscontact"></span></b></p>
                    <p class="col-sm-5">Address : <b><span id="cusaddress"></span></b></p>
                    <p class="col-sm-1"></p>
                </div>
            	<div class="seperate"></div>
                <table id="cusorder_dinfo" class="table table-hover">
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