<!DOCTYPE html>
<html>
<head>
  <title>Add Car Form</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
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
                  <a class="nav-link text-light" href="#"><i class="fas fa-eye"></i> View Users</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light" href="#"><i class="fas fa-plus"></i> Add User</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
          <a class="nav-link text-light" href="manage_cars.php" data-toggle="collapse" data-target="#manageCarsMenu">
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
    <h1>Add Car</h1>
    <form action="car_process.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="brand">Brand:</label>
        <input type="text" class="form-control" id="brand" name="brand" required>
      </div>
      <div class="form-group">
        <label for="make">Make:</label>
        <input type="text" class="form-control" id="make" name="make" required>
      </div>
      <div class="form-group">
        <label for="model">Model:</label>
        <input type="text" class="form-control" id="model" name="model" required>
      </div>
      <div class="form-group">
        <label for="image">Image 1:</label>
        <input type="file" class="form-control" id="image" name="image" required>
      </div>
      <div class="form-group">
        <label for="image2">Image 2:</label>
        <input type="file" class="form-control" id="image2" name="image2" required>
      </div>
      <div class="form-group">
        <label for="image3">Image 3:</label>
        <input type="file" class="form-control" id="image3" name="image3" required>
      </div>
      <div class="form-group">
        <label for="image4">Image 4:</label>
        <input type="file" class="form-control" id="image4" name="image4" required>
      </div>
      <div class="form-group">
        <label for="specs">Specifications:</label>
        <textarea class="form-control" id="specs" name="specs" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Car</button>
    </form>
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
