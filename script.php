<?php
session_start();


$servername = "localhost";
$username = "admin";
$password = "1234";
$dbname = "calendar";

//connectsions
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, role FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $stmt->bind_result($id, $username, $role);

    // TEMP
    if ($stmt->fetch()) {
        $_SESSION['id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        if ($role == 'Admin') {
            header("location: aCalendar.html");
        } elseif ($role == 'Member') {
            header("location: mCalendar.html");
        }
    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>
