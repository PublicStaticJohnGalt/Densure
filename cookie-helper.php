<?php

require 'config.php';

$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}




$sql = "REPLACE INTO cookies (session_id, clicked_plan, sorted_by_name, sorted_by_price) VALUES ('" . $_COOKIE["PHPSESSID"] . "', '" . $_COOKIE["clickedPlan"] . "', '" . $_COOKIE["sortedByName"] . "', '" . $_COOKIE["sortedByPrice"] . "')";

if(mysqli_query($link, $sql)){
	echo json_encode("Records inserted successfully.");
} else {
	echo json_encode("ERROR: Could not able to execute $sql. " . mysqli_error($link));
}
