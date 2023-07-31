<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// Check if the user is logged in
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
} else {
  // Redirect the user to the login page if not logged in
  header("Location: usermanager/login.php");
  exit();
}
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Get the form data
    $carId = $_POST['car_id'];
    $problemDescription = $_POST['description'];

    // Replace database connection details with your own
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "CarNation";

    // Create connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
   
   
    // Check if the user has a car in the user_cars table
    $carQuery = "SELECT id FROM user_cars WHERE user_id = '$userId' AND id = '$carId'";
    $carResult = $conn->query($carQuery);
    
    if ($carResult->num_rows > 0) {
        // Prepare the SQL statement
        $sql = "INSERT INTO car_problems (user_id, car_id, description) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the parameters
            $stmt->bind_param("sss", $userId, $carId, $problemDescription);

            // Execute the statement
            if ($stmt->execute()) {
              $successMessage = "Problem description added successfully";

            echo '<div class="alert alert-success" role="alert">' . $successMessage . '</div>';
                    

            } else {
                echo "Error adding problem description: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "You do not have a car with the specified ID.";
    }
    
    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Car Problem Description</title>
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
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                   aria-expanded="false">
                    Browse Cars
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    // Replace database connection details with your own
                    $servername = "localhost";
                    $dbUsername = "root";
                    $dbPassword = "";
                    $dbname = "CarNation";

                    // Create connection
                    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch the brand names from the database
                    $query = "SELECT DISTINCT brand FROM cars";
                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $brand = $row['brand'];
                            echo "<li><a class='dropdown-item' href='admin/browse_cars.php?brand=" . urlencode($row['brand']) . "'>" . $row['brand'] . "</a></li>";
                        }
                    } else {
                        echo "<li><a class='dropdown-item' href='#'>No brands available</a></li>";
                    }

                    // Close the database connection
                    $conn->close();
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
        if (isset($_SESSION['username'])) {
            $userId = $_SESSION['user_id'];
            // Replace database connection details with your own
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "CarNation";

            // Create connection
            $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("SELECT role_id FROM users WHERE id = ?");
            $stmt->bind_param("i", $userId);

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
            $conn->close();
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

<!-- Sidebar menu -->
<div class="sidebar position-fixed  bg-dark">
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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Add Car Problem Description</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="manage_car_problems.php">
                        <div class="form-group">
                            <label for="car_id">Car:</label>
                            <select class="form-control" name="car_id" required>
                                <?php
                                // Replace database connection details with your own
                                $servername = "localhost";
                                $dbUsername = "root";
                                $dbPassword = "";
                                $dbname = "CarNation";

                                // Create connection
                                $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Fetch cars from the database
                                $carQuery = "SELECT id, make, model FROM user_cars WHERE user_id = '$userId'";
                                $carResult = $conn->query($carQuery);

                                if ($carResult->num_rows > 0) {
                                    while ($carRow = $carResult->fetch_assoc()) {
                                        $carId = $carRow['id'];
                                        $make = $carRow['make'];
                                        $model = $carRow['model'];
                                        echo "<option value='$carId'>$make $model</option>";
                                    }
                                } else {
                                    echo "<option value=''>No cars available</option>";
                                }

                                // Close the database connection
                                $conn->close();
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Problem Description:</label>
                            <textarea class="form-control" name="description" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <footer class="footer w-100">
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
  </footer> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
