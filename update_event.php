<?php
// update_event.php

// Include database connection
require 'database_connection.php';

// Check if form data is provided
if(isset($_POST['event_id'], $_POST['event_title'], $_POST['event_start_date'], $_POST['event_end_date'])) {
    // Sanitize form data
    $eventId = mysqli_real_escape_string($con, $_POST['event_id']);
    $eventTitle = mysqli_real_escape_string($con, $_POST['event_title']);
    $eventStartDate = mysqli_real_escape_string($con, $_POST['event_start_date']);
    $eventEndDate = mysqli_real_escape_string($con, $_POST['event_end_date']);

    // Update event in database
    $query = "UPDATE calendar_event_master SET title = '$eventTitle', start = '$eventStartDate', end = '$eventEndDate' WHERE event_id = '$eventId'";
    $result = mysqli_query($con, $query);

    // Check if update was successful
    if($result) {
        // Return success message
        echo json_encode(['success' => true]);
    } else {
        // If update fails, return error message
        echo json_encode(['error' => 'Error updating event']);
    }
} else {
    // If form data not provided, return error message
    echo json_encode(['error' => 'Form data not provided']);
}
?>
