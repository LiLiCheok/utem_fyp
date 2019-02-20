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
<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="css/sweetalert.min.css" />
<link rel="stylesheet" href="css/buyme_style.css" />
<!-- JS -->
<script type='text/javascript' src='js/jquery-1.8.3.js'></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="js/register.js"></script>
</head>

<body>
	<div class="container">
		<?php
        	include_once 'header.php';
			if (isset($_SESSION['username'])) {
				if($_SESSION['username']=="") {
					include_once 'menu/home_register.php';
				} else {
					include_once 'menu/login_menu.php';
				}
			} else {
				include_once 'menu/home_register.php';
			}
		?>
        <div class="alert alert-danger" id="mail_validation_1">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Please enter a valid e-mail address.</strong>
        </div>
        <div class="alert alert-danger" id="password_not_match">
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            	<span aria-hidden="true">&times;</span>
            </button>
        	<strong>Both entered password is incorrect.</strong>
        </div>
        <div class="form-horizontal">
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Choose your role :</p>
                <div class="col-sm-4" style="text-align:center;">
                    <label class="checkbox-inline">
                       <input type="radio" id="user_checked" name="user_role" onclick="user();" checked /> I am a user.
                    </label>
                </div>
                <p class="col-sm-1"></p>
                <div class="col-sm-4" style="text-align:center;">
                    <label class="checkbox-inline">
                        <input type="radio" id="seller_checked" name="user_role" onclick="seller();" /> I am a seller.
                    </label>
                </div>
            </div>
        </div>
        <br />
        <div id="user_reg_info">
            <div class="form-horizontal">
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Your Name :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg_1" type="text" id="reg_name" />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">NRIC/Passport No :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg" type="text" id="reg_ic" />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Contact No :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg_2" type="text" onkeypress='return isNumberKey(event);' id="reg_contact" />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">E-mail(username) :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg_3" type="email" id="reg_email" />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Password :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg" type="password" id="reg_password" />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Confirm Password :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg" type="password" id="con_password" />
                    </div>
                </div>
                <br />
            </div>
            <input type="submit" class="btn btn-primary" id="user_reg_button" value="Register" />
        </div>
        <div id="seller_reg_info">
        	<form class="form-horizontal" role="form" onsubmit="return check_file(this);">
            	<div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Your Name :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg_1" type="text" id="reg_sname" disabled />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">NRIC/Passport No :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg" type="text" id="reg_sic" disabled />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Contact No :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg_2" type="text" onkeypress='return isNumberKey(event);' id="reg_scontact" disabled />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">E-mail(username) :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg_3" type="email" id="reg_semail" disabled />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Password :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg" type="password" id="reg_spassword" disabled />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Confirm Password :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg" type="password" id="con_spassword" disabled />
                    </div>
                </div>
                <br />
            	<div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Shop Logo/Photo :</p>
                    <div class="col-sm-9">
                        <input type="file" id="shop_image" name="shop_image" disabled />
                    </div>
                </div>
                <br />
            	<div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Shop Name :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg_1" type="text" id="reg_company" disabled />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">ROC/SSM No :</p>
                    <div class="col-sm-9">
                        <input class="form-control reg" type="text" id="reg_ssm" disabled />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Description of your Business :</p>
                    <div class="col-sm-9">
                        <textarea class="form-control" type="text" id="reg_desc" rows="6" disabled ></textarea>
                    </div>
                </div>
                <br />
                <div id="single_day">
                	<div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Business Hour :</p>
                        <div class="col-sm-2">
                            <input type='text' class="form-control" id="daily" value="Daily" disabled readonly />
                        </div>
                        <p class="col-sm-1"></p>
                        <div class="col-sm-2">
                            <div class='input-group date timepick' >
                            <input type='text' class="form-control" id="reg_start" placeholder="Start" disabled readonly />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                            </div>
                        </div>
                        <p class="col-sm-1 label_btw">to</p>
                        <div class="col-sm-2">
                            <div class='input-group date timepick' >
                            <input type='text' class="form-control" id="reg_end" placeholder="End" disabled readonly />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                            </div>
                        </div>
                        <div class="col-sm-1 label_btw">
                            <a href="javascript:void(0)" onclick="add_date_click();"><span class="glyphicon glyphicon-plus"
                            data-toggle="tooltip" data-placement="bottom" title='Monday to Sunday'></span></a>
                        </div>
                    </div>
                </div>
                <?php include_once 'menu/all_day.php';?>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Phone No :</p>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" onkeypress='return isNumberKey(event)' id="reg_phone" disabled />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Delivery Service :</p>
                    <div class="col-sm-4" style="text-align:center;">
                        <label class="checkbox-inline">
                           <input type="radio" value="yes" id="delivery_yes" onclick="del_yes();" checked disabled /> Yes
                        </label>
                    </div>
                    <p class="col-sm-1"></p>
                    <div class="col-sm-4" style="text-align:center;">
                        <label class="checkbox-inline">
                            <input type="radio" value="no" id="delivery_no" onclick="del_no();" disabled /> No
                        </label>
                    </div>
                </div>
                <br />
                <div id="delivery_info">
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Delivery Information :</p>
                        <div class="col-sm-1">
                        	<select class="form-control" id="delivery_charge" style="padding:0;" disabled>
                            	<option value="Free">Free</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-sm-1" id="other_charge">
                        	<input class="form-control" type="text" onkeypress='return isNumberKey(event);' id="charge_text" disabled />
                        </div>
                        <p class="col-sm-3 label_btw" id="charge">% delivery charge for orders of RM</p>
                        <p class="col-sm-2 label_btw" id="free">delivery for orders of RM</p>
                        <div class="col-sm-1">
                            <input class="form-control" type="text" id="quantity_text" onkeypress='return isNumberKey(event);' disabled />
                        </div>
                        <label class="col-sm-1 label_btw">.</label>
                        <div class="col-sm-1">
                        	<select class="form-control" id="quantity_cent">
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
                        <p class="col-sm-2 label_btw" id="items">and above in the shop.</p>
                    </div>
                    <br />
                </div>
                <div id="shop_address">
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Address :</p>
                        <div class="col-sm-9">
                            <input class="form-control reg_1" type="text" id="reg_address" disabled />
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Postcode :</p>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" onkeypress='return isNumberKey(event);' id="reg_postcode" disabled />
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">City :</p>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="reg_city" disabled />
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2 control-label">State :</p>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="reg_state" value="Melaka" disabled readonly />
                        </div>
                    </div>
                    <br />
                </div>
                <div id="shop_location">
                	<div id="form-group" class="row">
                        <p class="col-sm-2 control-label">Shop Location :</p>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" id="reg_location" disabled readonly />
                        </div>
                        <div class="col-sm-2 track">
                            <a href="javascript:
                            	window.open('get_location.php', '', 'scrollbars=1, resizable=no, width=900, height=1000, left=200, right=200');
                                window.close();">
                                <img src="image/track.png" id="track_pic" alt="track location icon"/>
                            </a>
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-2"></p>
                        <div class="col-sm-9">
                            <a href="javascript:void(0)" onclick="curr_address();"><span><i>I want to provide my full address.</i></span></a>
                        </div>
                    </div>
                    <br />
                </div>
                <div id="track_location">
                    <div id="form-group" class="row">
                        <p class="col-sm-2"></p>
                        <div class="col-sm-9">
                            <a href="javascript:void(0)" onclick="curr_location();"><span><i>I want to track my current location.</i></span></a>
                        </div>
                    </div>
                    <br />
                </div>
                <input type="submit" class="btn btn-primary" id="seller_reg_button" value="Register" disabled />
            </form>
        </div>
        <br /><br /><br /><br />
    </div>
</body>
</html>