<?php

require '../config.php';

ini_set('max_execution_time', 0);

$connection = new mysqli($db_host, $db_user, $db_password, $db_name);
 
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$resultArr = array();
$query = $connection->query("SELECT `plan` FROM `estate`;");

while($result = $query->fetch_assoc()){
	$urlParts = explode('/', trim(htmlspecialchars($result['plan'])));
	$folder = "images/" . $urlParts[3] . '/' . $urlParts[4] . '/' . $urlParts[5];

	if(!file_exists($folder . '/' . array_values(array_slice($urlParts, -1))[0])) {
		$img_url = trim(htmlspecialchars($result['plan']));
		
		$Headers = @get_headers($img_url);
		if(preg_match("|200|", $Headers[0])) {
			if (!file_exists($folder)) {
				mkdir($folder, 0777, true);
			}
			
			$image = file_get_contents($img_url);
			file_put_contents($folder . '/' . array_values(array_slice($urlParts, -1))[0], $image);
		}
		
		$sql = "UPDATE estate SET plan = '" . $folder . '/' . array_values(array_slice($urlParts, -1))[0] . "' WHERE plan = '" . $result['plan'] . "'";
		if(mysqli_query($connection, $sql)){
			echo "Records inserted successfully.<br>";
		} else{
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection);
		}
	}
}

mysqli_close($connection);
session_destroy(); 