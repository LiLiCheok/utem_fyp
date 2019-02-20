// JavaScript Document

$(document).ready(function() {
	var user_id = document.getElementById('buyer_id_4').textContent;
	
	$.ajax({
		type: "POST",
		url: "/BuyMe/get_cart_no.php",
		data: {user_id: user_id},
		success:
		function(result) {
			if(result=="no_cart") {
			} else {
				if(result!=1) {
					$('#number_order').text(result+" "+"products");
				} else {
					$('#number_order').text(result+" "+"product");
				}
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
			} else if(result!="no_product") {
				var json = $.parseJSON(result);
				var co_info='';
				grandtotal = 0;
				for(var i in json) {
					var delivery_info = json[i].delivery_info;
					var subtotal = json[i].subtotal;
					free = (delivery_info.substring(0, delivery_info.indexOf(' delivery')));
					if(json[i].del_charge!=null) {
						if(free=="Free") {
							delivery = "yes"+" "+"("+"0"+"%)";
							total = subtotal;
						} else {
							charge = (delivery_info.substring(0, delivery_info.indexOf('%')));
							delivery = "yes"+" "+"("+charge+"%)";
							total = Number(subtotal) + (Number(subtotal)*Number(charge)/100);
						}
					} else {
						delivery = "-";
						total = subtotal;
					}
					//Math.round(Number(charge)/100)
					co_info +=
					'<tbody>' +
						'<td>'+ json[i].product_name +'</td>' +
						'<td class="position">'+ json[i].product_price +'</td>' +
						'<td class="position">'+ json[i].quantity +'</th>' +
						'<td class="position">'+ json[i].subtotal +'</td>' +
						'<td class="position">'+ delivery +'</td>' +
						'<td class="position">'+ parseFloat(total).toFixed(2) +'</td>' +
					'</tbody>';
					grand_subtotal = Number(total);
					grandtotal += grand_subtotal;
				}
				$('#checkout_order_info').append(co_info);
				co_total =
				'<tbody>' +
					'<td></td>' +
					'<td></td>' +
					'<td></td>' +
					'<td></td>' +
					'<td class="position"><h4 align="center">Total (MYR) :</h4></td>' +
					'<td class="position"><h4 align="center" id="checkout_total">'+ grandtotal.toFixed(2) +'</h4></td>' +
				'</tbody>';
				$('#checkout_order_info').append(co_total);
			}
		}
	});
	
	$('#add_address_btn').click(function () {
		var address = document.getElementById('add_address').value;
		var postcode = document.getElementById('add_postcode').value;
		var city = document.getElementById('add_city').value;
		var state = document.getElementById('add_state').value;
		if(address!=""&&postcode!=""&&city!=""&&state!="") {
			$.ajax({
				type: "POST",
				url: "/BuyMe/create_address.php",
				data: {user_id: user_id, address: address, postcode: postcode, city: city, state: state},
				success:
				function(result) {
					if(result=="added") {
						var total = document.getElementById('checkout_total').textContent;
						$.ajax({
							type: "POST",
							url: "/BuyMe/create_order.php",
							data: {user_id: user_id, total: total},
							success:
							function(result) {
								if(result=="ordered") {
									swal({
										title: "Order Sent",
										text: "Your order has been sent.",
										type: "success",
										timer: 3000
									}, function() {
										window.location.href = "/BuyMe";
									});
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
		} else {
			$('input[type="text"]').each(function() {
				if($.trim($(this).val())=='') {
					valid = false;
					$(this).css({
						"border": "2px solid red"
					});
				} else {
					$(this).css({
						"border": ""
					});
				}
			});
		}
		return false;
	});
});

function back_to_cart() {
	document.location.href="cart.php";
}

function order() {
	swal({
		title: "Confirm Order",
		text: "Are you sure that you want to order?",
		imageUrl: "/BuyMe/image/order.png",
		confirmButtonColor: "#F39C12",
		confirmButtonText: "Yes",
		cancelButtonColor: "#CB4335",
		cancelButtonText: "No",
		closeOnConfirm: false,
		showCancelButton: true
	}, function(){
		var user_id = document.getElementById('buyer_id_4').textContent;
		$.ajax({
			type: "POST",
			url: "/BuyMe/get_address.php",
			data: {user_id: user_id},
			success:
			function(result) {
				if(result=="address_added") {
					var total = document.getElementById('checkout_total').textContent;
					$.ajax({
						type: "POST",
						url: "/BuyMe/create_order.php",
						data: {user_id: user_id, total: total},
						success:
						function(result) {
							if(result=="ordered") {
								swal({
									title: "Order Sent",
									text: "Your order has been sent.",
									type: "success",
									timer: 3000
								}, function() {
									window.location.href = "/BuyMe";
								});
							} else {
								alert(result);
							}
						}
					});
				} else if(result="address_null") {
					swal.close();
					$('#add_address_form').modal();
				} else {
					alert(result);
				}
			}
		});
	});
}

function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}