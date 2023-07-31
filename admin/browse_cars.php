<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();

$host = 'localhost';
$dbName = 'CarNation';
$username = 'root';
$password = '';

try {
  // Establish the database connection
  $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

  // Set PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}

// Retrieve the username from the session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Fetch car brands from the database
$query = "SELECT DISTINCT brand FROM cars";
$statement = $pdo->prepare($query);
$statement->execute();
$carBrands = $statement->fetchAll(PDO::FETCH_COLUMN);

// Get the brand from the query parameter
$brand = isset($_GET['brand']) ? htmlspecialchars($_GET['brand']) : '';


// Fetch cars with the given brand from the database
$query = "SELECT * FROM cars WHERE brand = :brand";
$statement = $pdo->prepare($query);
$statement->bindParam(':brand', $brand);
$statement->execute();
$cars = $statement->fetchAll(PDO::FETCH_ASSOC);

$itemsPerPage = 10;
$totalItems = count($cars);
$totalPages = ceil($totalItems / $itemsPerPage);

$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$startIndex = ($currentPage - 1) * $itemsPerPage;
$endIndex = $startIndex + $itemsPerPage;

?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $brand; ?> Cars</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../style.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Navigation bar -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="../resources/images/CarVentory_logo.png" alt="CarVentory Logo">
      CarVentory
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link text-light" href="../index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link text-light dropdown-toggle" href="#" id="navbarDropdown" role="button"
             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Browse Cars
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php
            $query = "SELECT DISTINCT brand FROM cars";
            $statement = $pdo->prepare($query);
            $statement->execute();
            $brands = $statement->fetchAll(PDO::FETCH_COLUMN);            
            if ($statement->rowCount() > 0) {
                while ($brand = $statement->fetch(PDO::FETCH_ASSOC)) {
                  echo "<li><a class='dropdown-item' href='admin/browse_cars.php?brand=" . urlencode($brand['brand']) . "'>" . $brand['brand'] . "</a></li>";
                }
              } else {
                echo "<li><a class='dropdown-item' href='#'>No brands available</a></li>";
              }
              
            ?>
          </ul>
        </li>
        <?php if (isset($_SESSION['username'])) : ?>
          <li class="nav-item">
            <a class="nav-link text-light" href="usermanager/logout.php">Logout</a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link text-light" href="usermanager/login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="usermanager/register.php">Register</a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link text-light" href="#">Contact Us</a>
        </li>
      </ul>
      <?php if (isset($_SESSION['username'])) : ?>
        <div class="user-info">
          <span class="nav-link text-light">Welcome, <?php echo htmlspecialchars($username); ?><i class="fas fa-user-circle "></i></span>
        </div>
      <?php endif; ?>
    </div>
  </div>
</nav>


<div class="container">
  <h1><?php echo $brand; ?> Cars</h1>
  <div class="row">
    <?php for ($i = $startIndex; $i < $endIndex && $i < $totalItems; $i++) {
      $car = $cars[$i];
      $specs = $car['specs'];
      $maxChars = 100; // Maximum number of characters to display

      if (strlen($specs) > $maxChars) {
        $specs = substr($specs, 0, $maxChars) . '...';
      }
    ?>
      <div class="col-md-6">
        <div class="card mb-3">
          <div class="row no-gutters">
            <div class="col-md-4">
              <img src="../resources/images/<?php echo $car['image2']; ?>" class="card-img h-100" alt="Car Image">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?php echo $car['make']; ?> <?php echo $car['model']; ?></h5>
                <p class="card-text">Brand: <?php echo $car['brand']; ?></p>
                <p class="card-text">Specs: <?php echo $specs; ?></p>
                <a href="car_details.php?id=<?php echo $car['id']; ?>" class="btn btn-primary">View Details</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

  <nav aria-label="Page navigation">
    <!-- Pagination code here -->
  </nav>
</div>




  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
      <?php if ($currentPage > 1) { ?>
        <li class="page-item">
          <a class="page-link" href="page.php?brand=<?php echo urlencode($brand); ?>&page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
      <?php } ?>
      
      <?php for ($page = 1; $page <= $totalPages; $page++) { ?>
        <li class="page-item <?php echo $page == $currentPage ? 'active' : ''; ?>">
          <a class="page-link" href="browse_cars.php?brand=<?php echo urlencode($brand); ?>&page=<?php echo $page; ?>"><?php echo $page; ?></a>
        </li>
      <?php } ?>

      <?php if ($currentPage < $totalPages) { ?>
        <li class="page-item">
          <a class="page-link" href="browse_cars.php?brand=<?php echo urlencode($brand); ?>&page=<?php echo $currentPage + 1; ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
      <?php } ?>
    </ul>
  </nav>
</div>
</div>

<script>
  $(document).ready(function() {
    $('.card-text').on('click', function() {
      $(this).toggleClass('expanded');
    });
  });
</script>
<script>
  var tabTriggerElList = [].slice.call(document.querySelectorAll('#gt-r-tabs button'))
  tabTriggerElList.forEach(function (tabTriggerEl) {
    new bootstrap.Tab(tabTriggerEl)
  })
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
  <script src="script.js"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.min.js"></script>

</body>
</html>
