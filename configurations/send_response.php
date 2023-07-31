<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or display an error message
    header('Location: ../usermanager/login.php');
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $messageId = $_POST['id']; // Change 'message_id' to 'id'
    $responseMessage = $_POST['admin_message'];
    $adminUserId = $_SESSION['user_id'];

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

    // Update the message with the response in the database
    $sql = "INSERT INTO responses (message, user_id, message_id) VALUES ('$responseMessage', '$adminUserId', '$messageId')";

    if ($conn->query($sql) === TRUE) {
        echo "Response sent successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>
