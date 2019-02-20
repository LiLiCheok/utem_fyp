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
<script type='text/javascript' src='js/jquery-1.8.3.js'></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="js/login.js"></script>
</head>

<body>
	<div class="container">
        <?php
        	include_once 'header.php';
			if (isset($_SESSION['username'])) {
				if($_SESSION['username']=="") {
					include_once 'menu/home_login.php';
				} else {
					include_once 'menu/login_menu.php';
				}
			} else {
				include_once 'menu/home_login.php';
			}
		?>
        <div class="alert alert-danger" id="mail_validation">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Please enter a valid e-mail address.</strong>
        </div>
        <br />
        <form class="form-horizontal" role="form">
            <div id="form-group" class="row">
                <label class="col-sm-2 control-label">Username :</label>
                <div class="col-sm-8">
                	<input class="form-control" type="email" id="login_email" onkeyup="validate_length();" />
                    <p><i>E-mail that you register at BuyMe</i></p>
                </div>
            </div>
            <br />
            <div id="form-group" class="row">
                <label class="col-sm-2 control-label">Password :</label>
                <div class="col-sm-8">
                	<input class="form-control" type="password" id="login_password" onkeyup="validate_length();" />
                    <p><i>Forgot Password? <a href="#forgotform" data-toggle="modal" data-target="#forgotform">Click here</a></i></p>
                </div>
            </div>
            <input type="submit" class="btn btn-primary" id="login_button" value="Login"/>
		</form>
        <br /><br /><br />
        <p id="category"><i>Login as <a href="/BuyMe/admin">administrator</a></i></p>
	</div>
    
    <!-- Reset password Form -->
    <div class="modal fade" id="forgotform" role="dialog">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Forgot Your Password?</h4>
                </div>
                <div class="modal-body">
                    <label id="label_email" >
                    	<i>Please enter your email to receive a reset password link.</i>
                    </label>
                    <br /><br />
                	<form class="form-horizontal">
                        <div class="form-group">
                            <div class="col-md-8" id="send_form">
                            	<input type="email" class="form-control" id="email_link" placeholder="example@gmail.com" onkeyup="validate_length();" />
                                <input id="send_button" type="submit" class="btn btn-success" value="Send" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>