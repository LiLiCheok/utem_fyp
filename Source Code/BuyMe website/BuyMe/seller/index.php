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
<script type="text/javascript" src="../js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<script type="text/javascript" src="../js/seller/main.js"></script>
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
						include_once 'menu/home_menu.php';
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
        <div id="search_info_container">
        	<input type="submit" class="btn" id="add_product_btn" value="Add New Product" onclick="add_new_product();" />
            <div id="form-group" class="row">
            	<div class="col-sm-1 btn_right">
                    <input class="btn" type="submit" id="search_product_btn" value="Search" />
                </div>
                <div class="col-sm-5 btn_right">
                	<input class="form-control" type="text" id="search_product" placeholder="Search By Product ID/Name"/>
                </div>
            </div>
            <br />
           <table id="product_table" class="tablestyle">
           		<thead>
                <tr>
                    <th width="80px">Category</th>
                    <th width="100px">Product ID</th>
                    <th width="200px">Product Photo</th>
                    <th width="200px">Product Name</th>
                    <th width="330px">Product Description</th>
                    <th width="110px">Price (MYR)</th>
                    <th width="70px">Edit</th>
                    <th width="70px">Delete</th>
                </tr>
                </thead>
                <tbody id="tablebody"></tbody>
            </table>
            <table id="search_product_table" class="tablestyle" style="display:none;">
           		<thead>
                <tr>
                    <th width="80px">Category</th>
                    <th width="100px">Product ID</th>
                    <th width="200px">Product Photo</th>
                    <th width="200px">Product Name</th>
                    <th width="330px">Product Description</th>
                    <th width="110px">Price (MYR)</th>
                    <th width="70px">Edit</th>
                    <th width="70px">Delete</th>
                </tr>
                </thead>
                <tbody id="tablebody_search"></tbody>
            </table>
            <nav class="btn_right">
                <ul class="pagination">
                </ul>
            </nav>
        </div>
        <div id="hide_info" class="center_label">
        	<strong>There is no products in your store yet.</strong>
            <br /><br />
            <input type="submit" class="btn" id="add_new_product_btn" value="Add New Product" onclick="add_new_product();" />
        </div>
        <div id="add_new_product">
        	<h4>Add Product <label id="show_pro_id"></label></h4>
            <hr style="border:1px solid #369;" />
            <div id="image_box">
                <img id="target" class="selected_image" />
            </div>
            <br />
            <form class="form-horizontal">
            	<div id="product_info">
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Category :</p>
                        <div class="col-sm-10">
                            <select class="form-control" id="category_id"></select>
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Product Photo :</p>
                        <div class="col-sm-10 label_btw">
                            <input type="file" id="product_image" data-show-preview="false" onchange="put_image();" />
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Product Name :</p>
                        <div class="col-sm-10">
                            <input class="form-control pro" type="text" id="product_name" />
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Product Description :</p>
                        <div class="col-sm-10">
                            <textarea class="form-control pro_1" type="text" id="product_desc" rows="6" ></textarea>
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Product Price (MYR) :</p>
                        <div class="col-sm-2">
                            <input class="form-control pro_2" type="text" id="product_price" onkeypress='return isNumberKey(event)' />
                        </div>
                        <p class="col-sm-1 label_btw">.</p>
                        <div class="col-sm-2">
                        	<select class="form-control" id="product_price_cent">
                            	<option value="00">00</option>
								<option value="10">10</option>
                                <option value="15">15</option>
								<option value="20">20</option>
                                <option value="25">25</option>
								<option value="30">30</option>
                                <option value="35">35</option>
								<option value="40">40</option>
                                <option value="45">45</option>
								<option value="50">50</option>
                                <option value="55">55</option>
								<option value="60">60</option>
                                <option value="65">65</option>
								<option value="70">70</option>
                                <option value="75">75</option>
								<option value="80">80</option>
                                <option value="85">85</option>
								<option value="90">90</option>
                                <option value="95">95</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br />
                <input type="submit" class="btn btn_right" id="cancel_add_btn" value="Cancel" onclick="cancel_add();" />
                <input type="submit" class="btn btn_right" id="add_btn" value="Add" />
            </form>
        </div>
        <div id="update_old_product">
        	<h4>Update Product <label id="show_curr_pro_id"></label></h4>
            <hr style="border:1px solid #369;" />
            <div id="new_image_box">
                <img id="new_target" class="selected_image" />
            </div>
            <br />
            <form class="form-horizontal">
            	<div id="product_info">
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Category :</p>
                        <div class="col-sm-10">
                            <select class="form-control" id="new_category_id"></select>
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Product Photo :</p>
                        <div class="col-sm-10 label_btw">
                            <input type="file" id="new_product_image" data-show-preview="false" onchange="put_new_image();" />
                        </div>
                    </div>
                    <br />
                    <div id="proid" style="display:none;">
                        <div id="form-group" class="row">
                            <p class="col-sm-2 control-label">Product ID :</p>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="current_product_id" />
                            </div>
                        </div>
                        <br />
                    </div>
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Product Name :</p>
                        <div class="col-sm-10">
                            <input class="form-control pro" type="text" id="new_product_name" />
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Product Description :</p>
                        <div class="col-sm-10">
                            <textarea class="form-control pro_1" type="text" id="new_product_desc" rows="6" ></textarea>
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Product Price (MYR) :</p>
                        <div class="col-sm-2">
                            <input class="form-control pro_2" type="text" id="new_product_price" onkeypress='return isNumberKey(event)' />
                        </div>
                        <p class="col-sm-1 label_btw">.</p>
                        <div class="col-sm-2">
                        	<select class="form-control" id="new_product_price_cent">
                            	<option value="00">00</option>
								<option value="10">10</option>
                                <option value="15">15</option>
								<option value="20">20</option>
                                <option value="25">25</option>
								<option value="30">30</option>
                                <option value="35">35</option>
								<option value="40">40</option>
                                <option value="45">45</option>
								<option value="50">50</option>
                                <option value="55">55</option>
								<option value="60">60</option>
                                <option value="65">65</option>
								<option value="70">70</option>
                                <option value="75">75</option>
								<option value="80">80</option>
                                <option value="85">85</option>
								<option value="90">90</option>
                                <option value="95">95</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br />
                <input type="submit" class="btn btn_right" id="cancel_update_btn" value="Cancel" onclick="cancel_update();" />
                <input type="submit" class="btn btn_right" id="update_btn" value="Update" />
            </form>
        </div>
        <br /><br />
    </div>
    <div class="modal fade" id="view_image_form" role="dialog" data-keyboard="false" data-backdrop="static">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Product's Photo</h4>
                </div>
                <div class="modal-body">
                	<div class="image_size">
                		<img id="ur_pro_image" src="" alt="product's photo" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>