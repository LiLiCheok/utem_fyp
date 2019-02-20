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
<script type="text/javascript" src="js/profile.js"></script>
</head>

<body>
    <div class="container">
        <?php
            session_start();
            include_once 'header.php';
            if (isset($_SESSION['username'])) {
                if($_SESSION['username']=="") {
                    include_once 'menu/home_menu.php';
					echo "<label style='display:none;' id='buyer_id_3'></label>";
                } else {
                    if($_SESSION['role']=="user") {
                        include_once 'menu/login_profile.php';
                        echo "<p style='float:left;color:#900C3F;'>Welcome, ".$_SESSION['username']."</p>";
                        echo "<p style='float:right;color:#900C3F;'>Last Login : ".$_SESSION['lastlogin']."</p>";
						echo "<br />";
                        echo "<label style='display:none;' id='buyer_id_3'>".$_SESSION['userid']."</label>";
                    } else {
                        include_once 'seller/menu/home_menu.php';
						echo "<label style='display:none;' id='buyer_id_3'></label>";
                    }
                }
            } else {
                include_once 'menu/home_menu.php';
				echo "<label style='display:none;' id='buyer_id_3'></label>";
            }
        ?>
        <br />
        <p style='text-align:center;color:#63C;'><i>~~~ All information is required for ordering process. ~~~</i></p>
        <br />
        <form class="form-horizontal" role="form">
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Your Name :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" id="uname" />
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">NRIC/Passport No :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" id="uic" />
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Contact No :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" onkeypress='return isNumberKey(event);' id="ucontact" />
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">E-mail(username) :</p>
                <div class="col-sm-7">
                    <input class="form-control" type="email" id="uemail" readonly/>
                </div>
                <div class="col-sm-2 label_btw">
                    <a href="#change_email_form" data-toggle="modal" data-target="#change_email_form">Change E-mail</a>
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Password :</p>
                <div class="col-sm-7">
                    <input class="form-control" type="password" id="upassword" readonly/>
                </div>
                <div class="col-sm-2 label_btw">
                    <a href="#change_pass_form" data-toggle="modal" data-target="#change_pass_form">Change Password</a>
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Address :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" id="uaddress" />
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">Postcode :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" onkeypress='return isNumberKey(event);' id="upostcode" />
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">City :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" id="ucity" />
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <p class="col-sm-2 control-label">State :</p>
                <div class="col-sm-9">
                    <input class="form-control" type="text" id="ustate" value="Melaka" readonly />
                </div>
            </div>
            <br />
            <input type="submit" class="btn btn_right" id="update_uprofile_btn" value="Update" />
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
                    	<div class="alert alert-danger" id="umail_validation">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Please enter a valid e-mail address.</strong>
                        </div>
                    	<div id="form-group" class="row">
                            <p class="col-sm-3 label_btw">Old E-mail :</p>
                         	<div class="col-sm-7">
                            	<input class="form-control" type="email" id="old_umail" readonly/>
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <p class="col-sm-3 label_btw">New E-mail :</p>
                            <div class="col-sm-7">
                            	<input class="form-control reg" type="email" id="new_umail" />
                            </div>
                        </div>
                        <br />
                        <input type="submit" class="btn btn_right" id="change_uemail_btn" value="Change E-mail" />
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
                    	<div class="alert alert-danger" id="upass_match">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Both entered password is different.</strong>
                        </div>
                        <div id="form-group" class="row">
                            <p class="col-sm-4 label_btw">Old Password :</p>
                            <div class="col-sm-6">
                        		<input class="form-control reg" type="password" id="old_upass" />
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <p class="col-sm-4 label_btw">New Password :</p>
                            <div class="col-sm-6">
                        		<input class="form-control reg" type="password" id="new_upass" />
                            </div>
                        </div>
                        <br />
                        <div id="form-group" class="row">
                            <p class="col-sm-4 label_btw">Re-type New Password :</p>
                            <div class="col-sm-6">
                        		<input class="form-control reg" type="password" id="retype_upass" />
                            </div>
                        </div>
                        <br />
                        <input type="submit" class="btn btn_right" id="change_upass_btn" value="Change Password" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>