<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = trim($_POST['event_name']);
    $date = trim($_POST['date']);
    $author = $_SESSION['username'];

    $stmt = $conn->prepare("INSERT INTO events (event_name, date, author) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $event_name, $date, $author);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>
</head>
<body>
    <form method="POST" action="create_event.php">
        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" required><br>
        <label for="date">Date:</label>
        <input type="date" name="date" required><br>
        <button type="submit">Create Event</button>
    </form>
</body>
</html>