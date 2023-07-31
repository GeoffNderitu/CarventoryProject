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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVentory - Car Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin_link {
            display: none;
        }

        .user-info {
            color: #fff;
            margin-right: 15px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .user-info i {
            margin-left: 5px;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <!-- Navigation bar -->
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
            <ul class="navbar-nav navbar-dark bg-dark me-auto mb-2 mb-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="../index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
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
                                echo "<li><a class='dropdown-item' href='browse_cars.php?brand=" . urlencode($row['brand']) . "'>" . $row['brand'] . "</a></li>";
                            }
                        } else {
                            echo "<li><a class='dropdown-item' href='#'>No brands available</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <?php if (isset($_SESSION['username'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../usermanager/logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a href="../userpage.php" class="nav-link">My Account</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../usermanager/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../usermanager/register.php">Register</a>
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
                            <a class="nav-link" href="../admin/admin_dash.php">Admin Dashboard</a>
                        </li>
                    ';
                }
            } else {
                // Error handling if the query fails or no user found
                echo 'Error retrieving user role.';
            }
            
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
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-12 mt-4">
                <h1>Car Details</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php
                // Check if the car ID is provided
                if (isset($_GET['id'])) {
                    $carId = $_GET['id'];
                    // Retrieve the car details from the database
                    $query = "SELECT * FROM cars WHERE id = ?";
                    $stmt = $connection->prepare($query);
                    $stmt->bind_param("i", $carId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result && $result->num_rows > 0) {
                        $car = $result->fetch_assoc();
                        $brand = $car['brand'];
                        $make = $car['make'];
                        $model = $car['model'];
                        $image = $car['image'];
                        $image2 = $car['image2'];
                        $image3 = $car['image3'];
                        $image4 = $car['image4'];
                        $specs = $car['specs'];

                        // Display the car details
                        echo "
                            <div class='card'>
                                <div class='card-header'>
                                    <h3>$brand $make $model</h3>
                                </div>
                                <div class='card-body'>
                                    <div class='row'>
                                        <div class='col-md-6'>
                                            <img src='../resources/images/$image' class='img-fluid' alt='Car Image'>
                                        </div>
                                        <div class='col-md-6'>
                                            <h5>Specifications</h5>
                                            <p>$specs</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ";

                        // Display the carousel with additional images
                        echo "
                            <div id='carouselExampleIndicators' class='carousel slide mt-4' data-bs-ride='carousel'>
                                <div class='carousel-indicators'>
                                    <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='0' class='active'></button>
                                    <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='1'></button>
                                    <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='2'></button>
                                </div>
                                <div class='carousel-inner'>
                                    <div class='carousel-item active'>
                                        <img src='../resources/images/$image2' class='d-block w-100' alt='Car Image 2'>
                                    </div>
                                    <div class='carousel-item'>
                                        <img src='../resources/images/$image3' class='d-block w-100' alt='Car Image 3'>
                                    </div>
                                    <div class='carousel-item'>
                                        <img src='../resources/images/$image4' class='d-block w-100' alt='Car Image 4'>
                                    </div>
                                </div>
                                <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide='prev'>
                                    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                                    <span class='visually-hidden'>Previous</span>
                                </button>
                                <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide='next'>
                                    <span class='carousel-control-next-icon' aria-hidden='true'></span>
                                    <span class='visually-hidden'>Next</span>
                                </button>
                            </div>
                        ";

                        // Display the video section
                        echo "
                        <div class='video-container mt-5'>
                        <div class='embed-responsive embed-responsive-16by9'>
                            <video autoplay muted loop class='embed-responsive-item'>
                                <source src='../resources/images/Mk4SupraNight.mp4' type='video/mp4'>
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div> ";
                    } else {
                        echo "No car found with the provided ID.";
                    }
                } else {
                    echo "Car ID is not provided.";
                }
                ?>
            </div>
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
</body>

</html>
