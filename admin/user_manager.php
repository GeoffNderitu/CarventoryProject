<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand navbar-dark bg-dark">
  <a class="navbar-brand" href="admin_dash.php"><i class="fas fa-cogs"></i> Admin Panel</a>
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
            <a class="nav-link text-light" href="#">
              <i class="fas fa-user-cog"></i> Update Admin Information
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="container col-md-10">
        <h1>User Management</h1>

        <?php
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

        // Retrieve the user information
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($user = $result->fetch_assoc()) {
                ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $user['username']; ?></h5>
                        <p class="card-text">Email: <?php echo $user['email']; ?></p>
                        <p class="card-text">Role: <?php echo $user['role']; ?></p>
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger">Delete</a>
                        <a href="assign_permissions.php?id=<?php echo $user['id']; ?>" class="btn btn-primary">Assign Permissions</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "No users found.";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
   
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script>
  function toggleSidebar() {
    $(".sidebar").toggleClass("active");
  }
</script>
</body>
</html>
