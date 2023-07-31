<?php
session_start();

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

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $brand = $_POST['brand'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $image = $_FILES['image']['name'];
    $specs = $_POST['specs'];

    // Retrieve the user ID from the users table
    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        // Update the data in the user_cars table
        $car_id = $_GET['id'];
        $sql = "UPDATE user_cars SET brand='$brand', make='$make', model='$model', image='$image', specs='$specs' WHERE id='$car_id'";
        
        if ($connection->query($sql) === TRUE) {
            // Redirect the user to the updated car details page
            header("Location: car_details.php?id=$car_id");
            exit();
        } else {
            echo "Error updating car: " . $connection->error;
        }
    } else {
        // Handle the case when the user ID is not found
    }

    // Close the database connection
    $connection->close();
}
?>
