<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
  
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

    // Update the user information in the database
    $sql = "UPDATE users SET name='$name', email='$email' WHERE id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Information updated successfully.";
    } else {
        echo "Error updating information: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Information</title>
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
  <a class="navbar-brand" href="homepage.php">Home</a>

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
        <h1 class="mt-4">Update Information</h1>
        <form method="POST" action="update_info.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    
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
