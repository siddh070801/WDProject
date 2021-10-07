<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "records_db";

// Create connection
$conn = new PDO("mysql:host=" .$servername. "; dbname=" . $dbname, $username, $password);

// Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }