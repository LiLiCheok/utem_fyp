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
<link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="../css/sweetalert.min.css" />
<link rel="stylesheet" href="../css/buyme_style.css" />
<!-- JS -->
<script type='text/javascript' src='../js/jquery-1.8.3.js'></script>
<script type='text/javascript' src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<script type="text/javascript" src="../js/seller/profile.js"></script>
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
						include_once 'menu/profile_menu.php';
						echo "<p style='float:left;'>Welcome, ".$_SESSION['username']."</p>";
						echo "<p style='float:right;'>Last Login : ".$_SESSION['lastlogin']."</p>";
						echo "<label style='display:none;' id='user_id'>".$_SESSION['userid']."</label>";
					} else
						include_once 'blank_page.php';
				}
			} else {
				include_once 'blank_page.php';
			}
        ?>
		<br />
        <p style='text-align:center;color:#63C;'><i>~~~ All information is up-to-date once you change each of the text fields. ~~~</i></p>
        <br />
        <form class="form-horizontal" role="form">
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Your Name :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" id="ur_name" />
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">NRIC/Passport No :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" id="ur_ic" />
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Contact No :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" onkeypress='return isNumberKey(event);' id="ur_contact" />
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">E-mail(username) :</p>
                <div class="col-sm-7">
                    <input class="form-control" type="email" id="ur_email" readonly/>
                </div>
                <div class="col-sm-2 label_btw">
                    <a href="#change_email_form" data-toggle="modal" data-target="#change_email_form">Change E-mail</a>
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Password :</p>
                <div class="col-sm-7">
                    <input class="form-control" type="password" id="ur_password" readonly/>
                </div>
                <div class="col-sm-2 label_btw">
                    <a href="#change_pass_form" data-toggle="modal" data-target="#change_pass_form">Change Password</a>
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Shop Logo/Photo :</p>
                <div class="col-sm-2">
                    <a href="#view_image_form" data-toggle="modal" data-target="#view_image_form">
                        <button class="btn btn-success">Current Shop Logo</button>
                    </a>
                </div>
                <div class="col-sm-2">
                    <a href="#change_image_form" data-toggle="modal" data-target="#change_image_form">
                        <button class="btn btn-info">Change Shop Logo</button>
                    </a>
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Shop Name :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" id="ur_company" />
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">ROC/SSM No :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" id="ur_ssm" />
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Description of your Business :</p>
                <div class="col-sm-9">
                    <textarea class="form-control" type="text" id="ur_desc" rows="6" ></textarea>
                </div>
            </div>
            <br />
            <div id="everyday">
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Business Hour :</p>
                    <div class="col-sm-2">
                        <input type='text' class="form-control" id="ur_daily" value="Daily" readonly />
                    </div>
                    <p class="col-sm-1"></p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_start" placeholder="Start" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                    <p class="col-sm-1 label_btw">to</p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_end" placeholder="End" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2"></p>
                    <div class="col-sm-9">
                        <a href="#change_monsun_form" data-toggle="modal" data-target="#change_monsun_form"><span><i>Change to Monday-Sunday format</i></span></a>
                    </div>
                </div>
                <br />
            </div>
            <div id="mon_sun">
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Business Hour :</p>
                    <div class="col-sm-2">
                        <input type='text' class="form-control" id="ur_monday" value="Monday" readonly />
                    </div>
                    <p class="col-sm-1"></p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_mon_start" placeholder="Start" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                    <p class="col-sm-1 label_btw">to</p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_mon_end" placeholder="End" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2"></p>
                    <div class="col-sm-2">
                        <input type='text' class="form-control" id="ur_tuesday" value="Tuesday" readonly />
                    </div>
                    <p class="col-sm-1"></p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_tue_start" placeholder="Start" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                    <p class="col-sm-1 label_btw">to</p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_tue_end" placeholder="End" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2"></p>
                    <div class="col-sm-2">
                        <input type='text' class="form-control" id="ur_wednesday" value="Wednesday" readonly />
                    </div>
                    <p class="col-sm-1"></p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_wed_start" placeholder="Start" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                    <p class="col-sm-1 label_btw">to</p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_wed_end" placeholder="End" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2"></p>
                    <div class="col-sm-2">
                        <input type='text' class="form-control" id="ur_thursday" value="Thursday" readonly />
                    </div>
                    <p class="col-sm-1"></p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_thur_start" placeholder="Start" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                    <p class="col-sm-1 label_btw">to</p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_thur_end" placeholder="End" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2"></p>
                    <div class="col-sm-2">
                        <input type='text' class="form-control" id="ur_friday" value="Friday" readonly />
                    </div>
                    <p class="col-sm-1"></p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_fri_start" placeholder="Start" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                    <p class="col-sm-1 label_btw">to</p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_fri_end" placeholder="End" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2"></p>
                    <div class="col-sm-2">
                        <input type='text' class="form-control" id="ur_saturday" value="Saturday" readonly />
                    </div>
                    <p class="col-sm-1"></p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_sat_start" placeholder="Start" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                    <p class="col-sm-1 label_btw">to</p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_sat_end" placeholder="End" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2"></p>
                    <div class="col-sm-2">
                        <input type='text' class="form-control" id="ur_sunday" value="Sunday" readonly />
                    </div>
                    <p class="col-sm-1"></p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_sun_start" placeholder="Start" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                    <p class="col-sm-1 label_btw">to</p>
                    <div class="col-sm-2">
                        <div class='input-group date timepick' >
                        <input type='text' class="form-control" id="ur_sun_end" placeholder="End" readonly />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        </div>
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2"></p>
                    <div class="col-sm-9">
                        <a href="#change_daily_form" data-toggle="modal" data-target="#change_daily_form"><span><i>Change to Daily format</i></span></a>
                    </div>
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Phone No :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" onkeypress='return isNumberKey(event);' id="ur_phone" />
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Delivery Service :</p>
                <div class="col-sm-4" style="text-align:center;">
                    <label class="checkbox-inline">
                       <input type="radio" value="yes" id="ur_del_yes" name="delivery" /> Yes
                    </label>
                </div>
                <p class="col-sm-1"></p>
                <div class="col-sm-4" style="text-align:center;">
                    <label class="checkbox-inline">
                        <input type="radio" value="no" id="ur_del_no" name="delivery" /> No
                    </label>
                </div>
            </div>
            <br />
            <div id="ur_delivery_info">
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Delivery Information :</p>
                    <div class="col-sm-1">
                        <select class="form-control" id="ur_delivery_charge" onchange="choose_charge();"  style="padding:0;">
                            <option value="Free">Free</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-sm-1" id="ur_other_charge">
                        <input class="form-control" type="text" onkeypress='return isNumberKey(event);' id="ur_charge_text" />
                    </div>
                    <p class="col-sm-3 label_btw" id="ur_charge">% delivery charge for orders of RM</p>
                    <p class="col-sm-2 label_btw" id="ur_free">delivery for orders of RM</p>
                    <div class="col-sm-1">
                        <input class="form-control" type="text" id="ur_quantity_text" onkeypress='return isNumberKey(event);' />
                    </div>
                    <label class="col-sm-1 label_btw">.</label>
                    <div class="col-sm-1">
                        <select class="form-control" id="ur_quantity_cent">
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
                    <p class="col-sm-2 label_btw" id="ur_items">and above in the shop.</p>
                </div>
                <br />
            </div>
            <div id="ad">
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Address :</p>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" id="ur_address" />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Postcode :</p>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" onkeypress='return isNumberKey(event);' id="ur_postcode" />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">City :</p>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" id="ur_city" />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">State :</p>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" id="ur_state" readonly />
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2"></p>
                    <div class="col-sm-9">
                        <a href="#change_location_form" data-toggle="modal" data-target="#change_location_form"><span><i>Change to Location format</i></span></a>
                    </div>
                </div>
                <br />
            </div>
            <div id="lo">
                <div id="form-group" class="row">
                    <p class="col-sm-2 control-label">Shop Location :</p>
                    <div class="col-sm-7">
                        <input class="form-control" type="text" id="ur_location" readonly />
                    </div>
                    <div class="col-sm-2 track">
                        <a href="javascript:
                            window.open('get_location.php', '', 'scrollbars=1, resizable=no, width=900, height=1000, left=200, right=200');
                            window.close();">
                            <img src="../image/track.png" id="track_pic" alt="track location icon"/>
                        </a>
                    </div>
                </div>
                <br />
                <div id="form-group" class="row">
                    <p class="col-sm-2"></p>
                    <div class="col-sm-9">
                        <a href="#change_address_form" data-toggle="modal" data-target="#change_address_form"><span><i>Change to Address format</i></span></a>
                    </div>
                </div>
                <br />
            </div>
        </form>
    </div>
    <br /><br />
    <div class="modal fade" id="change_email_form" role="dialog" data-keyboard="false" data-backdrop="static">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change E-mail</h4>
                </div>
                <div class="modal-body">
                	<div class="show_logo">
						<div class="alert alert-danger" id="smail_validation">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Please enter a valid e-mail address.</strong>
                        </div>
                    	<div id="form-group" class="row">
                            <p class="col-sm-3 label_btw">Old E-mail :</p>
                         	<div class="col-sm-7">
                            	<input class="form-control" type="email" id="ur_old_mail" readonly/>
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <p class="col-sm-3 label_btw">New E-mail :</p>
                            <div class="col-sm-7">
                            	<input class="form-control reg" type="email" id="ur_new_mail" />
                            </div>
                        </div>
                        <br />
                        <input type="submit" class="btn btn-default btn_right" id="change_email_btn" value="Change E-mail" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="change_pass_form" role="dialog" data-keyboard="false" data-backdrop="static">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                	<div class="show_logo">
                    	<div class="alert alert-danger" id="pass_match">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Both entered password is different.</strong>
                        </div>
                        <div id="form-group" class="row">
                            <p class="col-sm-4 label_btw">Old Password :</p>
                            <div class="col-sm-6">
                        		<input class="form-control reg" type="password" id="ur_old_pass" />
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <p class="col-sm-4 label_btw">New Password :</p>
                            <div class="col-sm-6">
                        		<input class="form-control reg" type="password" id="ur_new_pass" />
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <p class="col-sm-4 label_btw">Re-type New Password :</p>
                            <div class="col-sm-6">
                        		<input class="form-control reg" type="password" id="ur_retype_pass" />
                            </div>
                        </div>
                        <br />
                        <input type="submit" class="btn btn-default btn_right" id="change_pass_btn" value="Change Password" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="view_image_form" role="dialog" data-keyboard="false" data-backdrop="static">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Current Shop Logo/Photo</h4>
                </div>
                <div class="modal-body">
                	<div class="image_size">
                		<img id="ur_logo" src="" alt="shop's logo" />
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="modal fade" id="change_image_form" role="dialog" data-keyboard="false" data-backdrop="static">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change Shop Logo/Photo</h4>
                </div>
                <div class="modal-body">
                	<div class="show_logo">
						<div id="form-group" class="row">
							<p class="col-sm-5 label_btw">Choose your shop logo/photo :</p>
							<div class="col-sm-3">
								<input type="file" id="ur_image" name="ur_image" />
							</div>
						</div>
						<input type="submit" class="btn btn-default btn_right" id="change_image_btn" value="Change" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="change_location_form" role="dialog" data-keyboard="false" data-backdrop="static">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change to Location format</h4>
                </div>
                <div class="modal-body">
                	<div class="show_logo">
                    	<div id="form-group" class="row">
                            <p class="col-sm-3 label_btw">Current Location :</p>
                            <div class="col-sm-6">
                            	<input class="form-control" type="text" id="ur_new_location" readonly/>
                            </div>
                            <div class="col-sm-1 label_btw">
                                <a href="javascript:
                                    window.open('get_location.php', '', 'scrollbars=1, resizable=no, width=900, height=1000, left=200, right=200');
                                    window.close();">
                                    <img src="../image/track.png" id="track_pic" alt="track location icon"/>
                                </a>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-default btn_right" id="change_location_btn" value="Change" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="change_address_form" role="dialog" data-keyboard="false" data-backdrop="static">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change to Address format</h4>
                </div>
                <div class="modal-body">
                    <div class="show_logo">
                    	<div id="form-group" class="row">
                            <p class="col-sm-2">Addreess :</p>
                            <div class="col-sm-8">
                            	<input class="form-control" type="text" id="ur_new_address" onkeyup="val_length();" />
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <p class="col-sm-2">Postcode :</p>
                            <div class="col-sm-8">
                            	<input class="form-control" type="text" id="ur_new_postcode" onkeypress='return isNumberKey(event);' onkeyup="val_length();" />
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <p class="col-sm-2">City :</p>
                            <div class="col-sm-8">
                            	<input class="form-control" type="text" id="ur_new_city" onkeyup="val_length();" />
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <p class="col-sm-2">State :</p>
                            <div class="col-sm-8">
                            	<input class="form-control" type="text" id="ur_new_state" value="Melaka" readonly/>
                            </div>
                        </div>
                        <br />
                        <input type="submit" class="btn btn-default btn_right" id="change_address_btn" value="Change" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="change_daily_form" role="dialog" data-keyboard="false" data-backdrop="static">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change to Daily format</h4>
                </div>
                <div class="modal-body">
                	<div class="show_logo">
                    	<div id="form-group" class="row">
                            <div class="col-sm-3">
                                <input type='text' class="form-control" id="new_daily" value="Daily" readonly />
                            </div>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_start" placeholder="Start" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                            <p class="col-sm-1 label_btw">to</p>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_end" placeholder="End" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <br />
                    	<input type="submit" class="btn btn-default btn_right" id="change_daily_btn" value="Change" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="change_monsun_form" role="dialog" data-keyboard="false" data-backdrop="static">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change to Monday-Sunday format</h4>
                </div>
                <div class="modal-body">
                	<div class="show_logo">
                    	<div id="form-group" class="row">
                            <div class="col-sm-3">
                                <input type='text' class="form-control" id="new_monday" value="Monday" readonly />
                            </div>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_mon_start" placeholder="Start" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                            <p class="col-sm-1 label_btw">to</p>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_mon_end" placeholder="End" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <div class="col-sm-3">
                                <input type='text' class="form-control" id="new_tuesday" value="Tuesday" readonly />
                            </div>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_tue_start" placeholder="Start" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                            <p class="col-sm-1 label_btw">to</p>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_tue_end" placeholder="End" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <div class="col-sm-3">
                                <input type='text' class="form-control" id="new_wednesday" value="Wednesday" readonly />
                            </div>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_wed_start" placeholder="Start" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                            <p class="col-sm-1 label_btw">to</p>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_wed_end" placeholder="End" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <div class="col-sm-3">
                                <input type='text' class="form-control" id="new_thursday" value="Thursday" readonly />
                            </div>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_thur_start" placeholder="Start" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                            <p class="col-sm-1 label_btw">to</p>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_thur_end" placeholder="End" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <div class="col-sm-3">
                                <input type='text' class="form-control" id="new_friday" value="Friday" readonly />
                            </div>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_fri_start" placeholder="Start" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                            <p class="col-sm-1 label_btw">to</p>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_fri_end" placeholder="End" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <div class="col-sm-3">
                                <input type='text' class="form-control" id="new_saturday" value="Saturday" readonly />
                            </div>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_sat_start" placeholder="Start" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                            <p class="col-sm-1 label_btw">to</p>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_sat_end" placeholder="End" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <div class="col-sm-3">
                                <input type='text' class="form-control" id="new_sunday" value="Sunday" readonly />
                            </div>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_sun_start" placeholder="Start" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                            <p class="col-sm-1 label_btw">to</p>
                            <div class="col-sm-4">
                                <div class='input-group date timepick' >
                                <input type='text' class="form-control" id="new_sun_end" placeholder="End" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <br />
                    	<input type="submit" class="btn btn-default btn_right" id="change_monsun_btn" value="Change" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>