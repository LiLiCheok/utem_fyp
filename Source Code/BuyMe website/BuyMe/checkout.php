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
<script type="text/javascript" src="js/checkout.js"></script>
</head>

<body>
<div class="container">
	<?php
        session_start();
        include_once 'header.php';
        if (isset($_SESSION['username'])) {
            if($_SESSION['username']=="") {
            } else {
                if($_SESSION['role']=="user") {
                    echo "<p style='float:left;color:#900C3F;'>Welcome, ".$_SESSION['username']."</p>";
                    echo "<p style='float:right;color:#900C3F;'>Last Login : ".$_SESSION['lastlogin']."</p>";
                    echo "<label style='display:none;' id='buyer_id_4'>".$_SESSION['userid']."</label>";
                } else {}
            }
        } else {}
    ?>
    <br /><br />
    <h4 id="number_order"></h4>
    <table id="checkout_order_info" class="table tbl_checkout">
        <thead>
            <tr>
                <th width="200px">Product</th>
                <th class="position" width="150px">Price (MYR)</th>
                <th class="position" width="100px">Quantity</th>
                <th class="position" width="150px">Subtotal (MYR)</th>
                <th class="position" width="150px">Delivery?</th>
                <th class="position" width="200px">Total (MYR)<br />- after charge -</th>
            </tr>
        </thead>
    </table>
    <a href="javascript: void(0);" onclick="back_to_cart();"><input type="submit" class="btn btn_right btn_cancel_checkout" value="Cancel" /></a>
    <a href="javascript: void(0);" onclick="order();"><input type="submit" class="btn btn_right btn_checkout" value="Order" /></a>
</div>
<div class="modal fade" id="add_address_form" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Address Form</h4>
            </div>
            <div class="modal-body">
                <div class="show_logo">
                	<h5><i>* You may update your address in "My Profile" at anytime. *</i></h5>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 label_btw">Address :</p>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="add_address" />
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 label_btw">Postcode :</p>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" onkeypress='return isNumberKey(event);' id="add_postcode" />
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 label_btw">City :</p>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="add_city" />
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 label_btw">State :</p>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="add_state" value="Melaka" readonly />
                        </div>
                    </div>
                    <br />
                    <input type="submit" class="btn btn_right" id="add_address_btn" value="OK" />
                </div>
            </div>
        </div>
    </div>
</div>
<br /><br />
</body>
</html>