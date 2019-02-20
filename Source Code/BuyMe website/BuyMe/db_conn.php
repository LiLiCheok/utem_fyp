<?php

/**
 * Database Connection
 */

$db_host = 'localhost';
$db_username = 'root';
$db_password = '2mCNRs6dsW5wY9sn';
$db_name = 'buyme_db';

//$GOOGLE_API_KEY = "AIzaSyB5ytROEwjoYOS9-kFxtOEI1sp0M_uo8go";

try {
	
	$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
	
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	// Testing
	// echo "Connected successfully"; 
	
} catch(PDOException $e) {
	
	echo "Connection failed: " . $e->getMessage();
	
}

?>