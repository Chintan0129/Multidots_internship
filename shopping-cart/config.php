<?php
$servername = "172.104.166.158";
$username = "training_chintans";
$password = "ctR0P7ySGdaYkrl1";
$dbname = "training_chintans";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
