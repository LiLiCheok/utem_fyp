// JavaScript Document

$(document).ready(function() {
	$('#reset_button').click(function() {
		var email = $('#email_link').val();
		var old_pass = $('#old_pass').val();
		var new_pass = $('#new_pass').val();
		if(old_pass=="") {
			document.getElementById("old_pass").style.border="2px solid red";
		} else if(new_pass=="") {
			document.getElementById("new_pass").style.border="2px solid red";
		} else if(old_pass==""&&new_pass=="") {
			document.getElementById("old_pass").style.border="2px solid red";
			document.getElementById("new_pass").style.border="2px solid red";
		} else {}
		if(email!=""&&old_pass!=""&&new_pass!="") {
			if(old_pass!=new_pass) {
				document.getElementById('password_not_match').style.display="block";
				window.setTimeout(function() {
					$("#password_not_match").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove(); 
					});
				}, 2000);
				document.getElementById("old_pass").value="";
				document.getElementById("new_pass").value="";
				document.getElementById("old_pass").style.border="2px solid red";
				document.getElementById("new_pass").style.border="2px solid red";
			} else {
				$.ajax({
					type: "POST",
					url: "/BuyMe/reset.php",
					data: {email: email, new_pass: new_pass},
					success:
					function(result) {
						if(result=="reset_successfully") {
							swal({
								title: "Reset Done!",
								text: "Your password has been reset.",
								type: "success",
								timer: 3000
							}, function() {
								document.location="login.php";
							});
						} else {
							alert(result);
						}
					}
				});
			}
		}
		return false;
	});
});

// Validate the password length
function pass_length() {
	var len_1 = document.getElementById('new_pass').value.length;
	var len_2 = document.getElementById('old_pass').value.length;
	if (len_1 >= 15) {
		document.getElementById('new_pass').value = document.getElementById('new_pass').value.substring(0, 15);
	} else if (len_2 >= 15) {
		document.getElementById('old_pass').value = document.getElementById('old_pass').value.substring(0, 15);
	}
}