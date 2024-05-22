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

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "! You are logged in as " . htmlspecialchars($_SESSION['role']) . ".";

$stmt = $conn->prepare("SELECT id, event_name, author, date, progress FROM events ORDER BY date ASC");
$stmt->execute();
$stmt->bind_result($id, $event_name, $author, $date, $progress);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Main Page</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav>
        <a href="create_event.php">Create Event</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <h1>Main Page</h1>
        <p>You are logged in as <?php echo htmlspecialchars($_SESSION['role']); ?>.</p>
        <table>
            <tr>
                <th>Event Name</th>
                <th>Author</th>
                <th>Date</th>
                <th>Actions</th>
                <th>Progress</th>
            </tr>
            <?php while ($stmt->fetch()): ?>
            <tr>
                <td><?php echo htmlspecialchars($event_name); ?></td>
                <td><?php echo htmlspecialchars($author); ?></td>
                <td><?php echo htmlspecialchars($date); ?></td>
                <td>
                    <?php if ($_SESSION['username'] == $author || $_SESSION['role'] == 'admin'): ?>
                    <a href="edit_event.php?id=<?php echo $id; ?>">Edit</a>
                    <a href="delete_event.php?id=<?php echo $id; ?>">Delete</a>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($progress); ?>
                    <?php if ($progress == 'In Progress' && ($_SESSION['username'] == $author || $_SESSION['role'] == 'admin')): ?>
                    <a href="finish_event.php?id=<?php echo $id; ?>">Finished</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php $stmt->close(); ?>
