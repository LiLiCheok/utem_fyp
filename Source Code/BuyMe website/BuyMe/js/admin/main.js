// JavaScript Document

$(document).ready(function() {
	$('.input-group.date').datetimepicker({
		format: 'yyyy-mm-dd',
		todayHighlight: true,
		startView: 'month',
		minView: 'month',
		autoclose: true  
	});  
});