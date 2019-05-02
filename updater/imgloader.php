<?php

require '../config.php';

ini_set('max_execution_time', 0);

$connection = new mysqli("localhost", "foxyjoe_test", "qwertycoder123", "foxyjoe_test");
 
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$resultArr = array();
$query = $connection->query("SELECT `images` FROM `estate`;");

while($result = $query->fetch_assoc()){
	$images = explode(',', $result['images']);
	
	$imagesNew = '';
	
	foreach($images as $item) {
	
		$urlParts = explode('/', trim(htmlspecialchars($item)));
		$folder = "images/" . $urlParts[3] . '/' . $urlParts[4] . '/' . $urlParts[5];

		if(!file_exists($folder . '/' . array_values(array_slice($urlParts, -1))[0])) {
			$img_url = trim(htmlspecialchars($item));
			
			$Headers = @get_headers($img_url);
			if(preg_match("|200|", $Headers[0])) {
				if (!file_exists($folder)) {
					mkdir($folder, 0777, true);
				}
				
				$image = file_get_contents($img_url);
				file_put_contents($folder . '/' . array_values(array_slice($urlParts, -1))[0], $image);
			}
			
			
		}
		
		$imagesNew .= $folder . '/' . array_values(array_slice($urlParts, -1))[0] . ',';
	}
	
	$imagesNew = substr($imagesNew, 0, -1);
	
	$sql = "UPDATE estate SET images = '" . $imagesNew . "' WHERE images = '" . $result['images'] . "'";
	if(mysqli_query($connection, $sql)){
		echo "Records inserted successfully.<br>";
	} else{
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection);
	}
}

mysqli_close($connection);
session_destroy(); 