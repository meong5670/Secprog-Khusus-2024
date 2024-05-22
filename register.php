<?php
session_start();
require 'config.php'; // Include the database connection

$errors = []; // Initialize an array to store errors

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username)) {
        $errors[] = "Username is required!";
    }

    if (empty($password)) {
        $errors[] = "Password is required!";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match!";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Username is already taken!";
        } else {
            $stmt->close();

            // Insert new user into the database
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $errors[] = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if (!empty($errors)) : ?>
            <div class="error-container">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="register.php">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required><br>
            <button type="submit">Register</button>
            <a href="login.php">< Back</a>
        </form>
    </div>
</body>
</html>
