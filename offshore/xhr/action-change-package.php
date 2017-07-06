<?php
	include_once "../config/define.php";
	$dbserver = "localhost";
	$dbname = $_REQUEST['dbname']; 
	$concurrent = $_REQUEST['concurrent']; 
	$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, $dbname);
	mysqli_query($mysqli,"SET NAMES 'UTF8'");
	$tablename = 'concurrents';
	
	function RandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 20; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}
	
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
		
		for($i=0;$i<$concurrent;$i++){
			$token = RandomString();
			$sql = "INSERT INTO ".$tablename."(id,token,package,created,updated,status,session_id,user_id,user_name,device,login,connected)";
			$sql .= "VALUES(DEFAULT,'$token',1,NOW(),NOW(),0,NULL,NULL,NULL,NULL,NULL,NULL)";
			mysqli_query($mysqli,$sql);
		}
	}
	$mysqli->close();
?>