// JavaScript Document

var valid;

$(document).ready(function() {
	
	// Validation for each textfield
	$('.reg').keyup(function() {
		var len = this.value.length;
		if (len >= 15) {
			this.value = this.value.substring(0, 15);
		}
	});
	$('.reg_1').keyup(function() {
		var len = this.value.length;
		if (len >= 100) {
			this.value = this.value.substring(0, 100);
		}
	});
	$('.reg_2').keyup(function() {
		var len = this.value.length;
		if (len >= 11) {
			this.value = this.value.substring(0, 11);
		}
	});
	$('.reg_3').keyup(function() {
		var len = this.value.length;
		if (len >= 200) {
			this.value = this.value.substring(0, 200);
		}
	});
	$('#reg_desc').keyup(function() {
		var len = this.value.length;
		if (len >= 600) {
			this.value = this.value.substring(0, 600);
		}
	});
	$('#reg_postcode').keyup(function() {
		var len = this.value.length;
		if (len >= 5) {
			this.value = this.value.substring(0, 5);
		}
	});
	$('#reg_city').keyup(function() {
		var len = this.value.length;
		if (len >= 50) {
			this.value = this.value.substring(0, 50);
		}
	});
	$('#reg_phone').keyup(function() {
		var len = this.value.length;
		if (len >= 10) {
			this.value = this.value.substring(0, 10);
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
	
	// Create user account
	$('#user_reg_button').click(function() {
		
		valid = true;
		
		var reg_uname = $('#reg_name').val();
		var reg_uic = $('#reg_ic').val();
		var reg_ucontact = $('#reg_contact').val();
		var reg_uemail = $('#reg_email').val();
		var reg_upassword = $('#reg_password').val();
		var con_upassword = $('#con_password').val();
		
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;

		if (document.getElementById('user_checked').checked = "checked") {
			if(reg_uname!=""&&reg_uic!=""&&reg_ucontact!=""&&reg_uemail!=""&&reg_upassword!=""&&con_upassword!="") {	
				if(reg_upassword!=con_upassword) {
					match_pass();
					document.getElementById('reg_email').style.border="";
					document.getElementById("reg_password").style.border="2px solid red";
					document.getElementById("con_password").style.border="2px solid red";
				} else if(!reg_uemail.match(pattern)) {
					mail_verify();
					document.getElementById('reg_email').style.border="2px solid red";
					document.getElementById("reg_password").style.border="";
					document.getElementById("con_password").style.border="";
				} else {
					$.ajax({
						type: "POST",
						url: "/BuyMe/create_user_account.php",
						data: {register_name: reg_uname, register_ic: reg_uic, register_contact: reg_ucontact, register_email: reg_uemail, confirm_password: con_upassword},
						success:
						function(result) {
							if(result=="email_exist") {
								alert_exist();
								document.getElementById("reg_email").style.border="2px solid red";
							} else if (result=="user_registered") {
								alert_register();
							} else {
								alert(result);
							}
						}
					});
				}
			} else {
				validate();
			}
		}
		
		return false;
	});
	
	$('#seller_reg_button').click(function() {
		
		valid = true;
		
		validate();
		
		var reg_name = $('#reg_sname').val();
		var reg_ic = $('#reg_sic').val();
		var reg_contact = $('#reg_scontact').val();
		var reg_email = $('#reg_semail').val();
		var reg_password = $('#reg_spassword').val();
		var con_password = $('#con_spassword').val();
		var reg_company = $('#reg_company').val();
		var reg_ssm = $('#reg_ssm').val();
		var reg_desc = $('#reg_desc').val();
		var reg_phone = $('#reg_phone').val();
		var daily = $('#daily').val();
		var reg_start = $('#reg_start').val();
		var reg_end = $('#reg_end').val();
		var monday = $('#monday').val();
		var mon_start = $('#mon_start').val();
		var mon_end = $('#mon_end').val();
		var tuesday = $('#tuesday').val();
		var tue_start = $('#tue_start').val();
		var tue_end = $('#tue_end').val();
		var wednesday = $('#wednesday').val();
		var wed_start = $('#wed_start').val();
		var wed_end = $('#wed_end').val();
		var thursday = $('#thursday').val();
		var thur_start = $('#thur_start').val();
		var thur_end = $('#thur_end').val();
		var friday = $('#friday').val();
		var fri_start = $('#fri_start').val();
		var fri_end = $('#fri_end').val();
		var saturday = $('#saturday').val();
		var sat_start = $('#sat_start').val();
		var sat_end = $('#sat_end').val();
		var sunday = $('#sunday').val();
		var sun_start = $('#sun_start').val();
		var sun_end = $('#sun_end').val();
		var delivery_yes = $('#delivery_yes').val();
		var delivery_no = $('#delivery_no').val();
		var reg_address = $('#reg_address').val();
		var reg_postcode = $('#reg_postcode').val();
		var reg_city = $('#reg_city').val();
		var reg_state = $('#reg_state').val();
		var reg_location = $('#reg_location').val();
		
		var delivery_charge = document.getElementById('delivery_charge').value;
		var charge_text = document.getElementById('charge_text').value;
		var charge = document.getElementById('charge').textContent;
		var free = document.getElementById('free').textContent;
		var quantity_text = document.getElementById('quantity_text').value;
		var quantity_cent = document.getElementById("quantity_cent").value;
		var items = document.getElementById('items').textContent;
		var delivery_info;
		if(delivery_charge=="Free") {
			if(quantity_text!="") {
				delivery_info = delivery_charge+" "+free+quantity_text+"."+quantity_cent+" "+items;
			} else {
				delivery_info="";
			}
		} else {
			if(charge_text!=""&&quantity_text!="") {
				delivery_info = charge_text+charge+quantity_text+"."+quantity_cent+" "+items;
			} else {
				delivery_info="";
			}
		}
		
		var image = document.getElementById("shop_image").files;
		var shop_image;
		
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		
		if (document.getElementById('seller_checked').checked = "checked") {
			
			if (image.length > 0) {
				
				document.getElementById("shop_image").style.border="";
				
				var fileToLoad = image[0];
				var fileReader = new FileReader();
				
				fileReader.onload = function(fileLoadedEvent) {
					
					shop_image = fileLoadedEvent.target.result; // <--- data: base64
			
					var all_data = {register_name: reg_name, register_ic: reg_ic, register_contact: reg_contact, register_email: reg_email, confirm_password: con_password, shop_image: shop_image, reg_company: reg_company, reg_ssm: reg_ssm, reg_desc: reg_desc, reg_phone: reg_phone, daily: daily, reg_start: reg_start, reg_end: reg_end, monday: monday, mon_start: mon_start, mon_end: mon_end, tuesday: tuesday, tue_start: tue_start, tue_end: tue_end, wednesday: wednesday, wed_start: wed_start, wed_end: wed_end, thursday: thursday, thur_start: thur_start, thur_end: thur_end, friday: friday, fri_start: fri_start, fri_end: fri_end, saturday: saturday, sat_start: sat_start, sat_end: sat_end, sunday: sunday, sun_start: sun_start, sun_end: sun_end, delivery: delivery_yes, delivery_info: delivery_info, reg_address: reg_address, reg_postcode: reg_postcode, reg_city: reg_city, reg_state: reg_state, reg_location: reg_location};
					var all_data_1 = {register_name: reg_name, register_ic: reg_ic, register_contact: reg_contact, register_email: reg_email, confirm_password: con_password, shop_image: shop_image, reg_company: reg_company, reg_ssm: reg_ssm, reg_desc: reg_desc, reg_phone: reg_phone, daily: daily, reg_start: reg_start, reg_end: reg_end, monday: monday, mon_start: mon_start, mon_end: mon_end, tuesday: tuesday, tue_start: tue_start, tue_end: tue_end, wednesday: wednesday, wed_start: wed_start, wed_end: wed_end, thursday: thursday, thur_start: thur_start, thur_end: thur_end, friday: friday, fri_start: fri_start, fri_end: fri_end, saturday: saturday, sat_start: sat_start, sat_end: sat_end, sunday: sunday, sun_start: sun_start, sun_end: sun_end, delivery: delivery_no, delivery_info: "", reg_address: reg_address, reg_postcode: reg_postcode, reg_city: reg_city, reg_state: reg_state, reg_location: reg_location};
					
					if(reg_name!=""&&reg_ic!=""&&reg_contact!=""&&reg_email!=""&&reg_password!=""&&con_password!=""&&
					reg_company!=""&&reg_ssm!=""&&reg_desc!=""&&reg_phone!=""&&
					mon_start!=""&&mon_end!=""&&tue_start!=""&&tue_end!=""&&wed_start!=""&&wed_end!=""&&thur_start!=""&&thur_end!=""&&
					fri_start!=""&&fri_end!=""&&sat_start!=""&&sat_end!=""&&sun_start!=""&&sun_end!=""&&
					reg_address!=""&&reg_postcode!=""&&reg_city!=""&&reg_state!="") {
						if(reg_password!=con_password) {
							match_pass();
						} else if(!reg_email.match(pattern)) {
							mail_verify();
							document.getElementById('reg_semail').style.border="2px solid red";
						} else {
							if(document.getElementById('delivery_yes').checked) {
								if(delivery_info!="") {
									$.ajax({
										type: "POST",
										url: "/BuyMe/create_seller_account.php",
										data: all_data,
										success:
										function(result) {
											if(result=="email_exist") {
												alert_exist();
												document.getElementById("reg_semail").style.border="2px solid red";
											} else if (result=="user_registered") {
												alert_register();
											} else {
												alert(result);
											}
										}
									});
								} else {}
							} else {
								if (document.getElementById('delivery_yes').checked=="checked"&&document.getElementById('delivery_no').checked=="") {} else {
									$.ajax({
										type: "POST",
										url: "/BuyMe/create_seller_account.php",
										data: all_data_1,
										success:
										function(result) {
											if(result=="email_exist") {
												alert_exist();
												document.getElementById("reg_semail").style.border="2px solid red";
											} else if (result=="user_registered") {
												alert_register();
											} else {
												alert(result);
											}
										}
									});
								}
							}
						}
					}
					
					if(reg_name!=""&&reg_ic!=""&&reg_contact!=""&&reg_email!=""&&reg_password!=""&&con_password!=""&&
					reg_company!=""&&reg_ssm!=""&&reg_desc!=""&&reg_phone!=""&&reg_start!=""&&reg_end!=""&&
					reg_address!=""&&reg_postcode!=""&&reg_city!=""&&reg_state!="") {
						if(reg_password!=con_password) {
							match_pass();
						} else if(!reg_email.match(pattern)) {
							mail_verify();
							document.getElementById('reg_semail').style.border="2px solid red";
						} else {
							if(document.getElementById('delivery_yes').checked) {
								if(delivery_info!="") {
									$.ajax({
										type: "POST",
										url: "/BuyMe/create_seller_account.php",
										data: all_data,
										success:
										function(result) {
											if(result=="email_exist") {
												alert_exist();
												document.getElementById("reg_semail").style.border="2px solid red";
											} else if (result=="user_registered") {
												alert_register();
											} else {
												alert(result);
											}
										}
									});
								}
							} else {
								if (document.getElementById('delivery_yes').checked=="checked"&&document.getElementById('delivery_no').checked=="") {} else {
									$.ajax({
										type: "POST",
										url: "/BuyMe/create_seller_account.php",
										data: all_data_1,
										success:
										function(result) {
											if(result=="email_exist") {
												alert_exist();
												document.getElementById("reg_semail").style.border="2px solid red";
											} else if (result=="user_registered") {
												alert_register();
											} else {
												alert(result);
											}
										}
									});
								}
							}
						}
					}
			
					if(reg_name!=""&&reg_ic!=""&&reg_contact!=""&&reg_email!=""&&reg_password!=""&&con_password!=""&&
					reg_company!=""&&reg_ssm!=""&&reg_desc!=""&&reg_phone!=""&&
					mon_start!=""&&mon_end!=""&&tue_start!=""&&tue_end!=""&&wed_start!=""&&wed_end!=""&&thur_start!=""&&thur_end!=""&&
					fri_start!=""&&fri_end!=""&&sat_start!=""&&sat_end!=""&&sun_start!=""&&sun_end!=""&&reg_location!="") {
						if(reg_password!=con_password) {
							match_pass();
						} else if(!reg_email.match(pattern)) {
							mail_verify();
							document.getElementById('reg_semail').style.border="2px solid red";
						} else {
							if(document.getElementById('delivery_yes').checked) {
								if(delivery_info!="") {
									$.ajax({
										type: "POST",
										url: "/BuyMe/create_seller_account.php",
										data: all_data,
										success:
										function(result) {
											if(result=="email_exist") {
												alert_exist();
												document.getElementById("reg_semail").style.border="2px solid red";
											} else if (result=="user_registered") {
												alert_register();
											} else {
												alert(result);
											}
										}
									});
								}
							} else {
								if (document.getElementById('delivery_yes').checked=="checked"&&document.getElementById('delivery_no').checked=="") {} else {
									$.ajax({
										type: "POST",
										url: "/BuyMe/create_seller_account.php",
										data: all_data_1,
										success:
										function(result) {
											if(result=="email_exist") {
												alert_exist();
												document.getElementById("reg_semail").style.border="2px solid red";
											} else if (result=="user_registered") {
												alert_register();
											} else {
												alert(result);
											}
										}
									});
								}
							}
						}
					}
				
					if(reg_name!=""&&reg_ic!=""&&reg_contact!=""&&reg_email!=""&&reg_password!=""&&con_password!=""&&
					reg_company!=""&&reg_ssm!=""&&reg_desc!=""&&reg_phone!=""&&reg_start!=""&&reg_end!=""&&reg_location!="") {
						if(reg_password!=con_password) {
							match_pass();
						} else if(!reg_email.match(pattern)) {
							mail_verify();
							document.getElementById('reg_semail').style.border="2px solid red";
						} else {
							if(document.getElementById('delivery_yes').checked) {
								if(delivery_info!="") {
									$.ajax({
										type: "POST",
										url: "/BuyMe/create_seller_account.php",
										data: all_data,
										success:
										function(result) {
											if(result=="email_exist") {
												alert_exist();
												document.getElementById("reg_semail").style.border="2px solid red";
											} else if (result=="user_registered") {
												alert_register();
											} else {
												alert(result);
											}
										}
									});
								}
							} else {
								if (document.getElementById('delivery_yes').checked=="checked"&&document.getElementById('delivery_no').checked=="") {} else {
									$.ajax({
										type: "POST",
										url: "/BuyMe/create_seller_account.php",
										data: all_data_1,
										success:
										function(result) {
											if(result=="email_exist") {
												alert_exist();
												document.getElementById("reg_semail").style.border="2px solid red";
											} else if (result=="user_registered") {
												alert_register();
											} else {
												alert(result);
											}
										}
									});
								}
							}
						}
					}
				}
				
				fileReader.readAsDataURL(fileToLoad);
			  
			} else {
				
				document.getElementById("shop_image").style.border="2px solid red";
			}
		}
		return false;
	});
	
	$('#delivery_charge').click(function () {
		if($('#delivery_charge').val() == "Free") {
			document.getElementById('charge').style.display = "none";
			document.getElementById('other_charge').style.display = "none";
			document.getElementById('free').style.display = "block";
	
		} else {
			document.getElementById('charge').style.display = "block";
			document.getElementById('other_charge').style.display = "block";
			document.getElementById('charge_text').disabled = "";
			document.getElementById('free').style.display = "none";
		}
	});
});

function validate() {
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
	$('textarea[type="text"]').each(function() {
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
	$('input[type="email"]').each(function() {
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
	$('input[type="file"]').each(function() {
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

function alert_register() {
	swal({
		title: "Account Registered",
		text: "You can login to BuyMe now.",
		type: "success",
		timer: 3000
	}, function() {
		document.location="login.php"
	});
}

function alert_exist() {
	swal({
		title: "E-mail Exist",
		text: "This email is registered.",
		type: "error",
		timer: 3000
	});
}

function match_pass() {
	document.getElementById('password_not_match').style.display="block";
	window.setTimeout(function() {
		$("#password_not_match").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 5000);
	document.getElementById("reg_spassword").style.border="2px solid red";
	document.getElementById("con_spassword").style.border="2px solid red";
}

function mail_verify() {
	document.getElementById('mail_validation_1').style.display="block";
	window.setTimeout(function() {
		$("#mail_validation_1").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 5000);
}

// Input only number
function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

// Validate image
function check_file(f){
	if (document.getElementById('seller_checked').checked) {
		f = f.elements;
		if(/.*\.(gif)|(jpeg)|(jpg)|(png)$/.test(f['image'].value.toLowerCase()))
			return true;
		alert('Please Upload Gif, Jpg, Png Images Only.');
		f['image'].focus();
		return false;
	} else {}
}

function add_date_click() {
	document.getElementById('single_day').style.display = 'none';
	document.getElementById('all_day').style.display = 'block';
	
	document.getElementById('daily').disabled = "disabled";
	document.getElementById('reg_start').disabled = "disabled";
	document.getElementById('reg_end').disabled = "disabled";
	document.getElementById('daily').value = "";
	document.getElementById('reg_start').value = "";
	document.getElementById('reg_end').value = "";
	
	document.getElementById('monday').disabled = "";
	document.getElementById('mon_start').disabled = "";
	document.getElementById('mon_end').disabled = "";
	document.getElementById('tuesday').disabled = "";
	document.getElementById('tue_start').disabled = "";
	document.getElementById('tue_end').disabled = "";
	document.getElementById('wednesday').disabled = "";
	document.getElementById('wed_start').disabled = "";
	document.getElementById('wed_end').disabled = "";
	document.getElementById('thursday').disabled = "";
	document.getElementById('thur_start').disabled = "";
	document.getElementById('thur_end').disabled = "";
	document.getElementById('friday').disabled = "";
	document.getElementById('fri_start').disabled = "";
	document.getElementById('fri_end').disabled = "";
	document.getElementById('saturday').disabled = "";
	document.getElementById('sat_start').disabled = "";
	document.getElementById('sat_end').disabled = "";
	document.getElementById('sunday').disabled = "";
	document.getElementById('sun_start').disabled = "";
	document.getElementById('sun_end').disabled = "";
}

function remove_date_click() {
	document.getElementById('single_day').style.display = 'block';
	document.getElementById('all_day').style.display = 'none';
	
	document.getElementById('daily').disabled = "";
	document.getElementById('reg_start').disabled = "";
	document.getElementById('reg_end').disabled = "";
	
	document.getElementById('monday').disabled = "disabled";
	document.getElementById('mon_start').disabled = "disabled";
	document.getElementById('mon_end').disabled = "disabled";
	document.getElementById('tuesday').disabled = "disabled";
	document.getElementById('tue_start').disabled = "disabled";
	document.getElementById('tue_end').disabled = "disabled";
	document.getElementById('wednesday').disabled = "disabled";
	document.getElementById('wed_start').disabled = "disabled";
	document.getElementById('wed_end').disabled = "disabled";
	document.getElementById('thursday').disabled = "disabled";
	document.getElementById('thur_start').disabled = "disabled";
	document.getElementById('thur_end').disabled = "disabled";
	document.getElementById('friday').disabled = "disabled";
	document.getElementById('fri_start').disabled = "disabled";
	document.getElementById('fri_end').disabled = "disabled";
	document.getElementById('saturday').disabled = "disabled";
	document.getElementById('sat_start').disabled = "disabled";
	document.getElementById('sat_end').disabled = "disabled";
	document.getElementById('sunday').disabled = "disabled";
	document.getElementById('sun_start').disabled = "disabled";
	document.getElementById('sun_end').disabled = "disabled";
	document.getElementById('monday').value = "";
	document.getElementById('mon_start').value = "";
	document.getElementById('mon_end').value = "";
	document.getElementById('tuesday').value = "";
	document.getElementById('tue_start').value = "";
	document.getElementById('tue_end').value = "";
	document.getElementById('wednesday').value = "";
	document.getElementById('wed_start').value = "";
	document.getElementById('wed_end').value = "";
	document.getElementById('thursday').value = "";
	document.getElementById('thur_start').value = "";
	document.getElementById('thur_end').value = "";
	document.getElementById('friday').value = "";
	document.getElementById('fri_start').value = "";
	document.getElementById('fri_end').value = "";
	document.getElementById('saturday').value = "";
	document.getElementById('sat_start').value = "";
	document.getElementById('sat_end').value = "";
	document.getElementById('sunday').value = "";
	document.getElementById('sun_start').value = "";
	document.getElementById('sun_end').value = "";
}

function del_yes() {
	document.getElementById('delivery_yes').checked = "checked";
	document.getElementById('delivery_no').checked = "";
	document.getElementById('delivery_info').style.display = "block";
}

function del_no() {
	document.getElementById('delivery_yes').checked = "";
	document.getElementById('delivery_no').checked = "checked";
	document.getElementById('delivery_info').style.display = "none";
}

function curr_location() {
	document.getElementById('shop_address').style.display = 'none';
	document.getElementById('shop_location').style.display = 'block';
	
	document.getElementById('reg_location').disabled = "";
	
	document.getElementById('reg_address').disabled = "disabled";
	document.getElementById('reg_postcode').disabled = "disabled";
	document.getElementById('reg_city').disabled = "disabled";
	document.getElementById('reg_state').disabled = "disabled";
	document.getElementById('reg_address').value = "";
	document.getElementById('reg_postcode').value = "";
	document.getElementById('reg_city').value = "";
}

function curr_address() {
	document.getElementById('shop_address').style.display = 'block';
	document.getElementById('shop_location').style.display = 'none';
	
	document.getElementById('reg_location').disabled = "disabled";
	document.getElementById('reg_location').value = "";
	
	document.getElementById('reg_address').disabled = "";
	document.getElementById('reg_postcode').disabled = "";
	document.getElementById('reg_city').disabled = "";
	document.getElementById('reg_state').disabled = "";
}

function user() {
	document.getElementById('user_reg_info').style.display = 'block';
	document.getElementById('reg_name').disabled = "";
	document.getElementById('reg_ic').disabled = "";
	document.getElementById('reg_contact').disabled = "";
	document.getElementById('reg_email').disabled = "";
	document.getElementById('reg_password').disabled = "";
	document.getElementById('con_password').disabled = "";
	document.getElementById('user_reg_button').disabled = "";
	
	document.getElementById('seller_reg_info').style.display = 'none';
}

function seller() {
	document.getElementById('user_checked').checked = "";
			
	document.getElementById('user_reg_info').style.display = 'none';
	document.getElementById('reg_name').disabled = "disabled";
	document.getElementById('reg_ic').disabled = "disabled";
	document.getElementById('reg_contact').disabled = "disabled";
	document.getElementById('reg_email').disabled = "disabled";
	document.getElementById('reg_password').disabled = "disabled";
	document.getElementById('con_password').disabled = "disabled";
	document.getElementById('user_reg_button').disabled = "disabled";
	
	document.getElementById('seller_reg_info').style.display = "block";
	document.getElementById('reg_sname').disabled = "";
	document.getElementById('reg_sic').disabled = "";
	document.getElementById('reg_scontact').disabled = "";
	document.getElementById('reg_semail').disabled = "";
	document.getElementById('reg_spassword').disabled = "";
	document.getElementById('con_spassword').disabled = "";
	document.getElementById('shop_image').disabled = "";
	document.getElementById('reg_company').disabled = "";
	document.getElementById('reg_ssm').disabled = "";
	document.getElementById('reg_desc').disabled = "";
	document.getElementById('daily').disabled = "";
	document.getElementById('reg_start').disabled = "";
	document.getElementById('reg_end').disabled = "";
	document.getElementById('reg_phone').disabled = "";
	document.getElementById('delivery_yes').disabled = "";
	document.getElementById('delivery_no').disabled = "";
	document.getElementById('delivery_charge').disabled = "";
	document.getElementById('quantity_text').disabled = "";
	document.getElementById('quantity_cent').disabled = "";
	document.getElementById('reg_address').disabled = "";
	document.getElementById('reg_postcode').disabled = "";
	document.getElementById('reg_city').disabled = "";
	document.getElementById('reg_state').disabled = "";
	document.getElementById('seller_reg_button').disabled = "";
}