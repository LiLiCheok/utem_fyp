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
<link rel="stylesheet" href="../css/buyme_style.css" />
<!-- JS -->
<script type='text/javascript' src='../js/jquery-1.8.3.js'></script>
<script type='text/javascript' src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&key=AIzaSyCc6vPZAzqfQ-mYwWZ4XVymMH1IRxdKuXY"></script>
<script type='text/javascript' src="../js/seller/get_location.js"></script>
</head>

<body>
    <div class="container">
        <?php include_once '../header.php'; ?>
        <h6>
            <a href="javascript: window.close();" id="category">
                Close map
            </a>
        </h6>
        <br />
        <label style="display:none" id="user_id"><?php session_start(); echo $_SESSION["userid"];?></label>
        <form class="form-inline">
        	<div class="form-group">
                <label style="margin-right:10px;">Your Location :</label>
                <input type="text" name="location" id="location" class="form-control"
                	placeholder="your current location" readonly />
                <input type="submit" id="save" name="saveLocation" value="Save Location" class="btn btn-success" onclick="save()" />
           </div>
        </form>
        <br />
        <!-- Show Google Map -->
        <section id="wrapper">
            <label style="color:#AEB6BF;">
            	<i>Note: Click the allow button to let the browser find your location.</i>
            </label>
            <br />
            <article></article>
        </section>
    </div>
</body>
</html>