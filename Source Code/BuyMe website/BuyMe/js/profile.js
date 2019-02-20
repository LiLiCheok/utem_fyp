$(document).ready(function() {
	var user_id = document.getElementById('buyer_id_3').textContent;
	
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
		url: "/BuyMe/get_profile.php",
		data: {user_id: user_id},
		success:
		function(result) {
			var json_obj = $.parseJSON(result);
			for(var i in json_obj) {
				var uname = json_obj[i].user_name;
				var uic = json_obj[i].ic_no;
				var uemail = json_obj[i].user_email;
				var ucontact = json_obj[i].contact_no;
				var upass = json_obj[i].user_password;
				var uaddress = json_obj[i].address;
				var upostcode = json_obj[i].postcode;
				var ucity = json_obj[i].city;
				var ustate = json_obj[i].state;
				$('#uname').val(uname);
				$('#uic').val(uic);
				$('#uemail').val(uemail);
				$('#old_umail').val(uemail);
				$('#ucontact').val(ucontact);
				$('#upassword').val(upass);
				$('#uaddress').val(uaddress);
				$('#upostcode').val(upostcode);
				$('#ucity').val(ucity);
				$('#ustate').val(ustate);
				if($('#uaddress').val()=="") {
					document.getElementById('uaddress').style.border = "2px solid red";
					document.getElementById('upostcode').style.border = "2px solid red";
					document.getElementById('ucity').style.border = "2px solid red";
					document.getElementById('ustate').style.border = "2px solid red";
				}
			}
		}
	});
	
	$('#update_uprofile_btn').click(function() {
		var new_name = $('#uname').val();
		var new_ic = $('#uic').val();
		var new_contact = $('#ucontact').val();
		var new_address = $('#uaddress').val();
		var new_postcode = $('#upostcode').val();
		var new_city = $('#ucity').val();
		var new_state = $('#ustate').val();
		var post_data = {user_id: user_id, new_name: new_name, new_ic: new_ic, new_contact: new_contact, new_address: new_address, new_postcode: new_postcode, new_city: new_city, new_state: new_state};
		if(new_name!=""&&new_ic!=""&&new_contact!=""&&new_address!=""&&new_postcode!=""&&new_city!=""&&new_state!="") {
			$.ajax({
				type: "POST",
				url: "/BuyMe/update_profile.php",
				data: post_data,
				success:
				function(result) {
					if(result=="updated") {
						swal({
							title: "Updated Successfully",
							text: "Your profile has been updated.",
							type: "success",
							timer: 3000
						}, function() {
							window.location.href="http://localhost:82/BuyMe/profile.php";
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
	
	$('#change_upass_btn').click(function() {
		var old_pass = $("#old_upass").val();
		var new_pass = $("#new_upass").val();
		var re_pass = $("#retype_upass").val();
		if(old_pass!=""&&new_pass!=""&&re_pass!="") {
			if(new_pass!=re_pass) {
				match_pass();
			} else {
				$.ajax({
					type: "POST",
					url: "/BuyMe/change_password.php",
					data: {user_id: user_id, old_pass: old_pass, new_pass: re_pass},
					success:
					function(result) {
						if(result=="same_pass") {
							swal({
								title: "Wrong Old Password",
								text: "Please re-type your old password.",
								type: "error",
								timer: 3000
							});
							document.getElementById("old_upass").style.border="2px solid red";
						} else if(result=="changed") {
							swal({
								title: "Password Changed",
								text: "You need to login again.",
								type: "success",
								timer: 3000
							}, function() {
								var u_id = document.getElementById('buyer_id_3').textContent;
								window.location.href="http://localhost:82/BuyMe/logout.php?userID="+u_id;
							});
						} else {
							alert(result);
						}
					}
				});
			}
		} else {
			$('input[type="password"]').each(function() {
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
	
	$('#change_uemail_btn').click(function() {
		var new_mail = $("#new_umail").val();
		if(new_mail!="") {
			document.getElementById('new_umail').style.border="";
			var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
			if(!new_mail.match(pattern)) {
				document.getElementById('umail_validation').style.display="block";
				window.setTimeout(function() {
					$("#umail_validation").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove(); 
					});
				}, 2000);
				document.getElementById('new_umail').style.border="2px solid red";
			} else {
				$.ajax({
					type: "POST",
					url: "/BuyMe/change_email.php",
					data: {user_id: user_id, new_mail: new_mail},
					success:
					function(result) {
						if(result=="changed") {
							swal({
								title: "E-mail Changed",
								text: "You need to login again.",
								type: "success",
								timer: 3000
							}, function() {
								var u_id = document.getElementById('buyer_id_3').textContent;
								window.location.href="http://localhost:82/BuyMe/logout.php?userID="+u_id;
							});
						} else {
							alert(result);
						}
					}
				});
			}
		} else {
			document.getElementById('new_umail').style.border="2px solid red";
		}
		return false;
	});
});

function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

function match_pass() {
	document.getElementById('upass_match').style.display="block";
	window.setTimeout(function() {
		$("#upass_match").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 2000);
	document.getElementById("new_upass").style.border="2px solid red";
	document.getElementById("retype_upass").style.border="2px solid red";
}