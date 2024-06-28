<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>php_pyramid_1</title>
</head>

<body>
	<?php
	echo "using for loop ,creating a pyramid as given in question<br>";
	for ($i = 0; $i < 8; $i++) {
		for ($j = 0; $j <= $i; $j++) {
			echo "<b>*<b>";
		}
		echo "<br>";
	}
	?>
</body>

</html>