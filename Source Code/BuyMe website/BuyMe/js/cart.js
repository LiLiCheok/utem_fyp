// JavaScript Document

$(document).ready(function() {
	var user_id = document.getElementById('buyer_id_1').textContent;
	
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
	
	$.ajax({
		type: "POST",
		url: "/BuyMe/get_cart_total.php",
		data: {user_id: user_id},
		success:
		function(result) {
			if(result=="no_total") {
			} else if(result!="no_total"){
				document.getElementById('cart_total').textContent = parseFloat(result).toFixed(2);
			}
		}
	});
	
	$.ajax({
		type: "POST",
		url: "/BuyMe/get_cart.php",
		data: {user_id: user_id},
		success:
		function (result) {
			if(result=="no_product") {
				document.getElementById('no_cart').style.display = "block";
			} else if(result!="no_product") {
				document.getElementById('user_cart').style.display = "block";
				var json = $.parseJSON(result);
				var co_info='';
				for(var i in json) {
					var product_id = json[i].product_id;
					var product_name = json[i].product_name;
					var product_price = json[i].product_price;
					var product_image = json[i].product_image;
					var shop_id = json[i].shop_id;
					var shop_name = json[i].shop_name;
					var delivery_service = json[i].delivery_service;
					var quantity = json[i].quantity;
					var subtotal = json[i].subtotal;
					var del_charge = json[i].del_charge;
					var delivery_info = json[i].delivery_info;
					number_item = (delivery_info.substring(delivery_info.indexOf('RM')+2, delivery_info.indexOf(' and')));
					free = (delivery_info.substring(0, delivery_info.indexOf(' delivery')));
					charge = (delivery_info.substring(0, delivery_info.indexOf('%')));
					var del_ser = '';
					var del_info = '';
					if(free=="Free") {
						charge_info = 0;
					} else {
						charge_info = Number(charge);
					}
					if(del_charge!=null) {
						del_info = '<input type="checkbox" id="del_check'+product_id+'" onchange="check_all(this, \''+ shop_id + '\')" name="' + shop_id + '" checked /><p></p><p>Yes, I want delivery service.</p>';
					} else {
						if(delivery_service=="yes") {
							del_ser = "Delivery service is provided.";
							if(Number(subtotal)<Number(number_item)) {
								del_info = '<input type="checkbox" id="del_check'+product_id+'" onchange="check_all(this, \''+ shop_id + '\');" name="' + shop_id + '" disabled/><p></p><p id="word_del' + product_id + '">Your total quantity of items in ' + shop_name + ' is not enough for delivery.</p>';
							} else if(Number(subtotal)>=Number(number_item)) {
								del_info = '<input type="checkbox" id="del_check'+product_id+'" onchange="check_all(this, \''+ shop_id + '\')" name="' + shop_id + '" /><p></p><p>Yes, I want delivery service.</p>';
							}
							check_shop_quantity(product_id, shop_name, shop_id, number_item);
						} else {
							del_ser = "No delivery service."; 
							del_info = "-";
						}
					}
					co_info +=
					'<tbody>' +
					'<td>' +
						'<div class="row">' +
							'<div class="col-sm-6 hidden-xs"><img src="'+product_image+'" width="100%" height="180px"/></div>' +
							'<div class="col-sm-6">' +
								'<h4 class="nomargin">' + product_name + '</h4>' +
								'<p>' + shop_name + '</p>' +
								'<p><i>' + del_ser + '</i></p>' +
								'<p id="dinfo'+product_id+'" class="important_word"><i><b>' + delivery_info + '</b></i></p>' +
							'</div>' +
						'</div>' +
					'</td>' +
					'<td class="position"><span id="price'+product_id+'">' + product_price + '</span></td>' +
					'<td class="position">' +
						'<div class="input-group">' +
							'<span class="input-group-btn">' +
								'<button type="button" class="btn btn-default" data-value="decrease" data-target="#spinner'+product_id+'" data-toggle="spinner">' +
									'<span class="glyphicon glyphicon-minus"></span>' +
								'</button>' +
							'</span>' +
							'<input type="text" data-ride="spinner" id="spinner'+product_id+'" class="form-control input-number" value="' + quantity + '"'+
								'onchange="update_cart(\''+ product_id + '\',this.value);">' +
							'<span class="input-group-btn">' +
								'<button type="button" class="btn btn-default" data-value="increase" data-target="#spinner'+product_id+'" data-toggle="spinner">' +
									'<span class="glyphicon glyphicon-plus"></span>' +
								'</button>' +
							'</span>' +
						'</div>' +
					'</td>' +
					'<td class="position"><span id="sub'+product_id+'">' + subtotal + '</span><span name="charge'+shop_id+'" class="display"> + ' + charge_info + '%</span></td>' +
					'<td class="position">' + del_info + '</td>' +
					'<td class="position"><a href="javascript: void(0);" onclick="delete_cart(\''+ product_id +'\',\''+ shop_id +'\',\''+ number_item +'\');"><img src="image/delete_cart.png" width="25px" height="25px" alt="delete" /></a></td>' +
					'</tbody>';
				}
				$('#cart_order_info').append(co_info);
				$.ajax({
					type: "POST",
					url: "/BuyMe/get_cart_product.php",
					data: {user_id: user_id},
					success:
					function (result) {
						if(result=="no_product") {
						} else if(result!="no_product") {
							var a = $.parseJSON(result);
							for(var i in a) {
								var s_id = a[i].shop_id;
								var p_id = a[i].product_id;
								var allCharge = document.querySelectorAll("span[name=charge"+ s_id +"]");
								if(document.getElementById('del_check'+p_id).checked) {
									for(var d=0;d<allCharge.length;d++) {
										allCharge[d].style.display="block";
									}
								} else {
									for(var d=0;d<allCharge.length;d++) {
										allCharge[d].style.display="none";
									}
								}
							}
						} else {
							alert(result);
						}
					}
				});
			} else {
				alert(result);
			}
		}
	});
});

