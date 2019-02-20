// JavaScript Document

$(document).ready(function() {
	var category_id = "all";
	var page_start = "";
	
	show_product(category_id, page_start);
	show_cart_no();
	show_order_no();
	
	$.ajax({
		url: "/BuyMe/get_category.php",
		success:
		function (result) {
			var json_obj = $.parseJSON(result);
			for (var i in json_obj) {
				$('#cat_id').append($('<option>').text(json_obj[i].category_name).attr('value', json_obj[i].category_id));
			}
		}
	});
});

function show_cart_no() {
	var user_id = document.getElementById('buyer_id').textContent;
	$.ajax({
		type: "POST",
		url: "/BuyMe/get_cart_no.php",
		data: {user_id: user_id},
		success:
		function(result) {
			if(result=="no_cart") {
			} else {
				$('#cart_notification').text(result);
			}
		}
	});
}

function show_order_no() {
	var user_id = document.getElementById('buyer_id').textContent;
	$.ajax({
		type: "POST",
		url: "/BuyMe/get_order_no.php",
		data: {user_id: user_id},
		success:
		function(result) {
			if(result=="no_order") {
			} else {
				$('#order_notification').text(result);
			}
		}
	});
}

function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

function show_product(category_id, page_start) {
	$.ajax({
		type: "POST",
		url: "/BuyMe/get_page_no.php",
		data: {category_id: category_id},
		success:
		function(result) {
			$('.pagination').html("");
			var all_page = result;
			for(page_next=1;page_next<=all_page;page_next++) {
				if(page_next==1) {
					$('.pagination').append(
						'<li>' +
							'<a class="page-link" href="javascript: void(0);"' +
								'onclick="show_product(\'' + category_id + '\',\'' + page_next + '\');">' +
								page_next +
							'</a>' +
						'</li>'
					);
				} else {
					$('.pagination').append(
						'<li>' +
							'<a class="page-link" href="javascript: void(0);"' +
								'onclick="show_product(\'' + category_id + '\',\'' + page_next + '\');">' +
								page_next +
							'</a>' +
						'</li>'
					);
				}
			}
		}
	});
	
	$.ajax({
		type: "POST",
		url: "/BuyMe/get_product.php",
		data: {category_id: category_id, page_start: page_start},
		success:
		function (result) {
			if(result=="no_product") {
				document.getElementById('show_none').style.display="block";
				document.getElementById('show_all').style.display="none";
			} else if(result!="no_product") {
				document.getElementById('show_none').style.display="none";
				document.getElementById('show_all').style.display="block";
				var json_obj = $.parseJSON(result);
				var cardHTML = '';
				for (var i in json_obj) {
					var product_id = json_obj[i].product_id;
					var shop_name = json_obj[i].shop_name;
					var product_name = json_obj[i].product_name;
					var product_price = json_obj[i].product_price;
					var product_image = json_obj[i].product_image;
					cardHTML +=
					'<div class="col-md-4">' +
						'<div class="card" onclick="all_info(\'' + product_id + '\');">' +
							'<img class="card-img-top" src="' + product_image + '" alt="Product Image" />' +
							'<div class="card-block">' +
								'<h4 class="card-title">' + product_name + '</h4>' +
								'<p class="card-text">Price(RM) : ' + product_price + '</p>' +
								'<p>Available at : ' + shop_name + '</p>' +
								'<br>' +
								'<div class="input-group">' +
									'<input type="text" class="form-control" id="quantity' + product_id + '" placeholder="Quantity" onkeypress="return isNumberKey(event);" onclick="event.stopPropagation();">' +
									'<span class="input-group-btn">' +
										'<input type="submit" class="btn btn_cart" onclick="add_cart_click(\'' + product_id + '\'); event.stopPropagation();" value="Add to cart" />' +
									'</span>' +
								'</div>' +
							'</div>' +
						'</div>' +
						'<br />' +
					'</div>';
				}
				$('#all_rowbyrow').html("");
				$('#all_rowbyrow').append(cardHTML);
			} else {
				alert(result);
			}
		}
	});
}

