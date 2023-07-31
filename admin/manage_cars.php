<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Car Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .card-img {
            width: 200px;
            height: auto;
            object-fit: cover;
        }

        .specs.collapsed {
            max-height: 60px;
            overflow: hidden;
        }

        .specs-toggle {
            cursor: pointer;
            color: blue;
        }
        .car-details-container {
            margin-left: 220px; 
      }
    </style>
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
                                    <a class="nav-link text-light" href="#"><i class="fas fa-eye"></i> View Cars</a>
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
            <h1>Car Details</h1>

            <div class="row">
                <?php
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

                $query = "SELECT * FROM cars";

                // Execute the query
                $result = mysqli_query($conn, $query);

                // Check if any cars were found
                if (mysqli_num_rows($result) > 0) {
                    // Fetch and display each car
                    while ($row = mysqli_fetch_assoc($result)) {
                        $carId = $row['id'];
                        $brand = $row['brand'];
                        $make = $row['make'];
                        $model = $row['model'];
                        $image = $row['image'];
                        $specs = $row['specs'];
                        ?>
<div class="col-md-7 mb-4">
    <div class="card">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="../resources/images/<?php echo $image; ?>" alt="Car Image" class="card-img img-fluid">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Car ID: <?php echo $carId; ?></h5>
                    <p class="card-text">Brand: <?php echo $brand; ?></p>
                    <p class="card-text">Make: <?php echo $make; ?></p>
                    <p class="card-text">Model: <?php echo $model; ?></p>
                    <p class="card-text specs collapsed"><?php echo $specs; ?></p>
                    <?php if (strlen($specs) > 60) { ?>
                        <p class="specs-toggle">Show More</p>
                    <?php } ?>
                    <div class="mt-4">
                        <a href="edit_car.php?id=<?php echo $carId; ?>" class="btn btn-primary">Edit</a>
                        <a href="delete_car.php?id=<?php echo $carId; ?>" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                        <?php
                    }
                } else {
                    echo '<div class="alert alert-info" role="alert">';
                    echo 'No cars found.';
                    echo '</div>';
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script>
    $(document).ready(function () {
        $(".specs-toggle").click(function () {
            var specsElement = $(this).siblings('.specs');
            if (specsElement.hasClass('collapsed')) {
                specsElement.removeClass('collapsed');
                $(this).text('Show Less');
            } else {
                specsElement.addClass('collapsed');
                $(this).text('Show More');
            }
        });
    });
</script>
</body>
</html>
