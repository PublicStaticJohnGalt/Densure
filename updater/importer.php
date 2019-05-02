<?php

require '../config.php';

$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$zilart = simplexml_load_file('https://zilart.ru/apart_manager/get_feed/living/yandex');
			
foreach($zilart->offer as $offer) {
	$plan;
	$images = '';
	$building_name;
	$price;
	$floor;
	$description;
				
	foreach($offer->image as $image) {
		if(substr(trim($image), 0, strlen('https://zilart.ru/assets/images/apts/') ) === 'https://zilart.ru/assets/images/apts/') {
			$plan = trim($image);
			break;
		}
	}

	foreach($offer->image as $image) {						
		if(substr(trim($image), 0, strlen('https://zilart.ru/public/images/construction/') ) === 'https://zilart.ru/public/images/construction/') {
			$images .= trim($image) . ",";
		}						
	}
	
	$images = substr($images, 0, -1);

	$building_name = $offer->{'building-name'};

	$price = $offer->{'price'}->{'value'};

	$floor = $offer->{'floor'};

	$description = $offer->{'description'};

							
	$sql = "INSERT INTO estate (plan, images, building_name, price, floor, description) VALUES ('" . $plan . "', '" . $images . "', '" . $building_name . "', " . $price . ", " . $floor . ", '" . $description . "')";
	if(mysqli_query($link, $sql)){
		echo "Records inserted successfully.";
	} else{
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}									

}

$mgcom = simplexml_load_file('http://public.files.mgcom.ru/w/etalon-invest/etalon-normandiya_ya_free.xml');

foreach($mgcom->offer as $offer) {
	$plan;
	$images = '';
	$building_name;
	$price;
	$floor;
	$description;
				
	foreach($offer->image as $image) {
		if(substr(trim($image), 0, strlen('http://public.files.mgcom.ru/w/etalon-invest/normandiya_plans/') ) === 'http://public.files.mgcom.ru/w/etalon-invest/normandiya_plans/') {
			$plan = trim($image);
			break;
		}
	}

	foreach($offer->image as $image) {						
		if(substr(trim($image), 0, strlen('http://public.files.mgcom.ru/etalon/render/normandia/') ) === 'http://public.files.mgcom.ru/etalon/render/normandia/') {
			$images .= trim($image) . ",";
		}						
	}
	
	$images = substr($images, 0, -1);

	$building_name = $offer->{'building-name'};

	$price = $offer->{'price'}->{'value'};

	$floor = $offer->{'floor'};

	$description = $offer->{'description'};

							
	$sql = "INSERT INTO estate (plan, images, building_name, price, floor, description) VALUES ('" . $plan . "', '" . $images . "', '" . $building_name . "', " . $price . ", " . $floor . ", '" . $description . "')";
	if(mysqli_query($link, $sql)){
		echo "Records inserted successfully.";
	} else{
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}									

}

mysqli_close($link);