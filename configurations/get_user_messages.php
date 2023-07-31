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

// Fetch responses from the database
$sql = "SELECT id, message FROM responses";
$result = $conn->query($sql);

$responses = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response = array(
            'id' => $row['id'],
            'message' => $row['message']
        );
        $responses[] = $response;
    }
}

// Close the database connection
$conn->close();

// Return the responses as JSON
header('Content-Type: application/json');
echo json_encode($responses);
?>
