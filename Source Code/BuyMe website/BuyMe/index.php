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
<script type="text/javascript" src="js/main.js"></script>
</head>

<body>
    <div class="container">
        <?php
            session_start();
            include_once 'header.php';
            if (isset($_SESSION['username'])) {
                if($_SESSION['username']=="") {
                    include_once 'menu/home_menu.php';
					echo "<label style='display:none;' id='buyer_id'></label>";
                } else {
                    if($_SESSION['role']=="user") {
                        include_once 'menu/login_menu.php';
                        echo "<p style='float:left;color:#900C3F;'>Welcome, ".$_SESSION['username']."</p>";
                        echo "<p style='float:right;color:#900C3F;'>Last Login : ".$_SESSION['lastlogin']."</p>";
						echo "<br />";
                        echo "<label style='display:none;' id='buyer_id'>".$_SESSION['userid']."</label>";
                    } else {
                        include_once 'seller/menu/home_menu.php';
						echo "<label style='display:none;' id='buyer_id'></label>";
                    }
                }
            } else {
                include_once 'menu/home_menu.php';
				echo "<label style='display:none;' id='buyer_id'></label>";
            }
        ?>
        <select class="form-control" id="cat_id" onchange="show_product(this.options[this.selectedIndex].value, '');">
            <option value="all">All Categories</option>
        </select>
        <br />
        <div id="show_none" style="display:none;text-align:center;">
        	<img src="image/no_product.png" width="300px" height="300px" alt="No Product Shown"/>
            <br /><br />
        	<label>No Products is created in this category.</label>
        </div>
        <div id="show_all" style="display:none;">
            <div id="all_rowbyrow" class="card-deck">
            </div>
            <nav class="label_btw">
                <ul class="pagination">
                </ul>
            </nav>
            <hr />
        </div>
        <a class="btn_right" id="back_to_prevpage" href="/BuyMe">Back to Home page</a>
        <br /><br />
        <div id="product_details">
        	<div id="image_section">
        		<img id="sp_image" width="325px" height="350px" src="" alt="product's image" />
            </div>
            <div id="info_section">
            	<table>
                    <tbody>
                        <tr>
                            <td width="130px">Category :</td>
                            <td><span id="sp_category"></span></td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <table>
                    <tbody>
                        <tr>
                            <td width="130px">Product ID :</td>
                            <td><span id="sp_id"></span></td>
                        </tr>
                    </tbody>
                </table>
                <br />
            	<table>
                    <tbody>
                        <tr>
                            <td width="130px">Name :</td>
                            <td><span id="sp_name"></span></td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <table>
                    <tbody>
                        <tr>
                            <td width="130px">Description :</td>
                            <td><span id="sp_desc"></span></td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <table>
                    <tbody>
                        <tr>
                            <td width="130px">Price(MYR) :</td>
                            <td><span id="sp_price"></span></td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <table>
                    <tbody>
                        <tr>
                            <td width="130px">Available at :</td>
                            <td width="200px"><span id="sp_shopname"></span></td>
                            <td>
                            	<a href="javascript: void(0);" onclick="open_sinfo_click();" style="text-decoration:none;">
                                	<span id="open_shop_info" class="glyphicon glyphicon-chevron-down"></span>
                                </a>
                            </td>
                            <td>
                            	<a href="javascript: void(0);" onclick="close_sinfo_click();" style="text-decoration:none;">
                                	<span id="close_shop_info" class="glyphicon glyphicon-chevron-up" style="display:none;"></span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <div id="open_sinfo">
                <table>
                    <tbody>
                        <tr>
                            <td width="130px">Shop Description :</td>
                            <td><span id="sp_shopdesc"></span></td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <table>
                    <tbody>
                        <tr>
                            <td width="130px">Shop Contact :</td>
                            <td><span id="sp_shopcon"></span></td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <div id="sp_daily_time">
                	<table>
                        <tbody>
                            <tr>
                                <td width="130px">Open Hours :</td>
                                <td width="50px"><span id="sp_daily"></span></td>
                                <td><span id="sp_daily_start"></span> - <span id="sp_daily_end"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="sp_monsun_time">
                    <table>
                        <tbody>
                            <tr>
                                <td width="130px">Open Hours :</td>
                                <td width="120px"><span id="sp_mon"></span></td>
                                <td><span id="sp_mon_start"></span> - <span id="sp_mon_end"></span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="120px"><span id="sp_tue"></span></td>
                                <td><span id="sp_tue_start"></span> - <span id="sp_tue_end"></span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="120px"><span id="sp_wed"></span></td>
                                <td><span id="sp_wed_start"></span> - <span id="sp_wed_end"></span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="120px"><span id="sp_thur"></span></td>
                                <td><span id="sp_thur_start"></span> - <span id="sp_thur_end"></span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="120px"><span id="sp_fri"></span></td>
                                <td><span id="sp_fri_start"></span> - <span id="sp_fri_end"></span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="120px"><span id="sp_sat"></span></td>
                                <td><span id="sp_sat_start"></span> - <span id="sp_sat_end"></span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="120px"><span id="sp_sun"></span></td>
                                <td><span id="sp_sun_start"></span> - <span id="sp_sun_end"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br />
                <div id="sp_shopadd_tbl">
                	<table>
                        <tbody>
                            <tr>
                                <td width="130px">Shop Address :</td>
                                <td><span id="sp_shopadd"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="sp_shoploc_tbl">
                	<table>
                        <tbody>
                            <tr>
                                <td width="130px">Shop Location :</td>
                                <td><span id="sp_shoploc"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br />
                </div>
                <table>
                    <tbody>
                        <tr>
                            <td width="130px">Delivery service :</td>
                            <td><span id="sp_deliver"></span></td>
                        </tr>
                    </tbody>
                </table>
				<div id="sp_sdi_tbl">
					<table>
						<tbody>
							<tr>
								<td width="130px"></td>
								<td><span id="sp_deliverinfo"></span></td>
							</tr>
						</tbody>
					</table>
				</div>
				<br />
                <table>
                    <tbody>
                        <tr>
                            <td width="130px">Quantity :</td>
                            <td width="450px">
                            	<div id="specific_cart" class="input-group">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <p class="btn_right"><i>post by : <span id="sp_shopowner"></span> on <span id="sp_create"></span></i></p>
            </div>
        </div>
    </div>
    <br /><br />
</body>
</html>