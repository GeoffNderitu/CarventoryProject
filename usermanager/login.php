<?php
require_once '../configurations/config.php';
require_once '../configurations/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];

    // Perform form validation
    $errors = [];

    if (empty($username)) {
        $errors['username'] = 'Username is required.';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    // If there are no validation errors, proceed with user login
    if (empty($errors)) {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && verifyHash($password, $user['password'])) {
            // Start a session and set session variables
            startSession();
            setSession('user_id', $user['id']);
            setSession('username', $user['username']);

            
            // Assuming the username is stored in a variable $username
            header("Location: ../index.php?username=" . urlencode($username));
                exit();

        } else {
            $errors['login'] = 'Invalid username or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - <?php echo $site_name; ?></title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-6">
            <div class="card bg-dark text-white">
                <div class="card-body">
                <h2 class="card-title text-center mb-4">Login</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control form-control-rounded border-0" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control form-control-rounded border-0" id="password" name="password" required>
            </div>
            <h6 class="text-light">Do not have an account?<a href="register.php"> Register Here</a></h6>
            <?php if (isset($errors['login'])) echo '<small class="text-danger">' . $errors['login'] . '</small>'; ?>
            <button type="submit" class="btn  btn-primary btn-rounded btn-block">Login</button>
        </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</body>
</html>
