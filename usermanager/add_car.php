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

// Check if the form is submitted
$user_id = $_SESSION['user_id'];   
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

    // Insert the data into the user_cars table
    $sql = "INSERT INTO user_cars (user_id, brand, make, model, image, specs)
    VALUES ('$user_id', '$brand', '$make', '$model', '$image', '$specs')";


} else {
   
}
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
    
    if ($conn->query($sql) === TRUE) {
       
    } else {
        echo "Error adding car: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Car</title>
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
  <a class="navbar-brand text-light" href="../index.php">
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

<div class="content">
  <div class="container bebauser">
    <h1 class="mt-4">Add Car</h1>
    <form method="POST" action="add_car.php" enctype="multipart/form-data">
      <div class="form-group">
        <label for="brand">Brand:</label>
        <input type="text" class="form-control" name="brand" required>
      </div>
      <div class="form-group">
        <label for="make">Make:</label>
        <input type="text" class="form-control" name="make" required>
      </div>
      <div class="form-group">
        <label for="model">Model:</label>
        <input type="text" class="form-control" name="model" required>
      </div>
      <div class="form-group">
        <label for="image">Image 1:</label>
        <input type="file" class="form-control-file" name="image" accept="image/*" required>
      </div>
      <div class="form-group">
        <label for="specs">Specifications:</label>
        <textarea class="form-control" name="specs" rows="5" required></textarea>
      </div>
      <button type="submit" class="btn btn-dark">Add Car</button>
    </form>
  </div>
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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
<script src="script.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.min.js"></script>
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
