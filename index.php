<?php 
ini_set('session.gc_maxlifetime', 60*60*24*365);
session_start(); 
?>

require 'config.php';

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Real Estate</title>
	
	<style>
		table {
			margin-bottom: 70px;
			width: 100%;
		}
		table thead tr th {
			background-color: #ffa500;
			text-align: center;
			padding: 10px 0;
		}
		table tbody tr:nth-child(even) td {
			background-color: #efefef;
			padding: 10px;
			text-align: center;
		}
		table tbody tr:nth-child(odd) td {
			background-color: white;
			padding: 10px;
			text-align: center;
		}
		table img {
			width: 100px;
			height: auto;
		}
		
		table#real-estate tr td:last-child {
			width: 20%;
		}

		table tr td:nth-child(2) {
			width: 25%;
		}
		table tr td:nth-child(2) img {
			width: 50px;
			margin: 3px;
		}
		
	</style>
	<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
</head>
<body>

	<table>
		<thead>
			<tr>
				<th>ID действия</th>
				<th>Кол-во уникальных пользователей</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$connection = new mysqli($db_host, $db_user, $db_password, $db_name);
				
				if($connection === false){
					die("ERROR: Could not connect. " . mysqli_connect_error());
				}
				
				$query = $connection->query("SELECT * FROM cookies;");
				$id_1 = 0;
				$id_2 = 0;
				$id_3 = 0;
				while($result = $query->fetch_assoc()){
					if($result['clicked_plan'] == 1) {
						$id_1++;
					}
					if($result['sorted_by_name'] == 1) {
						$id_2++;
					}
					if($result['sorted_by_price'] == 1) {
						$id_3++;
					}
				}
			?>
			<tr>
				<td>1 (Клик на изображение планировки в таблице)</td>
				<td><?php echo $id_1; ?></td>
			</tr>
			<tr>
				<td>2 (Сортировка по названию) </td>
				<td><?php echo $id_2; ?></td>
			</tr>
			<tr>
				<td>3 (Сортировка по цене) </td>
				<td><?php echo $id_3; ?></td>
			</tr>
		</tbody>
	</table>
	
	<table id="real-estate">
		<thead>
			<tr>
				<th>Планировка</th>
				<th>Изображения</th>
				<th>Жилищный комплекс</th>
				<th>Стоимость</th>
				<th>Этаж</th>
				<th>Описание</th>
			</tr>
		</thead>
	</table>
	
	

	<script>
		$(document).ready(function() {
			$("#real-estate").DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "table-builder.php",
				"language": {
					"processing": "Загрузка...",
					"paginate": {
						"previous": "Пред.",
						"next": "След."
					}
				},
				"bFilter": false,
				"bLengthChange": false,
				"bInfo": false,
				"order": [[ 2, "asc" ]],
				"columns": [
					{ "orderable": false },
					{ "orderable": false },
					null,
					null,
					null,
					{ "orderable": false }
				],
				"deferRender": true
			}); 
		});
		
		function createCookie(name,value,days) {
			var expires = "";
			if (days) {
				var date = new Date();
				date.setTime(date.getTime() + (days*24*60*60*1000));
				expires = "; expires=" + date.toUTCString();
			}
			document.cookie = name + "=" + (value || "")  + expires + "; path=/";
		}
		
		$(document).on('click', '.plan', function() {
			createCookie("clickedPlan", "1", 365);
			sendCookies();
		});
		$(document).on('click', 'table#real-estate thead tr th:nth-child(3)', function() {
			createCookie("sortedByName", "1", 365);
			sendCookies();
		});
		$(document).on('click', 'table#real-estate thead tr th:nth-child(4)', function() {
			createCookie("sortedByPrice", "1", 365);
			sendCookies();
		});
		
		
		function sendCookies() {
			$.ajax({                    
				url: 'cookie-helper.php',     
				type: 'get',
				success: function (data) {
					console.log(data);
				},
				error: function(xhr, status, error) {
					
				}
			});
		}
	</script>
</body>
</html>
