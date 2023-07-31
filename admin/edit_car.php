<!DOCTYPE html>
<html>
<head>
    <title>Edit Car</title>
    
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

            <div class="col-md-10 ml-sm-auto px-4">
                <div class="container">
                    <h1>Edit Car</h1>

                    <?php
                    // Retrieve the car information from the database and pre-fill the form
                    // Replace database connection details with your own
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

                    // Retrieve the car information by ID
                    $carId = $_GET['id']; // Assuming the car ID is passed via URL parameter

                    $sql = "SELECT * FROM cars WHERE id = $carId";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $car = $result->fetch_assoc();
                    } else {
                        echo "Car not found.";
                        exit;
                    }
                    ?>

                    <form action="update_car_process.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">

                        <div class="form-group">
                            <label for="brand">Brand:</label>
                            <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $car['brand']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="make">Make:</label>
                            <input type="text" class="form-control" id="make" name="make" value="<?php echo $car['make']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="model">Model:</label>
                            <input type="text" class="form-control" id="model" name="model" value="<?php echo $car['model']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="image">Image 1:</label>
                            <input type="file" class="form-control" id="image" name="image" value="<?php echo $car['image']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="image2">Image 2:</label>
                            <input type="file" class="form-control" id="image2" name="image2" value="<?php echo $car['image2']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="image3">Image 3:</label>
                            <input type="file" class="form-control" id="image3" name="image3" value="<?php echo $car['image3']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="image4">Image 4:</label>
                            <input type="file" class="form-control" id="image4" name="image4" value="<?php echo $car['image4']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="specs">Specs:</label>
                            <textarea class="form-control" id="specs" name="specs"><?php echo $car['specs']; ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Car</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
