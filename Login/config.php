<?php
$servername = "43.204.212.15";
$username = "admin";
$password = "nirvana1234";
$dbname = "server-nirvana";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
