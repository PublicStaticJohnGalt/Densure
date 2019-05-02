<?php

require 'config.php';

$table = 'estate';
 
$primaryKey = 'id';
 
$columns = array(
    array( 
		'db' => 'plan',
		'dt' => 0,
		'formatter' => function($d, $row) {
			return "<a href='$d' target='_blank'><img class='plan' src='$d' alt='' /></a>";
		}       
	), 
    array(
		'db' => 'images',
		'dt' => 1,
		'formatter' => function($d, $row) {
			$images = explode(',', $d);
			$result = '';
			foreach($images as $image) {
				$result .= '<a href="' . $image . '" target="_blank">';
				$result .= '<img src="' . $image . '" alt="" title="" />';
				$result .= '</a>';
			}
			return $result;
		}
	),
    array('db' => 'building_name',  'dt' => 2),
    array('db' => 'price',     		'dt' => 3),
	array('db' => 'floor',     		'dt' => 4),
	array(
		'db' => 'description',
		'dt' => 5,
		'formatter' => function($d, $row) {
			return mb_strimwidth($d, 0, 255, '...');
		}
	)
	
);
 
$sql_details = array(
    'user' => $db_user,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);
 
require('ssp.class.php');
 
echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);