function check_shop_quantity(product_id, shop_name, shop_id, number_item) {
	var user_id = document.getElementById('buyer_id_1').textContent;
	$.ajax({
		type: "POST",
		url: "/BuyMe/get_delivery_qty.php",
		data: {user_id: user_id, shop_id: shop_id},
		success:
		function(result) {
			if(Number(result)>=Number(number_item)) {
				document.getElementById('del_check'+product_id).disabled="";
				document.getElementById('word_del'+product_id).textContent="Yes, I want delivery service.";
			} else if(Number(result)<Number(number_item)) {
				document.getElementById('del_check'+product_id).disabled="disabled";
				document.getElementById('word_del'+product_id).textContent="Your total quantity of items in " + shop_name + " is not enough for delivery.";
			}
		}
	});
}

function check_all(cb, shop) {
	var user_id = document.getElementById('buyer_id_1').textContent;
    var allCB = document.querySelectorAll("input[name="+ shop +"]");
	var allCharge = document.querySelectorAll("span[name=charge"+ shop +"]");
	if(cb.checked) {
		for(var i=0; i< allCB.length; i++){
			allCB[i].checked=true;
			$.ajax({
				type: "POST",
				url: "/BuyMe/update_cart_charge.php",
				data: {user_id: user_id, shop_id: shop, dc: "yes"},
				success:
				function(result) {
					if(result=="updated") {
						window.location.href="cart.php";
					} else {
						alert(result);
					}
				}
			});
		}
		for(var d=0;d<allCharge.length;d++) {
			allCharge[d].style.display="block";
		}
	} else {
		for(var i=0; i< allCB.length; i++){
			allCB[i].checked=false;
			$.ajax({
				type: "POST",
				url: "/BuyMe/update_cart_charge.php",
				data: {user_id: user_id, shop_id: shop, dc: ""},
				success:
				function(result) {
					if(result=="updated") {
						window.location.href="cart.php";
					} else {
						alert(result);
					}
				}
			});
		}
		for(var d=0;d<allCharge.length;d++) {
			allCharge[d].style.display="none";
		}
	}
 }

function update_cart(product_id, quantity) {
	var user_id = document.getElementById('buyer_id_1').textContent;
	$.ajax({
		type: "POST",
		url: "/BuyMe/update_cart.php",
		data: {user_id: user_id, product_id: product_id, quantity: quantity},
		success:
		function(result) {
			if(result=="updated") {
				window.location.href="cart.php";
			} else {
				alert(result);
			}
		}
	});
}

function delete_cart(product_id, shop_id, shop_item) {var user_id = document.getElementById('buyer_id_1').textContent;
	$.ajax({
		type: "POST",
		url: "/BuyMe/delete_cart.php",
		data: {user_id: user_id, product_id: product_id, shop_id: shop_id, shop_item: shop_item},
		success:
		function(result) {
			if(result=="deleted") {
				window.location.href="cart.php";
			} else {
				alert(result);
			}
		}
	});
}