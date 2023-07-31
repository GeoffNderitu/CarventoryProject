<?php
// Get the user ID from the query string
$id = $_GET['id'];

// Replace database connection details with your own
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CarNation";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete the user from the database
$sql = "DELETE FROM users WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "User deleted successfully.";
    header("Location: user_manager.php");
} else {
    echo "Error deleting user: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
