<?php 

try {
	
	include_once 'db_conn.php';
	
	$q="SELECT COUNT(*) as total FROM category";
	$s=$conn->prepare($q);
	$s->execute();
	$r = $s->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($r as $res) {
		$limit = $res['total'];
	}
	
	$query="SELECT category_id, category_name FROM category LIMIT 1, $limit";
	$stmt=$conn->prepare($query);
	$stmt->execute();
	$count_row = $stmt->rowCount();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if($count_row!=0) {
		
		echo json_encode($result);
		
	} else if($count_row==0) {
		
		echo "no_category";
	}

} catch(PDOExeption $e) {
	
	echo "Error: ".$e->getMessage();
}

?>