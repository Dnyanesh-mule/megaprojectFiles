<?php
// db_config.php
$host = 'localhost';
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$database = 'siregaon_bandh'; // Replace with your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>