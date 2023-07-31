<?php
require_once '../configurations/config.php';
require_once '../configurations/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];

    // Perform form validation
    $errors = [];

    if (!isValidUsername($username)) {
        $errors['username'] = 'Invalid username format. Only alphanumeric characters and underscores are allowed.';
    }

    if (!isValidEmail($email)) {
        $errors['email'] = 'Invalid email address.';
    }

    if (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long.';
    }

    // If there are no validation errors, proceed with user registration
    if (empty($errors)) {
        // Check if username or email already exists
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $username, 'email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            if ($user['username'] === $username) {
                $errors['username'] = 'Username already exists.';
            } elseif ($user['email'] === $email) {
                $errors['email'] = 'Email address already exists.';
            }
        }

        // If no user with the given username or email exists, insert the new user into the database
        if (empty($errors)) {
            $hashedPassword = generateHash($password);
            $stmt = $db->prepare("INSERT INTO users (username, email, password, created_at) VALUES (:username, :email, :password, NOW())");
            $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashedPassword]);

            // Redirect to the login page
            redirectTo('login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New User - <?php echo $site_name; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>


<!-- Navigation Bar -->
<nav class="navbar navbar-expand navbar-dark bg-dark">
  <a class="navbar-brand" href="#"><i class="fas fa-cogs"></i> Admin Panel</a>
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
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6">
                <div class="card bg-dark text-white"> 
                <div class="card-body">
            <h2 class="card-title text-center mb-4">Add New User</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control form-control-rounded border-0" id="username" name="username" required>
                <?php if (isset($errors['username'])) echo '<small class="text-danger">' . $errors['username'] . '</small>'; ?>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control form-control-rounded border-0" id="email" name="email" required>
                <?php if (isset($errors['email'])) echo '<small class="text-danger">' . $errors['email'] . '</small>'; ?>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control form-control-rounded border-0" id="password" name="password" required>
                <?php if (isset($errors['password'])) echo '<small class="text-danger">' . $errors['password'] . '</small>'; ?>
            </div>
            <button type="submit" class="btn  btn-primary btn-rounded btn-block">Register</button>
        </form>

            </div>
                </div>
            </div>
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
