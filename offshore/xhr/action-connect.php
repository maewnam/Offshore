<?php
	include_once "../config/define.php";
	$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS);
	
	if ($mysqli->connect_error) {
		$result = array(
			"success" => false,
			"error_code" => $mysqli->connect_errno,
			"error_message" => $mysqli->connect_error
		);
	}else{
		
		if($_REQUEST['password'] != "abox.space"){
			$result = array(
				"success" => false,
				"error_message" => "Your password is worng!"
			);
		}else{
			
			$database = array();
			$sql = "SHOW DATABASES";
			$rst = mysqli_query($mysqli,$sql);
			while($line = mysqli_fetch_array($rst)){
				$mysqli->select_db($line[0]);
				$sql = "SHOW TABLES;";
				$rst_table = mysqli_query($mysqli,$sql);
				while($line_table = mysqli_fetch_array($rst_table)){
					if($line_table[0]=="concurrents"){
						array_push($database,$line[0]);
					}
				}
			}
			
			$result = array(
				"success" => true,
				"host_info" => $mysqli->host_info,
				"database" => $database
			);
		}
	}
	
	echo json_encode($result);
	$mysqli->close();
?>