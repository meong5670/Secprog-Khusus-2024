<?php
session_start();

// Regenerate session ID to prevent session fixation
if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time();
} elseif (time() - $_SESSION['created'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['created'] = time();
}

if (!isset($_SESSION['login_time'])) {
    $_SESSION['login_time'] = time();
}

if (time() - $_SESSION['login_time'] > 60 * 60) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// update session time
$_SESSION['login_time'] = time();

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Throttling to prevent brute force attacks
    $stmt = $conn->prepare("SELECT attempt_time FROM login_attempts WHERE username = ? AND attempt_time > (NOW() - INTERVAL 2 MINUTE)");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows >= 3) {
        echo "Too many login attempts. Please try again after 2 minutes.";
        exit;
    }

    $stmt->close();

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $role);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            header("Location: index.php");
            exit;
        } else {
            record_failed_attempt($conn, $username);
            echo "<script>alert('Invalid username or password.');</script>";
        }
    } else {
        record_failed_attempt($conn, $username);
        echo "<script>alert('Invalid username or password.');</script>";
    }

    $stmt->close();
}

function record_failed_attempt($conn, $username) {
    $stmt = $conn->prepare("INSERT INTO login_attempts (username, attempt_time) VALUES (?, NOW())");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="login.php">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Login</button>
            <a href="register.php">Sign up!</a>
        </form>
    </div>
</body>
</html>
