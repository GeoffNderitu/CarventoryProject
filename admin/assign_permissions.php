<?php
// Get the user ID from the query string
$id = $_GET['id'];

// Replace database connection details with your own
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Close the database connection
$conn->close();
?>
