<?php
$servername = "172.104.166.158";
$username = "training_chintans";
$password = "ctR0P7ySGdaYkrl1";
$dbname = "training_chintans";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
?>