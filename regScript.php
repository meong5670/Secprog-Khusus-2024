<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendar";

$connect = mysqli_connect("localhost", "root", "", "calendar");

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // check true ornt
    if ($password !== $confirm_password) {
        echo "Passwords do not match";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $role = 'User';

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "Registration successful";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
