<?php
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

// Retrieve the message ID from the request
$messageId = $_GET['id'];

// Fetch the message details for the given ID
$sql = "SELECT username, subject, message FROM contact_admin WHERE id = $messageId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Return the message details as JSON
    $message = $result->fetch_assoc();
    echo json_encode($message);
}

$conn->close();
?>