function all_info(product_id) {
	$.ajax({
		type: "POST",
		url: "/BuyMe/get_specific_product.php",
		data: {product_id: product_id},
		success:
		function (result) {
			if(result=="no_product") {
				document.getElementById('show_all').style.display="block";
				document.getElementById('product_details').style.display="none";
			} else if(result!="no_product") {
				document.getElementById('show_all').style.display="none";
				document.getElementById('cat_id').style.display="none";
				document.getElementById('product_details').style.display="flex";
				/* Different browser support */
				/*document.getElementById('product_details').style.display="-webkit-box"; OLD - iOS 6-, Safari 3.1-6 */
				/*document.getElementById('product_details').style.display="-moz-box"; OLD - Firefox 19- (buggy but mostly works) */
				/*document.getElementById('product_details').style.display="-ms-flexbox"; TWEENER - IE 10 */
				/*document.getElementById('product_details').style.display="-webkit-flex"; NEW - Chrome */
				document.getElementById('back_to_prevpage').style.display="block";
				var json_obj = JSON.parse(result);
				var cartHTML = '';
				for (var i in json_obj) {
					var category_name = json_obj[i].category_name;
					var product_id = json_obj[i].product_id;
					var product_name = json_obj[i].product_name;
					var product_desc = json_obj[i].product_desc;
					var product_price = json_obj[i].product_price;
					var post_at = json_obj[i].post_at;
					var shop_image = json_obj[i].shop_image;
					var shop_name = json_obj[i].shop_name;
					var ssm_no = json_obj[i].ssm_no;
					var shop_desc = json_obj[i].shop_desc;
					var shop_contact = json_obj[i].shop_contact;
					var delivery_service = json_obj[i].delivery_service;
					var user_name = json_obj[i].user_name;
					$('#sp_category').text(category_name);
					$('#sp_id').text(product_id);
					$('#sp_name').text(product_name);
					$('#sp_desc').text(product_desc);
					$('#sp_price').text(product_price);
					$('#sp_shopname').text(shop_name);
					$('#sp_shopdesc').text(shop_desc);
					$('#sp_shopcon').text(shop_contact);
					$('#sp_deliver').text(delivery_service);
					if(delivery_service=="yes") {
						document.getElementById("sp_sdi_tbl").style.display = "block";
						$("#sp_deliverinfo").text("("+json_obj[i].delivery_info+")");
					} else {
						document.getElementById("sp_sdi_tbl").style.display = "none";
					}
					$('#sp_shopowner').text(user_name);
					$('#sp_create').text(post_at);
					
					cartHTML +=
					'<input type="text" class="form-control" id="squantity' + product_id + '" placeholder="Quantity" onkeypress="return isNumberKey(event);">' +
					'<span class="input-group-btn">' +
						'<input type="submit" class="btn btn_cart" onclick="add_scart_click(\'' + product_id + '\');" value="Add to cart" />' +
					'</span>';
						
					var product_image = json_obj[i].product_image;
					document.getElementById('sp_image').src = product_image;
					
					var busi_time = json_obj[i].business_hour;
					var test_first = busi_time.substring(0, busi_time.indexOf('(,1)'));
					if(test_first=="Daily") {
						document.getElementById('sp_daily_time').style.display = "block";
						$('#sp_daily').text((busi_time.substring(0, busi_time.indexOf('(,1)'))));
						$('#sp_daily_start').text((busi_time.substring(busi_time.indexOf('(,1)')+4, busi_time.indexOf('(-1)'))));
						$('#sp_daily_end').text((busi_time.substring(busi_time.indexOf('(-1)')+4, busi_time.indexOf('(.1)'))));
					} else {
						document.getElementById('sp_monsun_time').style.display = "block";
						$('#sp_mon').text((busi_time.substring(0, busi_time.indexOf('(,1)'))));
						$('#sp_mon_start').text((busi_time.substring(busi_time.indexOf('(,1)')+4, busi_time.indexOf('(-1)'))));
						$('#sp_mon_end').text((busi_time.substring(busi_time.indexOf('(-1)')+4, busi_time.indexOf('(.1)'))));
						$('#sp_tue').text((busi_time.substring(busi_time.indexOf('(.1)')+4, busi_time.indexOf('(,2)'))));
						$('#sp_tue_start').text((busi_time.substring(busi_time.indexOf('(,2)')+4, busi_time.indexOf('(-2)'))));
						$('#sp_tue_end').text((busi_time.substring(busi_time.indexOf('(-2)')+4, busi_time.indexOf('(.2)'))));
						$('#sp_wed').text((busi_time.substring(busi_time.indexOf('(.2)')+4, busi_time.indexOf('(,3)'))));
						$('#sp_wed_start').text((busi_time.substring(busi_time.indexOf('(,3)')+4, busi_time.indexOf('(-3)'))));
						$('#sp_wed_end').text((busi_time.substring(busi_time.indexOf('(-3)')+4, busi_time.indexOf('(.3)'))));
						$('#sp_thur').text((busi_time.substring(busi_time.indexOf('(.3)')+4, busi_time.indexOf('(,4)'))));
						$('#sp_thur_start').text((busi_time.substring(busi_time.indexOf('(,4)')+4, busi_time.indexOf('(-4)'))));
						$('#sp_thur_end').text((busi_time.substring(busi_time.indexOf('(-4)')+4, busi_time.indexOf('(.4)'))));
						$('#sp_fri').text((busi_time.substring(busi_time.indexOf('(.4)')+4, busi_time.indexOf('(,5)'))));
						$('#sp_fri_start').text((busi_time.substring(busi_time.indexOf('(,5)')+4, busi_time.indexOf('(-5)'))));
						$('#sp_fri_end').text((busi_time.substring(busi_time.indexOf('(-5)')+4, busi_time.indexOf('(.5)'))));
						$('#sp_sat').text((busi_time.substring(busi_time.indexOf('(.5)')+4, busi_time.indexOf('(,6)'))));
						$('#sp_sat_start').text((busi_time.substring(busi_time.indexOf('(,6)')+4, busi_time.indexOf('(-6)'))));
						$('#sp_sat_end').text((busi_time.substring(busi_time.indexOf('(-6)')+4, busi_time.indexOf('(.6)'))));
						$('#sp_sun').text((busi_time.substring(busi_time.indexOf('(.6)')+4, busi_time.indexOf('(,7)'))));
						$('#sp_sun_start').text((busi_time.substring(busi_time.indexOf('(,7)')+4, busi_time.indexOf('(-7)'))));
						$('#sp_sun_end').text((busi_time.substring(busi_time.indexOf('(-7)')+4, busi_time.indexOf('(.7)'))));
					}
					
					var shop_location = json_obj[i].shop_location;
					var address = json_obj[i].address;
					var postcode = json_obj[i].postcode;
					var city = json_obj[i].city;
					var state = json_obj[i].state;
					var shop_address = address + " " + postcode + " " + city + " " + state;
					if(shop_location!=null) {
						document.getElementById('sp_shoploc_tbl').style.display = "block";
						$('#sp_shoploc').text(shop_location);
					} else {
						document.getElementById('sp_shopadd_tbl').style.display = "block";
						$('#sp_shopadd').text(shop_address);
					}
				}
				$('#specific_cart').append(cartHTML)
			} else {
				alert(result);
			}
		}
	});
}

