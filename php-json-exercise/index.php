<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>php-json-exercise</title>
	<link rel="stylesheet" href="./css/style.css">
</head>

<body>
	<?php


	$jsondata_given = '[
		{
			"name": "Ayush Singh",
			"age": "22",
			"school": "Dehradoon Public school"
		},
		{
			"name": "Smith Patel",
			"age": "18",
			"school": "St. Xaviour school"
		},
		{
			"name": "Rena Pamar",
			"age": "12",
			"school": "Delhi Public school"
		}
	]';

	$arr = json_decode($jsondata_given, true);
	// echo var_dump($arr); checking  if the JSON data is converted to an php array or not

	echo '<table>';
	echo '<tr><th>Name</th><th>Age</th><th>School</th></tr>';
	foreach ($arr as $person) {
		echo '<tr>';
		echo '<td>' . $person['name'] . '</td>';
		echo '<td>' . $person['age'] . '</td>';
		echo '<td>' . $person['school'] . '</td>';
		echo '</tr>';
	}
	echo '</table>';



	?>
</body>

</html>