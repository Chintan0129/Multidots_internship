<?php
try {
    // Get the current timestamp
    date_default_timezone_set('Asia/Kolkata'); //I add this line beacuse it is showing different timezone time ,so i set default timezone .
    $timestamp = time(); 

    // Extract hour and minute from the timestamp
    $hour = date('H', $timestamp); 
    $minute = date('i', $timestamp); 

    // Determine greeting based on the hour
    if ($hour >= 5 && $hour < 12) {
        $greeting = "Good morning"; 
    } else if ($hour >= 12 && $hour < 18) { 
        $greeting = "Good afternoon"; 
    } else { 
        $greeting = "Good evening"; 
    }

    
    $timeArray = array(
        "hour" => $hour, 
        "minute" => $minute, 
        "greeting" => $greeting 
    );

    echo json_encode($timeArray); 
} catch (Exception $e) {
    
    echo json_encode(array("error" => $e->getMessage())); 
}
?>
