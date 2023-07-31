<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "CarNation";

// Create a connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form fields are set in the $_POST array
if (isset($_POST['id'], $_POST['brand'], $_POST['make'], $_POST['model'], $_POST['image'], $_POST['image2'], $_POST['image3'], $_POST['image4'], $_POST['specs'])) {
    // Get the car details from the $_POST array
    $carId = $_POST['id'];
    $brand = $_POST['brand'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $image = $_POST['image'];
    $image2 = $_POST['image2'];
    $image3 = $_POST['image3'];
    $image4 = $_POST['image4'];

    // Escape special characters in the specs
    $specs = mysqli_real_escape_string($connection, $_POST['specs']);

    // Update the car details in the database
    $query = "UPDATE cars SET brand = '$brand', make = '$make', model = '$model', image = '$image', image2 = '$image2', image3 = '$image3', image4 = '$image4', specs = '$specs' WHERE id = '$carId'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "Car details updated successfully!";
    } else {
        echo "Error updating car details: " . mysqli_error($connection);
    }
} else {
    echo "Incomplete form data. Please make sure all fields are filled.";
}

// Close the database connection
mysqli_close($connection);
?>
