<?php
	$dbserver = "localhost";
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password']; 
	$dbname = $_REQUEST['dbname']; 
	$tablename = $_REQUEST['tablename']; 
	
	$mysqli = new mysqli($dbserver, $username, $password, $dbname);
	mysqli_query($mysqli,"SET NAMES 'UTF8'");
	
	if ($mysqli->connect_error) {
		$result = array(
			"success" => false,
			"error_code" => $mysqli->connect_errno,
			"error_message" => $mysqli->connect_error
		);
		var_dump($result);
	}else{
		$columns = array();
		$sql = "TRUNCATE ".$tablename;
		$rst = mysqli_query($mysqli,$sql);

	}
	$mysqli->close();
?>