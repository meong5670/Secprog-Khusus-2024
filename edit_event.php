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

$stmt = $conn->prepare("SELECT event_name, author, date FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($event_name, $author, $date);

if (!$stmt->fetch() || ($username != $author && $role != 'admin')) {
    echo "You are not allowed to edit this event.";
    exit;
}

$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = trim($_POST['event_name']);
    $date = trim($_POST['date']);

    $stmt = $conn->prepare("UPDATE events SET event_name = ?, date = ? WHERE id = ?");
    $stmt->bind_param("ssi", $event_name, $date, $id);

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
    <title>Edit Event</title>
</head>
<body>
    <form method="POST" action="edit_event.php?id=<?php echo $id; ?>">
        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" value="<?php echo $event_name; ?>" required><br>
        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo $date; ?>" required><br>
        <button type="submit">Update Event</button>
    </form>
</body>
</html>
