// JavaScript Document

$(document).ready(function() {
	var user_id = document.getElementById('user_id_1').textContent;
	var page_start = "";
	
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
		url: "/BuyMe/seller/get_page_no.php",
		data: {user_id: user_id},
		success:
		function(result) {
			var all_page = result;
			for(page_next=1;page_next<=all_page;page_next++) {
				if(page_next==1) {
					$('.pagination').append(
						'<li class="page-item">' +
							'<a class="page-link" href="javascript: void(0);"' +
								'onclick="page(\'' + page_next + '\');">' +
								page_next +
							'</a>' +
						'</li>'
					);
				} else {
					$('.pagination').append(
						'<li class="page-item">' +
							'<a class="page-link" href="javascript: void(0);"' +
								'onclick="page(\'' + page_next + '\');">' +
								page_next +
							'</a>' +
						'</li>'
					);
				}
			}
		}
	});
	
	$.ajax({
		url: "/BuyMe/seller/get_product_id.php",
		success:
		function(result) {
			document.getElementById('show_pro_id').textContent="("+result+")";
		}
	});
	
	page(page_start);
	
	$.ajax({
		url: "/BuyMe/seller/get_category.php",
		success:
		function (result) {
			var json_obj = $.parseJSON(result);
			for (var i in json_obj) {
				$('#category_id').append($('<option>').text(json_obj[i].category_name).attr('value', json_obj[i].category_id));
				$('#new_category_id').append($('<option>').text(json_obj[i].category_name).attr('value', json_obj[i].category_id));
			}
		}
	});
	
	$('#search_product_btn').click(function() {
		var search_data = document.getElementById('search_product').value;
		if(search_data=="") {
			document.getElementById('search_product').style.border="2px solid red";
			document.getElementById('product_table').style.display="block";
			document.getElementById('search_product_table').style.display="none";
		} else {
			$.ajax({
				type: "POST",
				url: "/BuyMe/seller/search_product.php",
				data: {user_id: user_id, search_data: search_data},
				success:
				function (result) {
					if(result=="no_product") {
						document.getElementById('product_table').style.display="none";
						document.getElementById('search_product_table').style.display="block";
						var trHTML_search = '';
						trHTML_search +=
						'<td colspan="8">No such product.</td>';
						$('#search_product_table > tbody').html("");
						$('#search_product_table > tbody').append(trHTML_search);
					} else if(result!="no_product") {
						document.getElementById('product_table').style.display="none";
						document.getElementById('search_product_table').style.display="block";
						var json_obj_search = $.parseJSON(result);
						var trHTML_search = '';
						for (var i in json_obj_search) {
							var product_id = json_obj_search[i].product_id;
							var category_name = json_obj_search[i].category_name;
							var product_name = json_obj_search[i].product_name;
							var product_desc = json_obj_search[i].product_desc;
							var product_price = json_obj_search[i].product_price;
							var product_image = json_obj_search[i].product_image;
							trHTML_search +=
							'<tr>' +
							'<td>' + category_name + '</td>' +
							'<td>' + product_id + '</td>' +
							'<td>' + '<a href="#view_image_form" data-toggle="modal" data-target="#view_image_form">' +
							'<button class="btn seller_pro_btn">View Product Photo</button></a>' + '</td>' +
							'<td>' + product_name + '</td>' +
							'<td>' + product_desc + '</td>' +
							'<td>' + product_price + '</td>' +
							'<td>' + '<a href="javascript: void(0);" onclick="update_product(\'' + product_id + '\');">' +
							'<img src="../image/edit.png" style="width:20px; height:20px;"></a>' + '</td>' +
							'<td>' + '<a href="javascript: void(0);" onclick="confirm_delete(\'' + product_id + '\');">' +
							'<img src="../image/delete.png" style="width:20px; height:20px;"</a>' + '</td>' +
							'</tr>';
						}
						$('#search_product_table > tbody').html("");
						$('#search_product_table > tbody').append(trHTML_search);
						document.getElementById('ur_pro_image').src = product_image;
					}
				}
			});
		}
		return false;
	});
	
	$('#add_btn').click(function() {
		var category_id = $('#category_id').val();
		var product_name = $('#product_name').val();
		var image = document.getElementById('product_image').files;
		var product_image;
		var product_desc = $('#product_desc').val();
		var product_price = $('#product_price').val();
		var product_price_cent = $('#product_price_cent').val();
		if(category_id!=""&&product_name!=""&&image.length>0&&product_desc!=""&&product_price!=""&&product_price_cent!="") {
			var fileToLoad = image[0];
			var fileReader = new FileReader();
			fileReader.onload = function(fileLoadedEvent) {
				product_image = fileLoadedEvent.target.result; // <--- data: base64
				post_data = {user_id: user_id, category_id: category_id, product_name: product_name, product_image: product_image, product_desc: product_desc, product_price: product_price, product_price_cent: product_price_cent};
				$.ajax({
					type: "POST",
					url: "/BuyMe/seller/add_product.php",
					data: post_data,
					success:
					function(result) {
						if(result="added") {
							swal({
								title: "Added Successfully",
								text: "The product has been added.",
								type: "success",
								timer: 3000
							}, function() {
								window.location.href="http://localhost:82/BuyMe/seller/";
							});
						} else {
							alert(result);	
						}
					}
				});
			}
			fileReader.readAsDataURL(fileToLoad);
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
			$('input[type="file"]').each(function() {
				if($.trim($(this).val())=='') {
					valid = false;
					$(this).css({
						"border": "2px solid red"
					});
					document.getElementById('image_box').style.border="2px solid red";
				} else {
					$(this).css({
						"border": ""
					});
					document.getElementById('image_box').style.border="";
				}
			});
		}
		return false;
	});
	
	$('#update_btn').click(function() {
		var product_id = $('#current_product_id').val();
		var category_id = $('#new_category_id').val();
		var product_name = $('#new_product_name').val();
		var image = document.getElementById('new_product_image').files;
		var product_image;
		var product_desc = $('#new_product_desc').val();
		var product_price = $('#new_product_price').val();
		var product_price_cent = $('#new_product_price_cent').val();
		if(category_id!=""&&product_name!=""&&product_desc!=""&&product_price!=""&&product_price_cent!="") {
			if(image.length>0) {
				var fileToLoad = image[0];
				var fileReader = new FileReader();
				fileReader.onload = function(fileLoadedEvent) {
					product_image = fileLoadedEvent.target.result; // <--- data: base64
					post_data_with_img = {product_id: product_id, category_id: category_id, product_name: product_name, product_image: product_image, product_desc: product_desc, product_price: product_price, product_price_cent: product_price_cent};
					$.ajax({
						type: "POST",
						url: "/BuyMe/seller/update_product.php",
						data: post_data_with_img,
						success:
						function(result) {
							if(result="updated") {
								swal({
									title: "Updated Successfully",
									text: "The product has been updated.",
									type: "success",
									timer: 3000
								}, function() {
									window.location.href="http://localhost:82/BuyMe/seller/";
								});
							} else {
								alert(result);	
							}
						}
					});
				}
				fileReader.readAsDataURL(fileToLoad);
			} else {
				post_data_without_img = {product_id: product_id, category_id: category_id, product_name: product_name, product_image: "", product_desc: product_desc, product_price: product_price, product_price_cent: product_price_cent};
				$.ajax({
					type: "POST",
					url: "/BuyMe/seller/update_product.php",
					data: post_data_without_img,
					success:
					function(result) {
						if(result="updated") {
							swal({
								title: "Updated Successfully",
								text: "The product has been updated.",
								type: "success",
								timer: 3000
							}, function() {
								window.location.href="http://localhost:82/BuyMe/seller/";
							});
						} else {
							alert(result);	
						}
					}
				});
			}
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
		}
		return false;
	});
	
	$('.pro').keyup(function() {
		var len = this.value.length;
		if (len >= 30) {
			this.value = this.value.substring(0, 30);
		}
	});
	$('.pro_1').keyup(function() {
		var len = this.value.length;
		if (len >= 600) {
			this.value = this.value.substring(0, 600);
		}
	});
	$('.pro_2').keyup(function() {
		var len = this.value.length;
		if (len >= 5) {
			this.value = this.value.substring(0, 5);
		}
	});
});

