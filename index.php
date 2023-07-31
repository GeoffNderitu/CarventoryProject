<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);



session_start();

// require_once('usermanager/config.php');

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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CarVentory - Homepage</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="style.css">
</head>

<body>
 
<!-- Navigation bar -->
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


 
  <!-- Content area -->

<div class="container-fluid">

<!-- Video Container -->
<div class="video-container mt-3">
  <video src="resources/images/subbiefront.mp4" autoplay muted loop></video>
  <div class="video-overlay">
    <h2>Welcome to CarVentory</h2>
    <p>Explore our collection of cars and find your perfect ride.</p>
    <a href="#" class="btn btn-dark">Get Started</a>
  </div>
</div>

  <div class="row mt-3">
        <div class="col-md-9"> 
             <!-- Carousel -->
        <div id="carouselExample" class="carousel slide" data-ride="carousel">
          <!-- Carousel Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#carouselExample" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExample" data-slide-to="1"></li>
            <li data-target="#carouselExample" data-slide-to="2"></li>
            <li data-target="#carouselExample" data-slide-to="3"></li>
            <li data-target="#carouselExample" data-slide-to="4"></li>
          </ol>

          <!-- Carousel Slides -->
        <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="resources/images/05Sti_grey.jpeg" class="d-block w-100" alt="Car 1">
              <div class="carousel-caption">
                <h5>Car 1</h5>
                <p>Description of Car 1</p>
                <a href="#" class="btn btn-dark">Button 1</a>
              </div>
            </div>
            <div class="carousel-item">
              <img src="resources/images/22b and Maki.webp" class="d-block w-100" alt="Car 2">
              <div class="carousel-caption">
                <h5>Car 2</h5>
                <p>Description of Car 2</p>
                <a href="#" class="btn btn-dark">Button 2</a>
              </div>
            </div>
            <div class="carousel-item">
              <img src="resources/images/evo1.jpeg" class="d-block w-100" alt="Car 3">
              <div class="carousel-caption">
                <h5>Car 3</h5>
                <p>Description of Car 3</p>
                <a href="#" class="btn btn-dark">Button 3</a>
              </div>
            </div>
            <div class="carousel-item">
              <img src="resources/images/05sti_white.webp" class="d-block w-100" alt="Car 4">
              <div class="carousel-caption">
                <h5>Car 4</h5>
                <p>Description of Car 4</p>
                <a href="#" class="btn btn-dark">Button 4</a>
              </div>
            </div>
            <div class="carousel-item">
              <img src="resources/images/evo_white.jpeg" class="d-block w-100" alt="Car 5">
              <div class="carousel-caption">
                <h5>Car 5</h5>
                <p>Description of Car 5</p>
                <a href="#" class="btn btn-dark">Button 5</a>
              </div>
            </div>
          </div>

          <!-- Carousel Controls -->
          <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
      </div>

      <form class="search-form mt-4" action="configurations/search.php" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="query" placeholder="Search for cars...">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" type="submit">
                                             <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                            </div>
                    </form>

                    <section class="mt-5 mb-5">
                        <div class="card shadow mt-4">
                            <div class="card-body">
                                <h2 class="text-center">Welcome to CarVentory</h2>
                                <p class="text-center">Find your perfect car from our wide selection.</p>


                                    <div class="icon-container text-center">
                                        <span>
                                         <i class="fas fa-car fa-3x mt-3"></i>
                                            <p>Explore</p>
                                        </span>
                                        <span>
                                            <i class="fas fa-gas-pump fa-3x mt-3"></i>
                                            <p>Fuel Efficiency</p>
                                        </span>
                                        <span>
                                             <i class="fas fa-road fa-3x mt-3"></i>
                                             <p>Smooth Rides</p>
                                        </span>
                                        <span>
                                            <i class="fas fa-wrench fa-3x mt-3"></i>
                                            <p>Maintenance</p>
                                        </span>
                                        <span>
                                            <i class="fas fa-dollar-sign fa-3x mt-3"></i>
                                            <p>Affordable</p>
                                        </span>
                                        <span>
                                            <i class="fas fa-calendar-alt fa-3x mt-3"></i>
                                            <p>Schedule</p>
                                        </span>
                                    </div>

                            </div>
                        </div>
                    </section>

                    <section class="content-banner-area mt-3">
                        <div class="container">
                             <div class="row">
                                    <div class="col-md-6">
                                        <div class="content-left">
                                             <h2>Placeholder Text</h2>
                                             <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pretium ligula sit amet tortor placerat, id semper nulla auctor.</p>
                                            <button class="btn btn-primary">Explore More</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="content-right">
                                        </div>
                                </div>
                             </div>
                        </div>
                    </section>

    </div>  
    <div class="col-md-3">

<div class="card mb-1">
    <img src="resources/images/22b and Maki.webp" class="card-img-top" alt="Image 1">
    <div class="card-body">
      <h5 class="card-title">Card 1</h5>
      <p class="card-text">Some text describing Card 1.</p>
      <a href="#" class="btn btn-dark">Button 1</a>
    </div>
  </div>
  <div class="card mb-1">
    <img src="resources/images/evo_white.jpeg" class="card-img-top" alt="Image 2">
    <div class="card-body">
      <h5 class="card-title">Card 2</h5>
      <p class="card-text">Some text describing Card 2.</p>
      <a href="#" class="btn btn-dark">Button 2</a>
    </div>
  </div>
  <div class="card mb-1">
    <img src="resources/images/evo1.jpeg" class="card-img-top" alt="Image 3">
    <div class="card-body">
      <h5 class="card-title">Card 3</h5>
      <p class="card-text">Some text describing Card 3.</p>
      <a href="#" class="btn btn-dark">Button 3</a>
    </div>
  </div>
 </div>      
    </div>
</div>
    </div>

    <footer class="footer">
    <div class="container-fluid">
      <div class="card footer-card">
        <div class="row">
          <div class="col-lg-6">
            <ul class="footer-links">
              <li><a href="index.php">Home</a></li>
              <li><a href="index.php">Browse Cars</a></li>
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
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.min.js"></script>

</script>
</body>

</html>
