// JavaScript Document

function success(position) {
	var mapcanvas = document.createElement('div');
	mapcanvas.id = 'mapcontainer';
	mapcanvas.style.height = '420px';
	mapcanvas.style.width = '700px';
	mapcanvas.style.margin = 'auto';
	document.querySelector('article').appendChild(mapcanvas);
	// get latitude and longitute of the current visitor
	var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	var options = {
		zoom: 15,
		center: coords,
		mapTypeControl: false,
		navigationControlOptions: {
			style: google.maps.NavigationControlStyle.SMALL
		},
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("mapcontainer"), options);
	var marker = new google.maps.Marker({
		position: coords,
		map: map,
		title:"Your current location."
	});
	// show in textbox
	document.getElementById("location").value=coords;
	
}

function save() {
	window.opener.document.getElementById('ur_location').value = document.getElementById("location").value;
	window.opener.document.getElementById("ur_new_location").value=document.getElementById("location").value;
	window.close();
}

// check is the browser support Geolocation API
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(success);
} else {
  error('Geo Location is not supported');
}

$(document).ready(function() {
	$('#save').click(function() {
		var user_id = document.getElementById('user_id').textContent;
		if(user_id=="") {
			// do nothing
		} else {
			var shop_location = document.getElementById('location').value;
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/update_profile.php",
				data: {user_id: user_id, shop_location: shop_location},
				success:
				function(result) {
					save();
				}
			});
		}
		return false;
	});
});