function page(page_start) {
	var user_id = document.getElementById('user_id_1').textContent;
	$.ajax({
		type: "POST",
		url: "/BuyMe/seller/get_product.php",
		data: {user_id: user_id, page_start: page_start},
		success:
		function(result) {
			if(result=="no_product") {
				document.getElementById('hide_info').style.display="block";
				document.getElementById('search_info_container').style.display="none";
			} else if(result!="no_product") {
				document.getElementById('hide_info').style.display="none";
				document.getElementById('search_info_container').style.display="block";
				var json_page_obj = JSON.parse(result);
				var trHTML_page = '';
				for (var i in json_page_obj) {
					var product_id = json_page_obj[i].product_id;
					var category_name = json_page_obj[i].category_name;
					var product_name = json_page_obj[i].product_name;
					var product_desc = json_page_obj[i].product_desc;
					var product_price = json_page_obj[i].product_price;
					var product_image = json_page_obj[i].product_image;
					trHTML_page +=
					'<tr>' +
					'<td>' + category_name + '</td>' +
					'<td>' + product_id + '</td>' +
					'<td>' + '<button class="btn seller_pro_btn" onclick="show(\'' + product_image + '\');" data-toggle="modal" data-target="#view_image_form">View Product Photo</button></a>' + '</td>' +
					'<td>' + product_name + '</td>' +
					'<td>' + product_desc + '</td>' +
					'<td>' + product_price + '</td>' +
					'<td>' + '<a href="javascript: void(0);" onclick="update_product(\'' + product_id + '\');">' +
					'<img src="../image/edit.png" style="width:20px; height:20px;"></a>' + '</td>' +
					'<td>' + '<a href="javascript: void(0);" onclick="confirm_delete(\'' + product_id + '\');">' +
					'<img src="../image/delete.png" style="width:20px; height:20px;"</a>' + '</td>' +
					'</tr>';
				}
				$('#product_table > tbody').html("");
				$('#product_table > tbody').append(trHTML_page);
			} else {
				alert(result);
			}
		}
	});
}

