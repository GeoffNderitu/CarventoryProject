<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


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
    header("Location: usermanager/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../style.css">
  <style>
    .message-card {
      margin-bottom: 20px;
    }
    .message-card .card-body {
      padding: 15px;
      background: #f5ffff;
    }
    .response-card {
      background-color: #f1f1f1;
      margin-top: 10px;
    }
    .response-card .card-body {
      padding: 10px;
    }
    .navbar {
      position: relative;
      z-index: 1;
      height: 60px;
    }

    .cont-message{
        margin-left:210px;
    }
  .sidebar {
      position: fixed;
      top: 60px;
      left: 0;
      height: 100vh;
      width: 220px;
      background-color: #343a40;
      padding: 20px;
      z-index: 2;
      overflow-y: auto;
    }

    .content {
      margin-left: 240px;
      padding: 20px;
    }

    .navbar-brand {
      display: flex;
      align-items: center;
    }

    .navbar-brand img {
      height: 40px;
      margin-right: 10px;
    }

    .navbar-toggler {
      position: absolute;
      top: 0;
      right: 10px;
    }

    .navbar-nav .nav-link {
      padding: 8px 15px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="../index.php">
    <img src="../resources/images/CarVentory_logo.png" alt="CarVentory Logo">
    CarVentory
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link text-light" href="../index.php">Home</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          Browse Cars
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php
          // Fetch the brand names from the database
          $query = "SELECT DISTINCT brand FROM cars";
          $result = mysqli_query($connection, $query);
          if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $brand = $row['brand'];
              echo "<a class='dropdown-item' href='#'>$brand</a>";
            }
          } else {
            echo "<a class='dropdown-item' href='#'>No brands available</a>";
          }
          ?>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="#">Contact Us</a>
      </li>
      <?php if (isset($_SESSION['username'])) : ?>
        <li class="nav-item">
          <div class="user-info">
            <span class="nav-link text-light">Welcome, <?php echo htmlspecialchars($username); ?>  <i class="fas fa-user-circle"></i></span>
           
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="logout.php">Logout</a>
        </li>
      <?php else : ?>
        <li class="nav-item">
          <a class="nav-link text-light" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="register.php">Register</a>
        </li>
      <?php endif; ?>
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
      <a class="nav-link text-light" href="messages.php"><i class="fas fa-envelope"></i> Messages </a>
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
<div class="container cont-message mt-5">
  <h2>User Page - Messages from Admin</h2>
  <div class="row" id="message-container"></div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  var messageContainer = $('#message-container');

  // Fetch messages from the server
  $.ajax({
    url: '../configurations/get_user_messages.php',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      if (data.length === 0) {
        messageContainer.append('<p>No messages from admin.</p>');
      } else {
        data.forEach(function(message) {
          var messageCard = $('<div class="col-md-6 message-card"></div>');
          var cardHeader = $('<div class="card-header"></div>').text('Subject: ' + message.subject);
          var cardBody = $('<div class="card-body"></div>').text('Message: ' + message.message);
          messageCard.append(cardHeader, cardBody);

          // Check if the message has a response
          if (message.response) {
            var responseCard = $('<div class="card response-card"></div>');
            var responseHeader = $('<div class="card-header"></div>').text('Response from Admin');
            var responseBody = $('<div class="card-body"></div>').text(message.response);
            responseCard.append(responseHeader, responseBody);
            messageCard.append(responseCard);
          }

          messageContainer.append(messageCard);
        });
      }
    }
  });
});
</script>

</body>
</html>