<?php
try {
    // Fetch location data
    $locationResponse = file_get_contents("http://ip-api.com/json"); // Sending a GET request to fetch location data
    $locationData = json_decode($locationResponse); // Decoding JSON response into a PHP object

    // Extract city and country code
    $city = $locationData->city; 
    $countryCode = $locationData->countryCode; 

    // Fetch timezone data using IP address
    $timezoneResponse = file_get_contents("http://worldtimeapi.org/api/ip/{$locationData->query}"); 
    $timezoneData = json_decode($timezoneResponse); 

    // Prepare response data
    $responseData = array(
        "city" => $city, 
        "countryCode" => $countryCode, 
        "timezone" => $timezoneData->timezone, 
        "abbreviation" => $timezoneData->abbreviation, 
        "day_of_year" => $timezoneData->day_of_year, 
        "day_of_week" => $timezoneData->day_of_week, 
        "week_number" => $timezoneData->week_number 
    );

    // Encode response data to JSON format and echo
    echo json_encode($responseData); 
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage())); 
}
?>
