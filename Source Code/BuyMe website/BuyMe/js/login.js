// JavaScript Document

$(document).ready(function() {
	
	// Validate user login
	$('#login_button').click(function() {
		var email = $("#login_email").val();
		var password = $("#login_password").val();
		var post_data = {loginEmail: email, loginPassword: password};
		if(email=="") {
			document.getElementById("login_email").style.border="2px solid red";
		} else if(password=="") {
			document.getElementById("login_password").style.border="2px solid red";
		} else if(email==""&&password=="") {
			document.getElementById("login_email").style.border="2px solid red";
			document.getElementById("login_password").style.border="2px solid red";
		} else {
			var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
			if(!email.match(pattern)) {
				document.getElementById('mail_validation').style.display="block";
				window.setTimeout(function() {
					$("#mail_validation").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove(); 
					});
				}, 2000);
				document.getElementById('login_email').style.border="2px solid red";
			} else {
				$.ajax({
					type: "POST",
					url: "/BuyMe/login_account.php",
					data: post_data,
					success:
					function(result) {
						if(result=="login_error") {
							swal({
								title: "Login Error",
								text: "Incorrect username and password.",
								type: "error",
								timer: 3000
							});
							document.getElementById("login_email").value="";
							document.getElementById("login_password").value="";
							document.getElementById("login_email").style.border="";
							document.getElementById("login_password").style.border="";
						} else if (result=="user"){
							document.location = "/BuyMe";
						} else if (result=="seller"){
							document.location = "/BuyMe/seller";
						} else {
							alert(result);
						}
					}
				});
			}
		}
		return false;
	});
	
	// Send reset code to the register email
	$('#send_button').click(function() {
		var email = $("#email_link").val();
		var post_data = {email_link: email};
		if(email=="") {
			document.getElementById("email_link").style.border="2px solid red";
		} else {
			$.ajax({
				type: "POST",
				url: "/BuyMe/forgot_password.php",
				data: post_data,
				success:
				function(result) {
					if(result=="non_register_email") {
						swal({
							title: "E-mail Not Found",
							text: "This email is not register yet.",
							type: "error",
							timer: 3000
						});
						document.getElementById("email_link").value="";
						document.getElementById("email_link").style.border="";
					} else if (result=="register_email") {
						swal({
							title: "E-mail Sent",
							text: "Please check your email.",
							type: "success",
							timer: 3000
						});
						$('#forgotform').modal('hide');
					} else {
						alert(result);
					}
				}
			});
		}
		return false;
	});
});

function validate_length() {
	
	var len = document.getElementById('login_email').value.length;
	if (len >= 200) {
		document.getElementById('login_email').value = document.getElementById('login_email').value.substring(0, 200);
	}

	var len_1 = document.getElementById('login_password').value.length;
	if (len_1 >= 15) {
		document.getElementById('login_password').value = document.getElementById('login_password').value.substring(0, 15);
	}
	
	var len_2 = document.getElementById('email_link').value.length;
	if (len_2 >= 200) {
		document.getElementById('email_link').value = document.getElementById('email_link').value.substring(0, 200);
	}
}