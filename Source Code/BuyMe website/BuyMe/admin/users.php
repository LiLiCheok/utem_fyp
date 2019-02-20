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
<link rel="stylesheet" href="../css/admin_style.css" />
<!-- JS -->
<script type='text/javascript' src='../js/jquery-1.8.3.js'></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
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
            	<h3 class="panel-title">User List</h3>
            </div>
            <div class="panel-body">
            	<label>Number of registered user(acts as buyer) on BuyMe : <?php include('getAppUserTotal.php'); echo $_SESSION['num']; ?></label>
                <br /><hr />
                <label>Number of registered user(acts as seller) on BuyMe : <?php include('getSellerTotal.php'); echo $_SESSION['number']; ?></label>
                <br />
                <table class="tablestyle">
                    <tr>
                        <th style="width: 150px;">User ID</th>
                        <th style="width: 275px;">User E-mail</th>
                        <th style="width: 275px;">User Name</th>
                        <th style="width: 200px;">Last Login</th>
                    </tr>
                	<?php include('getSellerList.php'); ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>