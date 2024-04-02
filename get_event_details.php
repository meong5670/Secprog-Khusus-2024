<?php
require 'database_connection.php';

if(isset($_POST['event_id'])) {

    $eventId = mysqli_real_escape_string($con, $_POST['event_id']);

    $query = "SELECT * FROM calendar_event_master WHERE event_id = '$eventId'";
    $result = mysqli_query($con, $query);

    // Check if query was successful
    if($result && mysqli_num_rows($result) > 0) {
        // Fetch event details
        $eventDetails = mysqli_fetch_assoc($result);
        echo json_encode($eventDetails);
    } else {
        echo json_encode(['error' => 'Event not found']);
    }
} else {
    echo json_encode(['error' => 'Event ID not provided']);
}
?>
