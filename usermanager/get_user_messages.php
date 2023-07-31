<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CarNation";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user messages from the 'contact_admin' table (based on user ID or any other identifier)
$messageId = ['id']; // Replace with the actual user ID
$sql = "SELECT id, subject, message, response FROM contact_admin WHERE id = $messageId";
$result = $conn->query($sql);

$messages = array();

if ($result->num_rows > 0) {
    // Store each message in an array
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

// Return messages as JSON
echo json_encode($messages);

$conn->close();
?>
