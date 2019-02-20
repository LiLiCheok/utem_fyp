// JavaScript Document

$(document).ready(function() {
	
	var user_id = document.getElementById('user_id').textContent;
	
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
	
	// Show time only
	$('.timepick').datetimepicker({
		format: 'HH:ii p',
		autoclose: true,
		showMeridian: true,
		startView: 1,
		maxView: 1
	});

	$.ajax({
		type: "POST",
		url: "/BuyMe/seller/get_profile.php",
		data: {user_id: user_id},
		success:
		function(result) {
			var json_obj = $.parseJSON(result);
			for (var i in json_obj) {
				if(json_obj[i].user_id!="") {
					document.getElementById('ur_name').value = json_obj[i].user_name;
					document.getElementById('ur_ic').value = json_obj[i].ic_no;
					document.getElementById('ur_contact').value = json_obj[i].contact_no;
					document.getElementById('ur_email').value = json_obj[i].user_email;
					document.getElementById('ur_old_mail').value = json_obj[i].user_email;
					document.getElementById('ur_password').value = json_obj[i].user_password;
					document.getElementById('ur_logo').src = json_obj[i].shop_image;
					document.getElementById('ur_company').value = json_obj[i].shop_name;
					document.getElementById('ur_ssm').value = json_obj[i].ssm_no;
					document.getElementById('ur_desc').value = json_obj[i].shop_desc;
					var busi_time = json_obj[i].business_hour;
					if(busi_time.substring(0, busi_time.indexOf('(,1)'))=="Daily") {
						document.getElementById('mon_sun').style.display="none";
						document.getElementById('everyday').style.display="block";
						document.getElementById('ur_daily').value = (busi_time.substring(0, busi_time.indexOf('(,1)')));
						document.getElementById('ur_start').value = (busi_time.substring(busi_time.indexOf('(,1)')+4, busi_time.indexOf('(-1)')));
						document.getElementById('ur_end').value = (busi_time.substring(busi_time.indexOf('(-1)')+4, busi_time.indexOf('(.1)')));
					} else {
						document.getElementById('everyday').style.display="none";
						document.getElementById('mon_sun').style.display="block";
						document.getElementById('ur_monday').value = (busi_time.substring(0, busi_time.indexOf('(,1)')));
						document.getElementById('ur_mon_start').value = (busi_time.substring(busi_time.indexOf('(,1)')+4, busi_time.indexOf('(-1)')));
						document.getElementById('ur_mon_end').value = (busi_time.substring(busi_time.indexOf('(-1)')+4, busi_time.indexOf('(.1)')));
						document.getElementById('ur_tuesday').value = (busi_time.substring(busi_time.indexOf('(.1)')+4, busi_time.indexOf('(,2)')));
						document.getElementById('ur_tue_start').value = (busi_time.substring(busi_time.indexOf('(,2)')+4, busi_time.indexOf('(-2)')));
						document.getElementById('ur_tue_end').value = (busi_time.substring(busi_time.indexOf('(-2)')+4, busi_time.indexOf('(.2)')));
						document.getElementById('ur_wednesday').value = (busi_time.substring(busi_time.indexOf('(.2)')+4, busi_time.indexOf('(,3)')));
						document.getElementById('ur_wed_start').value = (busi_time.substring(busi_time.indexOf('(,3)')+4, busi_time.indexOf('(-3)')));
						document.getElementById('ur_wed_end').value = (busi_time.substring(busi_time.indexOf('(-3)')+4, busi_time.indexOf('(.3)')));
						document.getElementById('ur_thursday').value = (busi_time.substring(busi_time.indexOf('(.3)')+4, busi_time.indexOf('(,4)')));
						document.getElementById('ur_thur_start').value = (busi_time.substring(busi_time.indexOf('(,4)')+4, busi_time.indexOf('(-4)')));
						document.getElementById('ur_thur_end').value = (busi_time.substring(busi_time.indexOf('(-4)')+4, busi_time.indexOf('(.4)')));
						document.getElementById('ur_friday').value = (busi_time.substring(busi_time.indexOf('(.4)')+4, busi_time.indexOf('(,5)')));
						document.getElementById('ur_fri_start').value = (busi_time.substring(busi_time.indexOf('(,5)')+4, busi_time.indexOf('(-5)')));
						document.getElementById('ur_fri_end').value = (busi_time.substring(busi_time.indexOf('(-5)')+4, busi_time.indexOf('(.5)')));
						document.getElementById('ur_saturday').value = (busi_time.substring(busi_time.indexOf('(.5)')+4, busi_time.indexOf('(,6)')));
						document.getElementById('ur_sat_start').value = (busi_time.substring(busi_time.indexOf('(,6)')+4, busi_time.indexOf('(-6)')));
						document.getElementById('ur_sat_end').value = (busi_time.substring(busi_time.indexOf('(-6)')+4, busi_time.indexOf('(.6)')));
						document.getElementById('ur_sunday').value = (busi_time.substring(busi_time.indexOf('(.6)')+4, busi_time.indexOf('(,7)')));
						document.getElementById('ur_sun_start').value = (busi_time.substring(busi_time.indexOf('(,7)')+4, busi_time.indexOf('(-7)')));
						document.getElementById('ur_sun_end').value = (busi_time.substring(busi_time.indexOf('(-7)')+4, busi_time.indexOf('(.7)')));
						
					}
					document.getElementById('ur_phone').value = json_obj[i].shop_contact;
					if(json_obj[i].delivery_service == "yes") {
						document.getElementById('ur_del_yes').checked = "checked";
						document.getElementById('ur_del_no').checked = "";
						document.getElementById('ur_delivery_info').style.display = "block";
						if(document.getElementById('ur_quantity_text').value!="") {
							document.getElementById('ur_quantity_text').style.border="2px solid red";
							document.getElementById('ur_charge_text').style.border="2px solid red";
						} if(document.getElementById('ur_quantity_cent').value!="") {
							document.getElementById('ur_quantity_cent').style.display="2px solid red";
							document.getElementById('ur_charge_text').style.border="2px solid red";
						} else {}
					} else if(json_obj[i].delivery_service == "no") {
						document.getElementById('ur_del_yes').checked = "";
						document.getElementById('ur_del_no').checked = "checked";
						document.getElementById('ur_delivery_info').style.display = "none";
					}
					if(json_obj[i].shop_location == null) {
						document.getElementById('lo').style.display="none";
						document.getElementById('ad').style.display="block";
						document.getElementById('ur_address').value = json_obj[i].address;
						document.getElementById('ur_postcode').value = json_obj[i].postcode;
						document.getElementById('ur_city').value = json_obj[i].city;
						document.getElementById('ur_state').value = json_obj[i].state;
					} else if(json_obj[i].shop_location != null) {
						document.getElementById('lo').style.display="block";
						document.getElementById('ad').style.display="none";
						document.getElementById('ur_location').value = json_obj[i].shop_location;
					}
					var delivery_info = json_obj[i].delivery_info;
					if(delivery_info.substring(0, 4) == "Free") {
						document.getElementById('ur_delivery_charge').value = "Free";
						document.getElementById('ur_charge').style.display = "none";
						document.getElementById('ur_other_charge').style.display = "none";
						document.getElementById('ur_free').style.display = "block";
						document.getElementById('ur_quantity_text').value = (delivery_info.substring(delivery_info.indexOf('RM')+2, delivery_info.indexOf('.')));
						document.getElementById('ur_quantity_cent').value = (delivery_info.substring(delivery_info.indexOf('.')+1, delivery_info.indexOf(' and')));
					} else {
						document.getElementById('ur_delivery_charge').value = "Other";
						document.getElementById('ur_charge').style.display = "block";
						document.getElementById('ur_other_charge').style.display = "block";
						document.getElementById('ur_free').style.display = "none";
						document.getElementById('ur_charge_text').value = (delivery_info.substring(0, delivery_info.indexOf('%')));
						document.getElementById('ur_quantity_text').value = (delivery_info.substring(delivery_info.indexOf('RM')+2, delivery_info.indexOf('.')));
						document.getElementById('ur_quantity_cent').value = (delivery_info.substring(delivery_info.indexOf('.')+1, delivery_info.indexOf(' and')));
					}
				} else {
					alert(result);
				}
			}
		}
	});
	
	$('#ur_phone').keyup(function() {
		var len = this.value.length;
		if (len >= 10) {
			this.style.border="";
			this.value = this.value.substring(0, 10);
		} else if(len==0){
			this.style.border="2px solid red";
		} else {
			this.style.border="";
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, shop_contact: this.value},
				success: function(result) {}
			});
		}
	});
	$('#ur_desc').keyup(function() {
		var len = this.value.length;
		if (len >= 600) {
			this.style.border="";
			this.value = this.value.substring(0, 600);
		} else if(len==0){
			this.style.border="2px solid red";
		} else {
			this.style.border="";
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, shop_desc: this.value},
				success: function(result) {}
			});
		}
	});
	$('#ur_postcode').keyup(function() {
		var len = this.value.length;
		if (len >= 5) {
			this.style.border="";
			this.value = this.value.substring(0, 5);
		} else if(len==0){
			this.style.border="2px solid red";
		} else {
			this.style.border="";
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, postcode: this.value},
				success: function(result) {}
			});
		}
	});
	$('#ur_city').keyup(function() {
		var len = this.value.length;
		if (len >= 50) {
			this.style.border="";
			this.value = this.value.substring(0, 50);
		} else if(len==0){
			this.style.border="2px solid red";
		} else {
			this.style.border="";
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, city: this.value},
				success: function(result) {}
			});
		}
	});
	$('#ur_contact').keyup(function() {
		var len = this.value.length;
		if (len >= 11) {
			this.style.border="";
			this.value = this.value.substring(0, 11);
		} else if(len==0){
			this.style.border="2px solid red";
		} else {
			this.style.border="";
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, contact_no: this.value},
				success: function(result) {}
			});
		}
	});
	$('#ur_name').keyup(function() {
		var len = this.value.length;
		if (len >= 100) {
			this.style.border="";
			this.value = this.value.substring(0, 100);
		} else if(len==0){
			this.style.border="2px solid red";
		} else {
			this.style.border="";
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, user_name: this.value},
				success: function(result) {}
			});
		}
	});
	$('#ur_company').keyup(function() {
		var len = this.value.length;
		if (len >= 100) {
			this.style.border="";
			this.value = this.value.substring(0, 100);
		} else if(len==0){
			this.style.border="2px solid red";
		} else {
			this.style.border="";
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, shop_name: this.value},
				success: function(result) {}
			});
		}
	});
	$('#ur_address').keyup(function() {
		var len = this.value.length;
		if (len >= 100) {
			this.style.border="";
			this.value = this.value.substring(0, 100);
		} else if(len==0){
			this.style.border="2px solid red";
		} else {
			this.style.border="";
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, address: this.value},
				success: function(result) {}
			});
		}
	});
	$('#ur_ic').keyup(function() {
		var len = this.value.length;
		if (len >= 15) {
			this.style.border="";
			this.value = this.value.substring(0, 15);
		} else if(len==0){
			this.style.border="2px solid red";
		} else {
			this.style.border="";
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, ic_no: this.value},
				success: function(result) {}
			});
		}
	});
	$('#ur_ssm').keyup(function() {
		var len = this.value.length;
		if (len >= 15) {
			this.style.border="";
			this.value = this.value.substring(0, 15);
		} else if(len==0){
			this.style.border="2px solid red";
		} else {
			this.style.border="";
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, ssm_no: this.value},
				success: function(result) {}
			});
		}
	});
	$('#ur_start').change(function() {
		var daily = document.getElementById('ur_daily').value;
		var daily_start = document.getElementById('ur_start').value;
		var daily_end = document.getElementById('ur_end').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, daily: daily, daily_start: daily_start, daily_end: daily_end},
			success: function(result) {}
		});
	});
	$('#ur_end').change(function() {
		var daily = document.getElementById('ur_daily').value;
		var daily_start = document.getElementById('ur_start').value;
		var daily_end = document.getElementById('ur_end').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, daily: daily, daily_start: daily_start, daily_end: daily_end},
			success: function(result) {}
		});
	});
	$('#ur_mon_start').change(function() {
		var ur_mon_start = document.getElementById('ur_mon_start').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_mon_start: ur_mon_start},
			success: function(result) {}
		});
	});
	$('#ur_mon_end').change(function() {
		var ur_mon_end = document.getElementById('ur_mon_end').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_mon_end: ur_mon_end},
			success: function(result) {}
		});
	});
	$('#ur_tue_start').change(function() {
		var ur_tue_start = document.getElementById('ur_tue_start').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_tue_start: ur_tue_start},
			success: function(result) {}
		});
	});
	$('#ur_tue_end').change(function() {
		var ur_tue_end = document.getElementById('ur_tue_end').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_tue_end: ur_tue_end},
			success: function(result) {}
		});
	});
	$('#ur_wed_start').change(function() {
		var ur_wed_start = document.getElementById('ur_wed_start').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_wed_start: ur_wed_start},
			success: function(result) {}
		});
	});
	$('#ur_wed_end').change(function() {
		var ur_wed_end = document.getElementById('ur_wed_end').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_wed_end: ur_wed_end},
			success: function(result) {}
		});
	});
	$('#ur_thur_start').change(function() {
		var ur_thur_start = document.getElementById('ur_thur_start').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_thur_start: ur_thur_start},
			success: function(result) {}
		});
	});
	$('#ur_thur_end').change(function() {
		var ur_thur_end = document.getElementById('ur_thur_end').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_thur_end: ur_thur_end},
			success: function(result) {}
		});
	});
	$('#ur_fri_start').change(function() {
		var ur_fri_start = document.getElementById('ur_fri_start').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_fri_start: ur_fri_start},
			success: function(result) {}
		});
	});
	$('#ur_fri_end').change(function() {
		var ur_fri_end = document.getElementById('ur_fri_end').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_fri_end: ur_fri_end},
			success: function(result) {}
		});
	});
	$('#ur_sat_start').change(function() {
		var ur_sat_start = document.getElementById('ur_sat_start').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_sat_start: ur_sat_start},
			success: function(result) {}
		});
	});
	$('#ur_sat_end').change(function() {
		var ur_sat_end = document.getElementById('ur_sat_end').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_sat_end: ur_sat_end},
			success: function(result) {}
		});
	});
	$('#ur_sun_start').change(function() {
		var ur_sun_start = document.getElementById('ur_sun_start').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_sun_start: ur_sun_start},
			success: function(result) {}
		});
	});
	$('#ur_sun_end').change(function() {
		var ur_sun_end = document.getElementById('ur_sun_end').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, ur_sun_end: ur_sun_end},
			success: function(result) {}
		});
	});
	$('.reg').keyup(function() {
		var len = this.value.length;
		if (len >= 15) {
			this.value = this.value.substring(0, 15);
		}
	});
	$('#ur_quantity_text').keyup(function() {
		var len = this.value.length;
		if (len >= 5) {
			this.style.border="";
			this.value = this.value.substring(0, 5);
		} else if(len==0){
			this.style.border="2px solid red";
		} else {
			this.style.border="";
			var quantity_text = document.getElementById('ur_quantity_text').value;
			var quantity_cent = document.getElementById('ur_quantity_cent').value;
			var items = document.getElementById('ur_items').textContent;
			var delivery_charge = document.getElementById('ur_delivery_charge').value;
			if(delivery_charge=="Free") {
				var free = document.getElementById('ur_free').textContent;
				del_info = delivery_charge+" "+free+quantity_text+"."+quantity_cent+" "+items;
				$.ajax({
					type: "POST",
					url: "/BuyMe/seller/update_profile.php",
					data: {user_id: user_id, del_info: del_info},
					success: function(result){}
				});
			} else {
				var charge_text = document.getElementById('ur_charge_text').value;
				var charge = document.getElementById('ur_charge').textContent;
				if($('#ur_charge_text').val()!="") {
					del_info = charge_text+charge+quantity_text+"."+quantity_cent+" "+items;
					$.ajax({
						type: "POST",
						url: "/BuyMe/seller/update_profile.php",
						data: {user_id: user_id, del_info: del_info},
						success: function(result){}
					});
				} else {
					document.getElementById('ur_charge_text').style.border = "2px solid red";
				}
			}
		}
	});
	$('#ur_quantity_cent').change(function() {
		var quantity_text = document.getElementById('ur_quantity_text').value;
		var quantity_cent = document.getElementById('ur_quantity_cent').value;
		var items = document.getElementById('ur_items').textContent;
		var delivery_charge = document.getElementById('ur_delivery_charge').value;
		if(delivery_charge=="Free") {
			var free = document.getElementById('ur_free').textContent;
			del_info = delivery_charge+" "+free+quantity_text+"."+quantity_cent+" "+items;
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, del_info: del_info},
				success: function(result){}
			});
		} else {
			var charge_text = document.getElementById('ur_charge_text').value;
			var charge = document.getElementById('ur_charge').textContent;
			if($('#ur_charge_text').val()!="") {
				del_info = charge_text+charge+quantity_text+"."+quantity_cent+" "+items;
				$.ajax({
					type: "POST",
					url: "/BuyMe/seller/update_profile.php",
					data: {user_id: user_id, del_info: del_info},
					success: function(result){}
				});
			} else {
				document.getElementById('ur_charge_text').style.border = "2px solid red";
			}
		}
	});
	$('#ur_charge_text').keyup(function() {
		var len = this.value.length;
		if (len >= 5) {
			this.style.border="";
			this.value = this.value.substring(0, 5);
		} else if(len==0){
			this.style.border="2px solid red";
		} else {
			this.style.border="";
			if($('#ur_quantity_text').val()==""){
				document.getElementById('ur_quantity_text').style.border = "2px solid red";
			} else if($('#ur_quantity_cent').val()==""){
				document.getElementById('ur_quantity_cent').style.border = "2px solid red";
			} else {
				var charge_text = document.getElementById('ur_charge_text').value;
				var charge = document.getElementById('ur_charge').textContent;
				var quantity_text = document.getElementById('ur_quantity_text').value;
				var quantity_cent = document.getElementById('ur_quantity_cent').value;
				var items = document.getElementById('ur_items').textContent;
				del_info = charge_text+charge+quantity_text+"."+quantity_cent+" "+items;
				$.ajax({
					type: "POST",
					url: "/BuyMe/seller/update_profile.php",
					data: {user_id: user_id, del_info: del_info},
					success: function(result){}
				});
			}
		}
	});
	
	$('#change_pass_btn').click(function() {
		var old_pass = $("#ur_old_pass").val();
		var new_pass = $("#ur_new_pass").val();
		var re_pass = $("#ur_retype_pass").val();
		if(old_pass!=""&&new_pass!=""&&re_pass!="") {
			if(new_pass!=re_pass) {
				match_pass();
			} else {
				$.ajax({
					type: "POST",
					url: "/BuyMe/seller/change_pass.php",
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
							document.getElementById("ur_old_pass").style.border="2px solid red";
						} else if(result=="changed") {
							swal({
								title: "Password Changed",
								text: "You need to login again.",
								type: "success",
								timer: 3000
							}, function() {
								var u_id = document.getElementById('user_id').textContent;
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
	$('#change_email_btn').click(function() {
		var new_mail = $("#ur_new_mail").val();
		if(new_mail!="") {
			document.getElementById('ur_new_mail').style.border="";
			var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
			if(!new_mail.match(pattern)) {
				document.getElementById('smail_validation').style.display="block";
				window.setTimeout(function() {
					$("#smail_validation").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove(); 
					});
				}, 2000);
				document.getElementById('ur_new_mail').style.border="2px solid red";
			} else {
				$.ajax({
					type: "POST",
					url: "/BuyMe/seller/change_email.php",
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
								var u_id = document.getElementById('user_id').textContent;
								window.location.href="http://localhost:82/BuyMe/logout.php?userID="+u_id;
							});
						} else {
							alert(result);
						}
					}
				});
			}
		} else {
			document.getElementById('ur_new_mail').style.border="2px solid red";
		}
		return false;
	});
	$('#change_image_btn').click(function() {
		var image = document.getElementById("ur_image").files;
		var shop_image;
		if (image.length > 0) {
			document.getElementById("ur_image").style.border="";
			var fileToLoad = image[0];
			var fileReader = new FileReader();
			fileReader.onload = function(fileLoadedEvent) {
				shop_image = fileLoadedEvent.target.result; // <--- data: base64
				$.ajax({
					type: "POST",
					url: "/BuyMe/seller/update_profile.php",
					data: {user_id: user_id, shop_image: shop_image},
					success: 
					function(result) {
						window.location.href="http://localhost:82/BuyMe/seller/profile.php";
					}
				});
			}
			fileReader.readAsDataURL(fileToLoad);
		} else {
			document.getElementById("ur_image").style.border="2px solid red";
		}
		return false;
	});
	$('#change_address_btn').click(function() {
		var address = $("#ur_new_address").val();
		var postcode = $("#ur_new_postcode").val();
		var city = $("#ur_new_city").val();
		var state = $("#ur_new_state").val();
		if(address!=""&&postcode!=""&&city!=""&&state!="") {
			document.getElementById('ur_new_address').style.border="";
			document.getElementById('ur_new_postcode').style.border="";
			document.getElementById('ur_new_city').style.border="";
			document.getElementById('ur_new_state').style.border="";
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, address: address, postcode: postcode, city: city, state: state},
				success:
				function(result) {
					window.location.href="http://localhost:82/BuyMe/seller/profile.php";
				}
			});
		} else {
			document.getElementById('ur_new_address').style.border="2px solid red";
			document.getElementById('ur_new_postcode').style.border="2px solid red";
			document.getElementById('ur_new_city').style.border="2px solid red";
			document.getElementById('ur_new_state').style.border="2px solid red";
		}
		return false;
	});
	$('#change_location_btn').click(function() {
		var new_loc = $("#ur_new_location").val();
		if(new_loc!="") {
			document.getElementById('ur_new_location').style.border="";
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, new_loc: new_loc},
				success:
				function(result) {
					window.location.href="http://localhost:82/BuyMe/seller/profile.php";
				}
			});
		} else {
			document.getElementById('ur_new_location').style.border="2px solid red";
		}
		return false;
	});
	$('#ur_del_yes').click(function() {
		document.getElementById('ur_del_yes').checked = "checked";
		document.getElementById('ur_del_no').checked = "";
		document.getElementById('ur_delivery_info').style.display = "block";
		document.getElementById('ur_quantity_text').style.border="2px solid red";
		document.getElementById('ur_charge_text').style.border="2px solid red";
		var delivery_service = document.getElementById('ur_del_yes').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, delivery_service: delivery_service},
			success:
			function(result) {
				window.location.href="http://localhost:82/BuyMe/seller/profile.php";
			}
		});
	});
	$('#ur_del_no').click(function() {
		document.getElementById('ur_del_yes').checked = "";
		document.getElementById('ur_del_no').checked = "checked";
		document.getElementById('ur_delivery_info').style.display = "none";
		document.getElementById('ur_quantity_text').value="";
		document.getElementById('ur_charge_text').value="";
		var delivery_service = document.getElementById('ur_del_no').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, delivery_service: delivery_service, del_info: ""},
			success:
			function(result) {
				window.location.href="http://localhost:82/BuyMe/seller/profile.php";
			}
		});
	});
	$('#change_daily_btn').click(function() {
		var day = document.getElementById('new_daily').value;
		var time_start = document.getElementById('new_start').value;
		var time_end = document.getElementById('new_end').value;
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/update_profile.php",
			data: {user_id: user_id, day_1: day, time_start_1: time_start, time_end_1: time_end},
			success:
			function(result) {
				window.location.href="http://localhost:82/BuyMe/seller/profile.php";
			}
		});
	});
	$('#change_monsun_btn').click(function() {
		var new_monday = $('#new_monday').val();
		var new_mon_start = $('#new_mon_start').val();
		var new_mon_end = $('#new_mon_end').val();
		var new_tuesday = $('#new_tuesday').val();
		var new_tue_start = $('#new_tue_start').val();
		var new_tue_end = $('#new_tue_end').val();
		var new_wednesday = $('#new_wednesday').val();
		var new_wed_start = $('#new_wed_start').val();
		var new_wed_end = $('#new_wed_end').val();
		var new_thursday = $('#new_thursday').val();
		var new_thur_start = $('#new_thur_start').val();
		var new_thur_end = $('#new_thur_end').val();
		var new_friday = $('#new_friday').val();
		var new_fri_start = $('#new_fri_start').val();
		var new_fri_end = $('#new_fri_end').val();
		var new_saturday = $('#new_saturday').val();
		var new_sat_start = $('#new_sat_start').val();
		var new_sat_end = $('#new_sat_end').val();
		var new_sunday = $('#new_sunday').val();
		var new_sun_start = $('#new_sun_start').val();
		var new_sun_end = $('#new_sun_end').val();
		if(new_mon_start!=""&&new_mon_end!=""&&new_tue_start!=""&&new_tue_end!=""&&new_wed_start!=""&&new_wed_end!=""&&new_thur_start!=""&&new_thur_end!=""&&new_fri_start!=""&&new_fri_end!=""&&new_sat_start!=""&&new_sat_end!=""&&new_sun_start!=""&&new_sun_end!="") {
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, new_monday: new_monday, new_mon_start: new_mon_start, new_mon_end: new_mon_end, new_tuesday: new_tuesday, new_tue_start: new_tue_start, new_tue_end: new_tue_end, new_wednesday: new_wednesday, new_wed_start: new_wed_start, new_wed_end: new_wed_end, new_thursday: new_thursday, new_thur_start: new_thur_start, new_thur_end: new_thur_end, new_friday: new_friday, new_fri_start: new_fri_start, new_fri_end: new_fri_end, new_saturday: new_saturday, new_sat_start: new_sat_start, new_sat_end: new_sat_end, new_sunday: new_sunday, new_sun_start: new_sun_start, new_sun_end: new_sun_end},
				success:
				function(result) {
					window.location.href="http://localhost:82/BuyMe/seller/profile.php";
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
	});
});

