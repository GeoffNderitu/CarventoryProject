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

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Car</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../style.css">
  <style>
    body {
      margin: 0;
      padding: 0;
    }
    .navbar {
      background-color: #333;
      color: #fff;
      padding: 10px;
    }
    .navbar-brand {
      color: #fff;
      font-size: 24px;
    }
    .navbar-brand img {
      height: 30px;
      margin-right: 10px;
    }
    .navbar-nav .nav-item .nav-link {
      color: #fff;
    }
    .sidebar {
      background-color: #333;
      color: #fff;
      width: 200px;
      position: fixed;
      top: 60px;
      left: 0px;
      height: 100vh;
      transition: all 0.3s ease;
    }
    .sidebar.show {
      left: 0;
    }
    .sidebar ul.nav.flex-column {
      padding: 0;
      margin: 20px 0;
    }
    .sidebar ul.nav.flex-column li.nav-item {
      list-style-type: none;
      margin-bottom: 10px;
    }
    .sidebar ul.nav.flex-column li.nav-item a.nav-link {
      color: #fff;
    }
    .content {
      margin-left: 200px;
      padding: 20px;
    }
    .container {
      margin-top: 50px;
    }
    .bebauser {
      background-color: #f9f9f9;
      padding: 20px;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="#">
    <img src="../resources/images/CarVentory_logo.png" alt="CarVentory Logo">
    CarVentory
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../index.php">Home</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          Browse Cars
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php
          // Fetch the brand names from the database
          $query = "SELECT DISTINCT brand FROM cars";
          $result = mysqli_query($connection, $query);
          if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $brand = $row['brand'];
              echo "<li><a class='dropdown-item' href='#'>$brand</a></li>";
            }
          } else {
            echo "<li><a class='dropdown-item' href='#'>No brands available</a></li>";
          }
          ?>
        </ul>
      </li>
      <?php if (isset($_SESSION['username'])) : ?>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      <?php else : ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
      <?php endif; ?>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact Us</a>
      </li>
    </ul>
    <?php if (isset($_SESSION['username'])) : ?>
      <div class="navbar-nav me-2">
        <div class="user-info">
          <span>Welcome, <?php echo htmlspecialchars($username); ?></span>
          <i class="fas fa-user-circle"></i>
        </div>
      </div>
    <?php endif; ?>
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

<!-- Content section -->
<div class="content">
    <div class="container">
        <h2>Update Car</h2>
        <form method="POST" action="update_car.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="brand">Brand:</label>
                <input type="text" class="form-control" id="brand" name="brand" required>
            </div>
            <div class="form-group">
                <label for="make">Make:</label>
                <input type="text" class="form-control" id="make" name="make" required>
            </div>
            <div class="form-group">
                <label for="model">Model:</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="form-group">
                <label for="specs">Specifications:</label>
                <textarea class="form-control" id="specs" name="specs" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Car</button>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
