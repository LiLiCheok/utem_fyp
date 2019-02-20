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
            	<h3 class="panel-title">Product's category</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" name="search_from" method="POST" >
                    <input type="submit" name="search" class="btn btn-info search_btn" style="width:100px;"value="Search" >
                    <input type="text" class="form-control search_box" name="search_box" placeholder="Search by Category ID or Category Name"/>
                    <br /><br /><br />
                    <label style="margin-left:15px;">
                        <?php include_once('getCategoryTotal.php'); echo $_SESSION['numberOfCategory']; ?> categories have created.
                    </label>
                    <br /><br />
                    <table class="tablestyle">
                        <tr>
                            <th style="width: 150px;">Category ID</th>
                            <th style="width: 200px;">Category Name</th>
                            <th style="width: 250px;">Created At</th>
                            <th style="width: 150px;">Edit</th>
                            <th style="width: 150px;">Delete</th>
                        </tr>
                        <?php include_once('getCategoryList.php'); ?>
                    </table>
                    <br />
                    <a href="#createform" data-toggle="modal" data-target="#createform"><input type="submit" class="btn btn-info" style="float:right" value="Create New Category"/></a>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Pop up Create Category Form -->
    <div class="modal fade" id="createform" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create New Category</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form_position" method="POST" action="createCategory.php">
                        <div class="form-group">
                            <label>Category ID :</label>
                            <input type="text" name="catID" id="catID" class="form-control"
                            	value="<?php include('setCategoryID.php'); echo $_SESSION['catID']; ?>" readonly/><br />
                            <label>Category Name :</label>
                            <input type="text" name="catName" id="catName" class="form-control" required /><br />
                            <label>Created At :</label>
                            <input name="createdAt" id="createdAt" value="<?php echo date("Y-m-d H:i:s", time()); ?>"
                            	class="form-control" readonly /><br />
                            <input type="submit" value="Create" name="create" class="btn btn-success" style="float:right;" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pop up Update Category Form -->
    <div class="modal fade" id="updateform" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update Category</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form_position" method="POST" action="createCategory.php">
                        <div class="form-group">
                            <label>Category ID :</label>
                            <input type="text" name="catID" id="catID" class="form-control" readonly/><br />
                            <label>Category Name :</label>
                            <input type="text" name="catName" id="catName" class="form-control" required /><br />
                            <label>Created At :</label>
                            <input name="createdAt" id="createdAt" value="<?php echo date("Y-m-d H:i:s", time()); ?>"
                            	class="form-control" readonly /><br />
                            <input type="submit" value="Update" name="update" class="btn btn-success" style="float:right;" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>