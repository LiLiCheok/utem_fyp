<?php

try {

	include_once 'db_conn.php';
		
	$user_id = $_POST['user_id'];
	
	$q = "SELECT del_charge, subtotal from cart WHERE status='$user_id'";
	$s = $conn->prepare($q);
	$s->execute();
	$r = $s->rowCount();
	if($r!=0) {
		$res = $s->fetchAll(PDO::FETCH_ASSOC);
		$total = 0;
		foreach ($res as $r) {
			$charge = $r['del_charge'];
			$sub = $r['subtotal'];
			$subtotal = $sub+($sub*$charge/100);
			$total+=$subtotal;
		}
		echo $total;
	} else {
		echo "no_total";
	}
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>