<?php
	
	include_once '../db_conn.php';
	
	if(isset($_POST['search'])) {
		
		$searchCategory = mysql_real_escape_string($_POST['search_box']);
	
		$query = "SELECT * FROM category WHERE status='active' AND CONCAT(category_id, category_name) LIKE '%".$searchCategory."%'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		$count_row = $stmt->rowCount();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if ($count_row != 0) {
			
			foreach($result as $row) {
				if($row['category_id']=='CTG000') {
					echo "<tr>";
					echo "<td>".$row['category_id']."</td>";
					echo "<td>".$row['category_name']."</td>";
					echo "<td>".$row['create_at']."</td>";
					echo "<td><a href='javascript:void(0);' onClick=\"javascript: alert('This category cannot be updated.');\"; >
						<img src='/BuyMe/image/edit.png' /></a></td>";
					echo "<td><a onClick=\"javascript: alert('This category cannot be deleted.');\"
						href='javascript: void(0);' >
						<img src='/BuyMe/image/delete.png' /></a></td>";
					echo "</tr>";
				} else {
					echo "<tr>";
					echo "<td>".$row['category_id']."</td>";
					echo "<td>".$row['category_name']."</td>";
					echo "<td>".$row['create_at']."</td>";
					echo "<td><a href='javascript:void(0);' onClick=\"javascript:
							$(document).ready(function(){
								$('#updateform').modal('show');
								$('.modal-body #catID').val('".$row['category_id']."');
								$('.modal-body #catName').val('".$row['category_name']."');
							});\"; >
						<img src='/BuyMe/image/edit.png' /></a></td>";
					echo "<td><a onClick=\"javascript: return confirm('Are you sure that you want to delete this record?');\"
						href='deleteCategory.php?catID=".$row['category_id']."' >
						<img src='/BuyMe/image/delete.png' /></a></td>";
					echo "</tr>";
				}
			}
		}
	} else {
	
		// Query the database and get the count
		$query = "SELECT * FROM category WHERE status='active' ORDER BY category_id";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		$count_row = $stmt->rowCount();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if ($count_row != 0) {
			
			foreach($result as $row) {
				if($row['category_id']=='CTG000') {
					echo "<tr>";
					echo "<td>".$row['category_id']."</td>";
					echo "<td>".$row['category_name']."</td>";
					echo "<td>".$row['create_at']."</td>";
					echo "<td><a href='javascript:void(0);' onClick=\"javascript: alert('This category cannot be updated.');\"; >
						<img src='/BuyMe/image/edit.png' /></a></td>";
					echo "<td><a onClick=\"javascript: alert('This category cannot be deleted.');\"
						href='javascript: void(0);' >
						<img src='/BuyMe/image/delete.png' /></a></td>";
					echo "</tr>";
				} else {
					echo "<tr>";
					echo "<td>".$row['category_id']."</td>";
					echo "<td>".$row['category_name']."</td>";
					echo "<td>".$row['create_at']."</td>";
					echo "<td><a href='javascript:void(0);' onClick=\"javascript:
							$(document).ready(function(){
								$('#updateform').modal('show');
								$('.modal-body #catID').val('".$row['category_id']."');
								$('.modal-body #catName').val('".$row['category_name']."');
							});\"; >
						<img src='/BuyMe/image/edit.png' /></a></td>";
					echo "<td><a onClick=\"javascript: return confirm('Are you sure that you want to delete this record?');\"
						href='deleteCategory.php?catID=".$row['category_id']."' >
						<img src='/BuyMe/image/delete.png' /></a></td>";
					echo "</tr>";
				}
			}
		}	
	}
	
?>