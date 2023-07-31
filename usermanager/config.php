<?php

require_once('db_connection.php');

// Get the user's role ID from the database
$userID = 3; // Replace with the actual user ID
$query = "SELECT role_id FROM users WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($roleID);

// Fetch the role ID
if ($stmt->fetch()) {
    
} else {
    echo "User not found";
}

// Close the statement and database connection
$stmt->close();
$connection->close();
?>
