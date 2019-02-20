// JavaScript Document

$(document).ready(function() {
	$('#login_btn').click(function() {
		var admin_id = $("#admin_id").val();
		var admin_password = $("#admin_password").val();
		var post_data = {admin_id: admin_id, admin_password: admin_password};
		if(admin_id=="") {
			document.getElementById("admin_id").style.border="2px solid red";
		} else if(admin_password=="") {
			document.getElementById("admin_password").style.border="2px solid red";
		} else if(admin_id==""&&admin_password=="") {
			document.getElementById("admin_id").style.border="2px solid red";
			document.getElementById("admin_password").style.border="2px solid red";
		} else {
			$.ajax({
				type: "POST",
				url: "/BuyMe/admin/login.php",
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
						document.getElementById("admin_id").value="";
						document.getElementById("admin_password").value="";
						document.getElementById("admin_id").style.border="";
						document.getElementById("admin_password").style.border="";
					} else if (result=="login_successfully") {
						document.location = "/BuyMe/admin/home.php";
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
	
	var len = document.getElementById('admin_id').value.length;
	if (len >= 100) {
		document.getElementById('admin_id').value = document.getElementById('admin_id').value.substring(0, 100);
	}

	var len_1 = document.getElementById('admin_password').value.length;
	if (len_1 >= 15) {
		document.getElementById('admin_password').value = document.getElementById('admin_password').value.substring(0, 15);
	}
}