<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "CarNation";


$connection = mysqli_connect($servername, $username, $password, $database);

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- <link rel="stylesheet" href="usermanager/style.css"> -->
  <link rel="stylesheet" href="style.css">
  <style>
    .navbar {
      position: relative;
      z-index: 1;
      height: 60px;
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
    <a class="navbar-brand" href="#">
      <img src="resources/images/CarVentory_logo.png" alt="CarVentory Logo">
      CarVentory
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav navbar-dark bg-dark me-auto mb-2 mb-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                echo "<li><a class='dropdown-item' href='admin/browse_cars.php?brand=" . urlencode($row['brand']) . "'>" . $row['brand'] . "</a></li>";
            }
        } else {
            echo "<li><a class='dropdown-item' href='#'>No brands available</a></li>";
        }
        ?>
    </ul>
</li>
        <?php if (isset($_SESSION['username'])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="usermanager/logout.php">Logout</a>
          </li>
          <li class="nav-item">
            <a href="userpage.php" class="nav-link">My Account</a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link" href="usermanager/login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="usermanager/register.php">Register</a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
      </ul>
      <?php

$stmt = $connection->prepare("SELECT role_id FROM users WHERE id = ?");
$stmt->bind_param("i", $userId); 
$userId = $_SESSION['user_id']; 

$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $roleId = $row['role_id'];

    if ($roleId == 1) {
        // User has admin role, display the admin dashboard link
        echo '
            <li class="nav-item admin_link">
                <a class="nav-link" href="admin/admin_dash.php">Admin Dashboard</a>
            </li>
        ';
    }
} else {
    // Error handling if the query fails or no user found
    echo 'Error retrieving user role.';
}

$stmt->close();
$connection->close();

?>

      <?php if (isset($_SESSION['username'])) : ?>
        <div class="navbar-nav me-2">
          <div class="user-info">
            <span>Welcome, <?php echo htmlspecialchars($username); ?></span>
            <i class="fas fa-user-circle"></i>
          </div>
        </div>
      <?php endif; ?>
    </div>
      </ul>
  </nav>

<!-- Sidebar menu -->
<div class="sidebar">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link text-light" href="usermanager/change_password.php"><i class="fas fa-key"></i> Change Password</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="usermanager/update_info.php"><i class="fas fa-user-edit"></i> Update Information</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="usermanager/contact_admin.php"><i class="fas fa-envelope"></i> Contact Administrator</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="usermanager/messages.php"><i class="fas fa-mail"></i> Messages </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="usermanager/add_car.php"><i class="fas fa-car"></i> Add Car</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="usermanager/update_car.php"><i class="fas fa-car"></i> Update Car Information</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="manage_car_problems.php"><i class="fas fa-exclamation-triangle"></i> Manage Car Problems</a>
    </li>
  </ul>
</div>

<!-- Content area -->
<div class="content">
  <?php foreach ($user_cars as $car): ?>
    <div class="car-container">
      <h3><?php echo $car['brand'] . ' ' . $car['make'] . ' ' . $car['model']; ?></h3>

      <!-- Fetch and display car images -->
      <?php foreach ($car['images'] as $image): ?>
        <img class="car-image" src="<?php echo $image['image_path']; ?>" alt="Car Image">
      <?php endforeach; ?>

      <!-- Fetch and display car problems -->
      <div class="problem-container">
        <h4>Car Problems</h4>
        <?php foreach ($car['problems'] as $problem): ?>
          <p><?php echo $problem['problem_description']; ?></p>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<footer class="footer w-100">
    <div class="container-fluid">
      <div class="card footer-card">
        <div class="row">
          <div class="col-lg-6">
            <ul class="footer-links">
              <li><a href="index.php">Home</a></li>
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
  $(document).ready(function () {
    // Toggle sidebar menu
    $('.navbar-toggler').click(function () {
      $('.sidebar').toggleClass('show');
    });
  });
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>
