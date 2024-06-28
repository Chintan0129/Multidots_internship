<?php
try {
    // Attempt to fetch a random quote from the Quotable API
    $response = file_get_contents("https://api.quotable.io/random");

    // Output the response (which contains the random quote)
    echo $response;
} catch (Exception $e) {
    // Return an error message in JSON format
    echo json_encode(array("error" => $e->getMessage()));
}
?>
