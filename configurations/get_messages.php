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

// Fetch all messages from the 'contact_admin' table
$sql = "SELECT id, username, subject FROM contact_admin";
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