function choose_charge() {
	if(document.getElementById('ur_delivery_charge').value == "Free") {
		document.getElementById('ur_charge').style.display = "none";
		document.getElementById('ur_other_charge').style.display = "none";
		document.getElementById('ur_free').style.display = "block";
		document.getElementById('ur_quantity_text').value="";
	
	} else {
		document.getElementById('ur_charge').style.display = "block";
		document.getElementById('ur_other_charge').style.display = "block";
		document.getElementById('ur_free').style.display = "none";
		document.getElementById('ur_quantity_text').value="";
		document.getElementById('ur_charge_text').value="";
	}
}

function val_length() {
	var len = document.getElementById('ur_new_address').value.length;
	if (len >= 100) {
		document.getElementById('ur_new_address').style.border="";
		document.getElementById('ur_new_address').value = document.getElementById('ur_new_address').value.substring(0, 100);
	}
	var len_1 = document.getElementById('ur_new_city').value.length;
	if (len_1 >= 50) {
		document.getElementById('ur_new_city').style.border="";
		document.getElementById('ur_new_city').value = document.getElementById('ur_new_city').value.substring(0, 50);
	}
	var len_2 = document.getElementById('ur_new_postcode').value.length;
	if (len_2 >= 5) {
		document.getElementById('ur_new_postcode').style.border="";
		document.getElementById('ur_new_postcode').value = document.getElementById('ur_new_postcode').value.substring(0, 5);
	}
}

// Input only number
function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

function match_pass() {
	document.getElementById('pass_match').style.display="block";
	window.setTimeout(function() {
		$("#pass_match").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 2000);
	document.getElementById("ur_new_pass").style.border="2px solid red";
	document.getElementById("ur_retype_pass").style.border="2px solid red";
}