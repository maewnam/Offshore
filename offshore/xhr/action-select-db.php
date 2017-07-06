<?php
	include_once "../config/define.php";
	$dbserver = "localhost";
	$dbname = $_REQUEST['dbname']; 
	$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, $dbname);
	
	if ($mysqli->connect_error) {
		$result = array(
			"success" => false,
			"error_code" => $mysqli->connect_errno,
			"error_message" => $mysqli->connect_error
		);
	}else{
		$table = array();
		$sql = "SELECT SUM(id) FROM concurrents";
		$rst = mysqli_query($mysqli,$sql);
		$line = mysqli_fetch_array($rst);
		
		$result = array(
			"success" => true,
			"host_info" => $mysqli->host_info,
			"concurrent" => $line[0]
		);
	}
	
	echo json_encode($result);
	$mysqli->close();
?>