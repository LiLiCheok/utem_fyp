// JavaScript Document

$(document).ready(function() {
	var user_id = document.getElementById('buyer_id_2').textContent;
	
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
		url: "/BuyMe/get_order.php",
		data: {user_id: user_id},
		success:
		function(result) {
			if(result=="no_order") {
				document.getElementById('no_order').style.display = "block";
			} else {
				document.getElementById('user_order').style.display = "block";
				var json_obj = $.parseJSON(result);
				var co_info='';
				number = 1;
				for(var i in json_obj) {
					set_status(json_obj[i].order_id);
					co_info +=
					'<tbody>' +
						'<td class="position">'+ number +'</td>' +
						'<td class="position">'+ json_obj[i].order_id +'</td>' +
						'<td class="position">'+ json_obj[i].order_time +'</td>' +
						'<td class="position"><a href="javascript: void(0);" onclick="view_order(\''+ json_obj[i].order_id +'\')"><button class="btn seller_pro_btn">View</button></a></td>' +
						'<td class="position"><input type="text" id="uostatus'+json_obj[i].order_id+'" class="form-control status" readonly /></span></td>' +
					'</tbody>';
					number += 1;
				}
				$('#order_info').append(co_info);
			}
		}
	});
});

function set_status(order_id) {
	$.ajax({
		type: "POST",
		url: "/BuyMe/set_order_status.php",
		data: {order_id: order_id},
		success:
		function(result) {
			if(result=="settle") {
				document.getElementById('uostatus'+order_id).style.border="2px solid green";
				document.getElementById('uostatus'+order_id).value="Received";
			} else if(result=="not_settle") {
				document.getElementById('uostatus'+order_id).style.border="2px solid red";
				document.getElementById('uostatus'+order_id).value="Waiting";
			} else {
				alert(result);
			}
		}
	});
}

function view_order(order_id) {
	document.getElementById('user_order').style.display = "none";
	document.getElementById('order_detail').style.display = "block";
	var user_id = document.getElementById('buyer_id_2').textContent;
	var oid = order_id;
	$.ajax({
		type: "POST",
		url: "/BuyMe/get_order_info.php",
		data: {user_id: user_id, order_id: oid},
		success:
		function(result) {
			if(result=="no_order") {
			} else {
				var json = $.parseJSON(result);
				var co_info='';
				number = 1;
				total = 0;
				grandtotal = 0;
				for(var i in json) {
					document.getElementById('uoid').textContent = json[i].order_id;
					document.getElementById('uotime').textContent = json[i].order_time;
					var delivery = "";
					if(json[i].del_charge!=null) {
						delivery = "yes ("+ json[i].del_charge +"%)";
						total = (Number(json[i].subtotal))+((Number(json[i].subtotal))*(Number((json[i].del_charge)/100)));
					} else if(json[i].del_charge==null) {
						delivery = "no";
						total = Number(json[i].subtotal);
					}
					co_info +=
					'<tbody>' +
						'<td class="position">'+ number +'</td>' +
						'<td class="position">'+ json[i].product_id +'</td>' +
						'<td class="position">'+ json[i].product_name +'</td>' +
						'<td class="position">'+ json[i].product_price +'</td>' +
						'<td class="position">'+ json[i].quantity +'</td>' +
						'<td class="position">'+ json[i].subtotal +'</td>' +
						'<td class="position">'+ delivery +'</td>' +
						'<td class="position">'+ total.toFixed(2) +'</td>' +
						'<td class="position">'+ json[i].status +'</td>' +
					'</tbody>';
					number += 1;
					grandtotal += total;
				}
				$('#userorder_dinfo').append(co_info);
				co_total =
				'<tbody>' +
					'<td></td>' +
					'<td></td>' +
					'<td></td>' +
					'<td></td>' +
					'<td></td>' +
					'<td colspan="2"><h4 align="right">Total (MYR) :</h4></td>' +
					'<td class="position"><h4 align="center">'+ grandtotal.toFixed(2) +'</h4></td>' +
					'<td></td>' +
				'</tbody>';
				$('#userorder_dinfo').append(co_total);
			}
		}
	});
}