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

if (!isset($_GET['id']) || !isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

$stmt = $conn->prepare("SELECT author FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($author);

if (!$stmt->fetch() || ($username != $author && $role != 'admin')) {
    echo "You are not allowed to finish this event.";
    exit;
}

$stmt->close();

$stmt = $conn->prepare("UPDATE events SET progress = 'Finished' WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>
