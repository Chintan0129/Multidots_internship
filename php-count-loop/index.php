<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>php-count-loop</title>
</head>

<body>
	<?php
	$count = 30;
	echo "Using for loop counting 15 to 30<br>";
	for ($i = 15; $i <= $count; $i++) {
		echo "<b>$i<b> <br>";
	}

	/*
		echo"Using while loop";
		$i=15;
		while($i<=$count) {
			echo "<b>$i<b> <br>";
			$i++;
		}
	*/
	/*
		echo "Using do while loop";
		$i=15;
		do {
			echo "<b>$i<b> <br>";
			$i++;
		} while ($i <=$count);
	*/
	?>

</body>

</html>