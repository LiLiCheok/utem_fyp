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
<link rel="stylesheet" href="../css/admin_style.css" />
<!-- JS -->
<script type='text/javascript' src='../js/jquery-1.8.3.js'></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="../js/admin/main.js"></script>
</head>

<body>
	<div class="container">
    	<?php 
			session_start();
			include_once 'header.php';
			echo "<p>";
            echo "You logged in as : ".$_SESSION['curr_user']."";
			echo "<span style='float:right;'>Last login : ".$_SESSION['last_login']."</span>";
			echo "</p>";
			echo "<br />";
			if($_SESSION['curr_user']!=""&&$_SESSION['curr_role']) {
				include_once 'menu/home_menu.php';
			} else {
				include_once 'blank_page.php';
			}
		?>
        <div class="panel panel-primary info_box">
            <div class="panel-heading">
            	<h3 class="panel-title">Validate Products</h3>
            </div>
            <div class="panel-body">
            	<!-- Choose Date to validate products -->
                <form class="form-inline" method="post" action="">
                    <input type="submit" value="View" name="search" class="btn btn-success" style="margin-left:15px;" />
                    <div class="input-group date" style="margin-left:15px; width:300px;" >
                      <input type="text" name="date_box" class="form-control" placeholder="View Product List by Date">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <?php include("getAllProduct.php"); ?>
                </form>
            </div>
        </div>
    </div>
    <!-- Pop up Shop Info Form -->
    <div class="modal fade" id="shopform" role="dialog">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<!--<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Shop Details</h4>
                </div>-->
                <div class="modal-body">
                <form class="form-horizontal" style="text-align:center;" method="post" action="selling.php">
                	<img id="shopimage" width="200px" height="200px" src=""/>
                </form>
                <br />
                <form class="form-horizontal">
					<div id="form-group" class="row">
                        <p class="col-sm-3 control-label">Shop Name : </p>
                		<div class="col-sm-9">
                        	<input type="text" id="shopname" class="form-control" readonly />
                        </div>
                    </div>
                    <br />
                	<div id="form-group" class="row">
                        <p class="col-sm-3 control-label">SSM No : </p>
                        <div class="col-sm-9">
                        	<input type="text" id="shopid" class="form-control" readonly />
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-3 control-label">Shop Description : </p>
                		<div class="col-sm-9">
                        	<textarea type="text" id="shopdesc" class="form-control" style="resize:none" readonly></textarea>
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-3 control-label">Shop Address : </p>
                		<div class="col-sm-9">
                        	<input type="text" id="shopadd" class="form-control" readonly />
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-3 control-label">Business Hour : </p>
                		<div class="col-sm-9">
                        	<textarea type="text" id="shopbusi" class="form-control" style="resize:none" readonly></textarea>
                        </div>
                    </div>
                    <br />
                    <div id="form-group" class="row">
                        <p class="col-sm-3 control-label">Owner : </p>
                		<div class="col-sm-9">
                        	<input type="text" id="owner" class="form-control" readonly />
                        </div>
                    </div>
                    <br />
                </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>