function add_cart_click(product_id) {
	var user_id = document.getElementById('buyer_id').textContent;
	var proid = product_id;
	var quantity = document.getElementById('quantity'+product_id).value;
	if(quantity!="") {
		if(user_id!="") {
			$.ajax({
				type: "POST",
				url: "/BuyMe/create_cart.php",
				data: {user_id: user_id, product_id: proid, quantity: quantity},
				success:
				function(result) {
					if(result=="added") {
						swal({
							title: "",
							text: "This product has been added to cart.",
							imageUrl: "/BuyMe/image/cart_full.png",
							type: "success",
							timer: 4000
						}, function(){
							window.location.href="http://localhost:82/BuyMe";
						});
					} else if(result=="exist") {
						swal({
							title: "",
							text: "This product is already added to cart.",
							timer: 3000
						});
					} else {
						alert(result);
					}
				}
			});
		} else {
			swal({
				title: "",
				text: "You may need to login.",
				type: "warning",
				confirmButtonColor: "#C39BD3",
				confirmButtonText: "Go to Login page",
				closeOnConfirm: false,
				showCancelButton: true
			}, function(){
				window.location.href="http://localhost:82/BuyMe/login.php";
			});
		}
	} else {
		document.getElementById('quantity'+product_id).style.border="2px solid red";
	}
}

function add_scart_click(product_id) {
	var user_id = document.getElementById('buyer_id').textContent;
	var proid = product_id;
	var quantity = document.getElementById('squantity'+product_id).value;
	if(quantity!="") {
		if(user_id!="") {
			$.ajax({
				type: "POST",
				url: "/BuyMe/create_cart.php",
				data: {user_id: user_id, product_id: proid, quantity: quantity},
				success:
				function(result) {
					if(result=="added") {
						swal({
							title: "",
							text: "You product has been added to cart.",
							imageUrl: "/BuyMe/image/cart_full.png",
							type: "success",
							timer: 4000
						}, function(){
							window.location.href="http://localhost:82/BuyMe";
						});
					} else if(result=="exist") {
						swal({
							title: "",
							text: "This product is already added to cart.",
							timer: 3000
						});
					} else {
						alert(result);
					}
				}
			});
		} else {
			swal({
				title: "",
				text: "You may need to login.",
				type: "warning",
				confirmButtonColor: "#C39BD3",
				confirmButtonText: "Go to Login page",
				closeOnConfirm: false,
				showCancelButton: true
			}, function(){
				window.location.href="http://localhost:82/BuyMe/login.php";
			});
		}
	} else {
		document.getElementById('squantity'+product_id).style.border="2px solid red";
	}
}

function open_sinfo_click() {
	document.getElementById('open_shop_info').style.display="none";
	document.getElementById('close_shop_info').style.display="block";
	document.getElementById('open_sinfo').style.display="block";
}

function close_sinfo_click() {
	document.getElementById('open_shop_info').style.display="block";
	document.getElementById('close_shop_info').style.display="none";
	document.getElementById('open_sinfo').style.display="none";
}