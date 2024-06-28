<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>php-pyramid-2</title>
</head>

<body>
	<?php
	$no_of_rows = 5;

	// Outer loop to iterate over each row 
	for ($i = 0; $i < $no_of_rows; $i++) {
		// Inner loop to print  spaces before the *
		for ($j = 0; $j < $no_of_rows - $i - 1; $j++) {
			echo "&nbsp";
		}
		// Inner loop to print * for the current row
		for ($j = 0; $j <= $i; $j++) {
			echo " * ";
		}
		echo "<br>";
	}
	?>
</body>
</html>