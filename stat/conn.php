<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "  ";
$database = "pfe";

// Create a database connection
$connection = new mysqli($host, $username, $password, $database);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// You can perform additional configuration or setup here if needed

?>