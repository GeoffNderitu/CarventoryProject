<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../style.css">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand navbar-dark bg-dark">
  <a class="navbar-brand" href="#"><i class="fas fa-cogs"></i> Admin Panel</a>
  <ul class="navbar-nav navbar-dark bg-dark me-auto mb-1 mb-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="../index.php">Home</a>
        </li>
</ul>
</nav>

<!-- Sidebar Menu -->
<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-md-block bg-dark sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link text-light" href="#" data-toggle="collapse" data-target="#manageUsersMenu">
              <i class="fas fa-users"></i> Manage Users <i class="fas fa-caret-down float-right"></i>
            </a>
            <div class="collapse" id="manageUsersMenu">
              <ul class="nav flex-column pl-3">
                <li class="nav-item">
                  <a class="nav-link text-light" href="user_manager.php"><i class="fas fa-eye"></i> View Users</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light" href="user_create.php"><i class="fas fa-plus"></i> Add User</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="#" data-toggle="collapse" data-target="#manageCarsMenu">
              <i class="fas fa-car"></i> Manage Cars <i class="fas fa-caret-down float-right"></i>
            </a>
            <div class="collapse" id="manageCarsMenu">
              <ul class="nav flex-column pl-3">
                <li class="nav-item">
                  <a class="nav-link text-light" href="manage_cars.php"><i class="fas fa-eye"></i> View Cars</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light" href="add_car.php"><i class="fas fa-plus"></i> Add Car</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="message_users.php">
              <i class="fas fa-user-mail"></i> User Messages
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="#">
              <i class="fas fa-user-cog"></i> Update Admin Information
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Content Area -->
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <h1>Welcome to the Admin Panel</h1>
      <p>Choose an option from the sidebar menu to get started.</p>
    </main>
  </div>
</div>

    <!-- Content Area -->
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="row">
        <?php
        // Connect to the database
        $db_host = 'localhost';
        $db_user = 'root';
        $db_password = '';
        $db_name = 'CarNation';
        
        $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
        if (!$conn) {
          die('Database connection failed: ' . mysqli_connect_error());
        }
        
        // Query to retrieve data
        $query = "SELECT COUNT(*) as total_cars FROM cars";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $total_cars = $row['total_cars'];
        
        $query = "SELECT COUNT(*) as total_users FROM users";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $total_users = $row['total_users'];
        
        $query = "SELECT COUNT(*) as total_problems FROM car_problems";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $total_problems = $row['total_problems'];
        
        $query = "SELECT COUNT(*) as recent_cars FROM cars WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $recent_cars = $row['recent_cars'];
        
        $query = "SELECT COUNT(*) as recent_users FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $recent_users = $row['recent_users'];
        
        // Close the database connection
        mysqli_close($conn);
        ?>
        
        <div class="col-md-4 mb-4">
          <div class="card card-warning  text-white">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-car"></i> Total Cars</h5>
              <p class="card-text"><?php echo $total_cars; ?></p>
              <a href="manage_cars.php" class="btn btn-light"><i class="fas fa-arrow-right"></i> More Info</a>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card card-success text-white">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-users"></i> Total Users</h5>
              <p class="card-text"><?php echo $total_users; ?></p>
              <a href="user_manager.php" class="btn btn-light"><i class="fas fa-arrow-right"></i> More Info</a>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card card-danger text-white">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-exclamation-circle"></i> Total Problems</h5>
              <p class="card-text"><?php echo $total_problems; ?></p>
              <a href="#" class="btn btn-light"><i class="fas fa-arrow-right"></i> More Info</a>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="card card-primary text-white">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-car"></i> Recently Added Cars</h5>
              <p class="card-text"><?php echo $recent_cars; ?> cars added</p>
              <a href="manage_cars.php" class="btn btn-light"><i class="fas fa-arrow-right"></i> More Info</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="card card-info text-white">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-user-plus"></i> Recently Added Users</h5>
              <p class="card-text"><?php echo $recent_users; ?> users added</p>
              <a href="user_manager.php" class="btn btn-light"><i class="fas fa-arrow-right"></i> More Info</a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Include Font Awesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script>
  function toggleSidebar() {
    $(".sidebar").toggleClass("active");
  }
</script>
</body>
</html>