function update_product(product_id) {
	document.getElementById('update_old_product').style.display="block";
	document.getElementById('show_curr_pro_id').textContent="("+product_id+")";
	document.getElementById('search_info_container').style.display="none";
	var update_product_id = product_id;
	$.ajax({
		type: "POST",
		url: "/BuyMe/seller/get_specific_product.php",
		data: {product_id: update_product_id},
		success:
		function (result) {
			if(result=="no_product") {
			} else if(result!="no_product") {
				var json_obj_pro = $.parseJSON(result);
				for (var i in json_obj_pro) {
					var product_price = json_obj_pro[i].product_price;
					document.getElementById('current_product_id').value = json_obj_pro[i].product_id;
					document.getElementById('new_category_id').value = json_obj_pro[i].category_id;
					document.getElementById('new_product_name').value = json_obj_pro[i].product_name;
					document.getElementById('new_product_desc').value = json_obj_pro[i].product_desc;
					document.getElementById('new_product_price').value = product_price.substring(0, product_price.indexOf('.'));
					document.getElementById('new_product_price_cent').value = product_price.substring(product_price.indexOf('.')+1);
					document.getElementById('new_target').src = json_obj_pro[i].product_image;
				}
			}
		}
	});
}

function show(product_image) {
	document.getElementById('ur_pro_image').src = product_image;
}

function confirm_delete(product_id) {
	var delete_product_id = product_id;
	swal({
		title: "Are you sure?",
		text: "You will not be able to recover this product information.",
		type: "warning",
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes, delete it.",
		closeOnConfirm: false,
		showCancelButton: true
	}, function(){
		$.ajax({
			type: "POST",
			url: "/BuyMe/seller/delete_product.php",
			data: {product_id: delete_product_id},
			success:
			function(result) {
				if(result=="deleted") {
					swal({
						title: "Deleted Successfully",
						text: "The product has been deleted.",
						type: "success",
						timer: 2000
					}, function() {
						window.location.href="http://localhost:82/BuyMe/seller/";
					});
				} else {
					alert(result);
				}
			}
		});
	});	
}

// Input only number
function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

// Show Image
function show_image(src, target) {
    var fr = new FileReader();
    fr.onload = function(){
        target.src = fr.result;
    }
    fr.readAsDataURL(src.files[0]);
}

function put_image() {
    var src = document.getElementById("product_image");
    var target = document.getElementById("target");
    show_image(src, target);
}

function add_new_product() {
	document.getElementById('add_new_product').style.display="block";
	document.getElementById('hide_info').style.display="none";
	document.getElementById('search_info_container').style.display="none";
}

function cancel_add() {
	document.getElementById('add_new_product').style.display="none";
	window.location.href="http://localhost:82/BuyMe/seller/";
}

function show_new_image(src, target) {
    var fr = new FileReader();
    fr.onload = function(){
        target.src = fr.result;
    }
    fr.readAsDataURL(src.files[0]);
}

function put_new_image() {
    var src = document.getElementById("new_product_image");
    var target = document.getElementById("new_target");
    show_new_image(src, target);
}

function cancel_update() {
	document.getElementById('update_old_product').style.display="none";
	window.location.href="http://localhost:82/BuyMe/seller/";
}