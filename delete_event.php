<?php
require 'database_connection.php';

// Check if event_id is set and not empty
if (isset($_POST['event_id']) && !empty($_POST['event_id'])) {
    $eventId = $_POST['event_id'];
    
    // Delete the event from the database
    $query = "DELETE FROM calendar_event_master WHERE event_id = $eventId";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        // If deletion is successful, return a success message
        echo json_encode(array('status' => true, 'msg' => 'Event deleted successfully'));
    } else {
        // If deletion fails, return an error message
        echo json_encode(array('status' => false, 'msg' => 'Error deleting event'));
    }
} else {
    // If event_id is not set or empty, return an error message
    echo json_encode(array('status' => false, 'msg' => 'Event ID not provided'));
}
?>
