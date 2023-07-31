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
  header("Location: ../usermanager/login.php");
  exit();
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>Car Search</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../style.css">
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
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Browse Cars
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <?php
       // Fetch the brand names from the cars table
$query1 = "SELECT DISTINCT brand FROM cars";
$result1 = mysqli_query($connection, $query1);

// Fetch the brand names from the user_cars table
$query2 = "SELECT DISTINCT brand FROM user_cars";
$result2 = mysqli_query($connection, $query2);

// Process the results of the first query
if ($result1 && mysqli_num_rows($result1) > 0) {
    while ($row = mysqli_fetch_assoc($result1)) {
        $brand = $row['brand'];
        echo "<li><a class='dropdown-item' href='#'>$brand</a></li>";
    }
} else {
    echo "<li><a class='dropdown-item' href='#'>No brands available</a></li>";
}

// Process the results of the second query
if ($result2 && mysqli_num_rows($result2) > 0) {
    while ($row = mysqli_fetch_assoc($result2)) {
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
            <a class="nav-link" href="../usermanager/logout.php">Logout</a>
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
<?php

if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    
    // Set the number of results per page
    $resultsPerPage = 10;
    
    // Get the current page number
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
      $currentPage = (int)$_GET['page'];
    } else {
      $currentPage = 1;
    }
    
    // Calculate the offset for the SQL query
    $offset = ($currentPage - 1) * $resultsPerPage;
    
    // Prepare your SQL query based on the search query and pagination
    $sql = "SELECT * FROM cars WHERE make LIKE '%$searchQuery%' OR model LIKE '%$searchQuery%' OR specs LIKE '%$searchQuery%' OR image LIKE '$searchQuery' LIMIT $offset, $resultsPerPage";
    $sql_other =  "SELECT * FROM user_cars WHERE make LIKE '%$searchQuery%' OR model LIKE '%$searchQuery%' OR specs LIKE '%$searchQuery%' OR image LIKE '$searchQuery' LIMIT $offset, $resultsPerPage";
    
    // Execute the query and fetch the results
    $result = mysqli_query($connection, $sql);
    $result_other = mysqli_query($connection, $sql_other);
    
    // Process and display the search results
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $brand = $row['brand'];
        $make = $row['make'];
        $model = $row['model'];
        $image = $row['image'];
        $specs = $row['specs'];

        echo "<div class='card mb-3'>";
        echo "<div class='row g-0'>";
        echo "<div class='col-md-4'>";
        echo "<img src='../resources/images/$image' alt='Car Image' class='img-fluid'>";
        echo "</div>";
        echo "<div class='col-md-8'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>$brand $make $model</h5>";
        echo "<p class='text-center'>$specs</p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
      }
    } else {
      echo '<p>No results found.</p>';
    }
    
    // Calculate the total number of pages
    $totalResults = mysqli_num_rows($result);
    $totalPages = ceil($totalResults / $resultsPerPage);
    
    // Display pagination links
    echo '<div class="pagination">';
    if ($currentPage > 1) {
      echo '<a href="search.php?query=' . urlencode($searchQuery) . '&page=' . ($currentPage - 1) . '">Previous</a>';
    }
    
    for ($i = 1; $i <= $totalPages; $i++) {
      if ($i === $currentPage) {
        echo '<span class="current-page">' . $i . '</span>';
      } else {
        echo '<a href="search.php?query=' . urlencode($searchQuery) . '&page=' . $i . '">' . $i . '</a>';
      }
    }
    
    if ($currentPage < $totalPages) {
      echo '<a href="search.php?query=' . urlencode($searchQuery) . '&page=' . ($currentPage + 1) . '">Next</a>';
    }
    
    echo '</div>';
    
  } else {
    echo '<p>No results found.</p>';
  }
    
    // Close the database connection
    mysqli_close($connection);
?>

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
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.min.js"></script>

</script>
</body>
</html>
