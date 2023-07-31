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
    <title>Register - <?php echo $site_name; ?></title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6">
                <div class="card bg-dark text-white"> 
                <div class="card-body">
            <h2 class="card-title text-center mb-4">Register</h2>
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
</body>
</html>
