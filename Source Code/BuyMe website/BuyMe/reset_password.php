<?php
if(isset($_GET['code'])) {
	$get_userID = $_GET['user_email'];
	$get_code = $_GET['code'];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- META -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- TITLE -->
<title>BuyMe - Reset Password</title>
<!--<link rel="icon" type="image/gif/png" href="image/buyme_logo.png">-->
<!-- CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/sweetalert.min.css" />
<link rel="stylesheet" href="css/buyme_style.css" />
<!-- JS -->
<script type='text/javascript' src='js/jquery-1.8.3.js'></script>
<script type='text/javascript' src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="js/reset.js"></script>
</head>

<body>
    <div class="container">
    	<?php include_once 'header.php';?>
        <div class="alert alert-danger" id="password_not_match">
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            	<span aria-hidden="true">&times;</span>
            </button>
        	<strong>Both entered password is incorrect.</strong>
        </div>
        <div class="modal-dialog" id="forgotform" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Reset Your Password</h4>
                    </div>
                    <div class="modal-body">
                        <label id="label_reset">
                            <i>Please enter your new password.</i>
                        </label>
                        <br />
                        <form class="form-horizontal">
                            <div class="form-group">
                                <div class="col-md-8" id="send_form">
                                    <input type="email" id="email_link" class="form-control" value="<?php echo $get_userID; ?>" readonly />
                                    <br />
                                    <input type="password" class="form-control" id="old_pass" onkeyup="pass_length();" placeholder="New Password" /><br />
                                    <input type="password" class="form-control" id="new_pass" onkeyup="pass_length();" placeholder="Confirm New Password" />
                                    <input style="margin-top:10px; float:right;" type="submit" class="btn btn-success" id="reset_button" value="Reset" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>