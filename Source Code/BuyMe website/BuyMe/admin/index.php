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
<link rel="stylesheet" href="../css/admin_style.css" />
<!-- JS -->
<script type='text/javascript' src='../js/jquery-1.8.3.js'></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<script type="text/javascript" src="../js/admin/login.js"></script>
</head>

<body>
	<div class="container">
    	<div class="jumbotron">
        	<h2>BuyMe (Administrator Site)</h2>
        </div>
        <div class="modal-dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Sign In</h4>
                    </div>
                    <div class="modal-body">
                    	<form class="form-horizontal form_position">
                            <div class="form-group">
                            	<p>Admin ID :</p>
                                <input type="text" id="admin_id" class="form-control" onkeyup="validate_length();" /><br />
                                <p>Admin Password :</p>
                                <input type="password" id="admin_password" class="form-control" onkeyup="validate_length();" /><br />
                                <input type="submit" value="Sign In" class="btn btn-default" id="login_btn" />
                                <br /><br /><br />
                                <a href="../login.php"><span id="back_link">Back to previous page</span></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
