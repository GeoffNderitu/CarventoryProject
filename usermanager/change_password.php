<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

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

    // Check if the current password matches the one in the database
    $sql = "SELECT password FROM users WHERE id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        if (password_verify($currentPassword, $storedPassword)) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $sql = "UPDATE users SET password='$hashedPassword' WHERE id = '$user_id'";

            if ($conn->query($sql) === TRUE) {
                echo "Password changed successfully.";
            } else {
                echo "Error changing password: " . $conn->error;
            }
        } else {
            echo "Current password is incorrect.";
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<!-- Navigation bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="../index.php">Home</a>

  <div class="ml-auto d-flex align-items-center">
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <button class="navbar-toggler ml-3" type="button" id="sidebarToggle">
      <i class="fas fa-cog"></i>
    </button>
  </div>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">

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
    <div class="container bebauser">
        <h1 class="mt-4">Change Password</h1>
        <form method="POST" action="change_password.php">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" class="form-control" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" name="confirm_password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-dark">Submit</button>
            </div>
        </form>
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
