// JavaScript Document

$(document).ready(function() {
	var user_id = document.getElementById('user_id_1').textContent;
	
	$.ajax({
		type: "POST",
		url: "/BuyMe/seller/get_cusorder_no.php",
		data: {user_id: user_id},
		success:
		function(result) {
			if(result=="no_order") {
			} else {
				$('#cusorder_notification').text(result);
			}
		}
	});
	
	$.ajax({
		type: "POST",
		url: "/BuyMe/seller/get_cusorder.php",
		data: {user_id: user_id},
		success:
		function(result) {
			if(result=="no_order") {
				document.getElementById('no_cusorder').style.display = "block";
			} else {
				document.getElementById('cus_order').style.display = "block";
				var json = $.parseJSON(result);
				var co_info='';
				number = 1;
				for(var i in json) {
					set_status(json[i].order_id);
					co_info +=
					'<tbody>' +
						'<td class="position">'+ number +'</td>' +
						'<td class="position">'+ json[i].order_id +'</td>' +
						'<td class="position">'+ json[i].order_time +'</td>' +
						'<td class="position"><a href="javascript: void(0);" onclick="view_order(\''+ json[i].order_id +'\')"><button class="btn seller_pro_btn">View</button></a></td>' +
						'<td class="position"><input type="text" id="status'+json[i].order_id+'" class="form-control status" readonly /></span></td>' +
					'</tbody>';
					number += 1;
				}
				$('#cusorder_info').append(co_info);
			}
		}
	});
});

function set_status(oid) {
	var user_id = document.getElementById('user_id_1').textContent;
	$.ajax({
		type: "POST",
		url: "/BuyMe/seller/set_cusorder_status.php",
		data: {user_id: user_id, order_id: oid},
		success:
		function(result) {
			if(result=="settle") {
				document.getElementById('status'+oid).style.border="2px solid green";
				document.getElementById('status'+oid).value="Complete";
			} else if(result=="not_settle") {
				document.getElementById('status'+oid).style.border="2px solid red";
				document.getElementById('status'+oid).value="Pending";
			} else {
				alert(result);
			}
		}
	});
}

function view_order(order_id) {
	document.getElementById('cus_order').style.display = "none";
	document.getElementById('cusorder_detail').style.display = "block";
	var user_id = document.getElementById('user_id_1').textContent;
	var oid = order_id;
	$.ajax({
		type: "POST",
		url: "/BuyMe/seller/get_cusorder_detail.php",
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
					var address = json[i].address + " " + json[i].postcode + " " + json[i].city + " " + json[i].state;
					document.getElementById('oid').textContent = json[i].order_id;
					document.getElementById('otime').textContent = json[i].order_time;
					document.getElementById('cusname').textContent = json[i].user_name;
					document.getElementById('cusic').textContent = json[i].ic_no;
					document.getElementById('cuscontact').textContent = json[i].contact_no;
					document.getElementById('cusaddress').textContent = address;
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
						'<td class="position"><select type="text" class="status" id="postatus" onchange="check(\''+ json[i].product_id +'\');"><option>'+json[i].status+'</option><option>---Choose---</option><option value="Taken/Sent">Taken/Sent</option><option value="In Progress">In Progress</option></select></td>' +
					'</tbody>';
					number += 1;
					grandtotal += total;
				}
				$('#cusorder_dinfo').append(co_info);
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
				$('#cusorder_dinfo').append(co_total);
			}
		}
	});
}

function check(pid) {
	var order_id = document.getElementById('oid').textContent;
	var status = document.getElementById('postatus').value;
	$.ajax({
		type: "POST",
		url: "/BuyMe/seller/update_cusorder.php",
		data: {order_id: order_id, product_id: pid, status: status},
		success:
		function(result) {
			if(result=="updated") {
			} else {
				alert(result);
			}
		}
	});
}