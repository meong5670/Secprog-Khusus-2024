<?php
session_start();
require 'config.php';

if (!isset($_GET['id']) || !isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];

$stmt = $conn->prepare("SELECT author FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($author);

if (!$stmt->fetch() || ($username != $author && $role != 'admin')) {
    echo "You are not allowed to delete this event.";
    exit;
}

$stmt->close();

$stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>
