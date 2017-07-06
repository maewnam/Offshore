<?php
	include_once "../config/define.php";
	$dbserver = "localhost";
	$dbname = $_REQUEST['dbname']; 
	$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, $dbname);
	mysqli_query($mysqli,"SET NAMES 'UTF8'");
	$tablename = 'concurrents';
	
	if ($mysqli->connect_error) {
		$result = array(
			"success" => false,
			"error_code" => $mysqli->connect_errno,
			"error_message" => $mysqli->connect_error
		);
		var_dump($result);
	}else{
		$columns = array();
		echo '<table class="table table-condensed table-bordered">';
			echo '<thead>';
				echo '<tr>';
				$sql = "SHOW COLUMNS FROM ".$tablename;
				
				$rst = mysqli_query($mysqli,$sql);
				while($line = mysqli_fetch_array($rst)){
					array_push($columns,$line[0]);
					echo '<th>';
						echo $line[0];
					echo '</th>';
				}
				echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
				$sql = "SELECT * FROM ".$tablename;
				$rst = mysqli_query($mysqli,$sql);
				while($line = mysqli_fetch_array($rst)){
					echo '<tr>';
					for($i=0;$i<count($columns);$i++){
						echo '<td>';
							echo $line[$i];
						echo '</td>';
					}
					echo '</tr>';
				}
			echo '</tbody>';
		echo '</table>';
		
		
	}
	$mysqli->close();
?>