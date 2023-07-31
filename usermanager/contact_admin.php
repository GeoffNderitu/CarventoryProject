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
    // Retrieve the message data from the form
    $user_name = $_POST['username'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $userId = $_SESSION['user_id'];

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

    // Store the message in the 'contact_admin' table with the user's ID as a foreign key
    $sql = "INSERT INTO contact_admin (username, subject, message, user_id) VALUES ('$user_name', '$subject', '$message', $userId)";

    if ($conn->query($sql) === TRUE) {
        // Message stored successfully
        echo "Message sent successfully.";
    } else {
        // Error storing the message
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Contact Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<!-- Navigation bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="../index.php">Home</a>

  <div class="ml-auto d-flex align-items-center">
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <button class="navbar-toggler ml-3" type="button" id="sidebarToggle">
      <i class="fas fa-cog"></i>
    </button>
  </div>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">

    </ul>
  </div>
</nav>


<!-- Sidebar menu -->
<div class="sidebar">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link text-light" href="change_password.php"><i class="fas fa-key"></i> Change Password</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="update_info.php"><i class="fas fa-user-edit"></i> Update Information</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="contact_admin.php"><i class="fas fa-envelope"></i> Contact Administrator</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="contact_admin.php"><i class="fas fa-envelope"></i> Messages</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="add_car.php"><i class="fas fa-car"></i> Add Car</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="update_car.php"><i class="fas fa-car"></i> Update Car Information</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="../manage_car_problems.php"><i class="fas fa-exclamation-triangle"></i> Manage Car Problems</a>
    </li>
  </ul>
</div>
    <div class="container bebauser">
        <h1 class="mt-4">Contact Admin</h1>
        <form method="POST" action="contact_admin.php">
        <div class="form-group">
                <label for="username">User Name:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" class="form-control" name="subject" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" name="message" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-dark">Submit</button>
            </div>
        </form>
    </div>
    <footer class="footer w-100">
    <div class="container-fluid">
      <div class="card footer-card">
        <div class="row">
          <div class="col-lg-6">
            <ul class="footer-links">
              <li><a href="../index.php">Home</a></li>
              <li><a href="#">Browse Cars</a></li>
              <li><a href="#">Contact Us</a></li>
            </ul>
          </div>
          <div class="col-lg-6">
            <div class="footer-social-icons">
              <a href="#"><i class="fab fa-facebook-f"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <p class="footer-text mb-2">© 2023 CarVentory. All rights reserved.</p>
          </div>
        </div>
      </div>
    </div>
  </footer>
    <script>
  $(document).ready(function() {
    // Toggle sidebar menu
    $('#sidebarToggle').click(function() {
      $('.sidebar').toggleClass('show');
      $('.content').toggleClass('sidebar-open');
    });
  });
</script>


</body>
</html>
