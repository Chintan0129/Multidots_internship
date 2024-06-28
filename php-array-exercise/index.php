<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>php_array_exercise</title>
</head>
<body>
	
<?php
$givenArray = array(
    "Italy"=>"Rome",
    "Luxembourg"=>"Luxembourg",
    "Belgium"=> "Brussels",
    "Denmark"=>"Copenhagen",
    "Finland"=>"Helsinki",
    "France" => "Paris",
    "Slovakia"=>"Bratislava",
    "Slovenia"=>"Ljubljana",
    "Germany" => "Berlin",
    "Greece" => "Athens",
    "Ireland"=>"Dublin",
    "Netherlands"=>"Amsterdam",
    "Portugal"=>"Lisbon",
    "Spain"=>"Madrid",
    "Sweden"=>"Stockholm",
    "United Kingdom"=>"London",
    "Cyprus"=>"Nicosia",
    "Lithuania"=>"Vilnius",
    "Czech Republic"=>"Prague",
    "Estonia"=>"Tallin",
    "Hungary"=>"Budapest",
    "Latvia"=>"Riga",
    "Malta"=>"Valetta",
    "Austria" => "Vienna",
    "Poland"=>"Warsaw"
);

// Extract capitals into another array
$capitalsArray = array_values($givenArray);

// using sorting algorithm (Bubble Sort)
$arraySize = count($capitalsArray);
for ($i = 0; $i < $arraySize - 1; $i++) {
    for ($j = 0; $j < $arraySize - $i - 1; $j++) {
        // Compare adjacent elements
        if (strcasecmp($capitalsArray[$j], $capitalsArray[$j + 1]) > 0) {
            // Swap values
            $temp = $capitalsArray[$j];
            $capitalsArray[$j] = $capitalsArray[$j + 1];
            $capitalsArray[$j + 1] = $temp;
        }
    }
}

// Output sorted capitals with corresponding countries
foreach ($capitalsArray as $capital) {
    foreach ($givenArray as $country => $capitalName) {
        if ($capitalName === $capital) {
            echo "<br><b>The capital of $country is $capital<b>";
            break;
        }
    }
}


// other way to solve the exercise is using asort() prebuilt php function , in this it will sort value of associative array in ascending order.
/* below is code for asort function to solve the exercise
   asort($givenArray);
   foreach ($givenArray as $country => $capital) {
    	echo "<br>The capital of $country is $capital" ;
}
*/
?>

	
</body>
</html>