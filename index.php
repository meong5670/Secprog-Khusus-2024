<!DOCTYPE html>
<html>
<head>
<title>How to create dynamic event calendar in HTML and PHP</title>
<!-- *Note: You must have internet connection on your laptop or pc other wise below code is not working -->
<!-- CSS for full calendar -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
<!-- JS for jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- JS for full calendar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<!-- bootstrap css and js -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Modal for editing and deleting events -->
<div class="modal fade" id="event-modal" tabindex="-1" role="dialog" aria-labelledby="event-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="event-modal-label">Event Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Event details will be displayed here -->
                <div id="event-details"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="delete-event-btn" data-event-id="">Delete</button>
                <button type="button" class="btn btn-primary" id="edit-event-btn" data-event-id="">Edit</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h5 align="center">How to create dynamic event calendar in HTML and PHP</h5>
            <div id="calendar"></div>
			<div class="row">
                    <div class="col-sm-6">  
                        <button type="button" class="btn btn-warning btn-block" id="edit_event_btn">Edit Event</button>
                    </div>
                    <div class="col-sm-6">  
                    <button type="button" class="btn btn-danger" id="delete-event-btn" data-event-id="<?php echo $event['event_id']; ?>">Delete Event</button>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- Start popup dialog box -->
<div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Add New Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">�</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-sm-12">  
                            <div class="form-group">
                              <label for="event_name">Event name</label>
                              <input type="text" name="event_name" id="event_name" class="form-control" placeholder="Enter your event name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">  
                            <div class="form-group">
                              <label for="event_start_date">Event start</label>
                              <input type="date" name="event_start_date" id="event_start_date" class="form-control onlydatepicker" placeholder="Event start date">
                             </div>
                        </div>
                        <div class="col-sm-6">  
                            <div class="form-group">
                              <label for="event_end_date">Event end</label>
                              <input type="date" name="event_end_date" id="event_end_date" class="form-control" placeholder="Event end date">
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="save_event()">Save Event</button>
            </div>
        </div>
    </div>
</div>

<!-- End popup dialog box -->

<!-- Modal for editing event -->
<div class="modal fade" id="edit-event-modal" tabindex="-1" role="dialog" aria-labelledby="edit-event-modal-label" aria-hidden="true">
    pusing
</div>

</body>
<script>
$(document).ready(function() {
    display_events();
}); //end document.ready block

function display_events() {
    var events = new Array();
    $.ajax({
        url: 'display_event.php',  
        dataType: 'json',
        success: function (response) {
            var result = response.data;
            $.each(result, function (i, item) {
                events.push({
                    event_id: result[i].event_id,
                    title: result[i].title,
                    start: result[i].start,
                    end: result[i].end,
                    color: result[i].color,
                    url: result[i].url
                });     
            });
            var calendar = $('#calendar').fullCalendar({
                defaultView: 'month',
                timeZone: 'local',
                editable: true,
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    $('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
                    $('#event_end_date').val(moment(end).format('YYYY-MM-DD'));
                    $('#event_entry_modal').modal('show');
                },
                events: events,
                eventRender: function(event, element, view) {
                    element.bind('click', function() {
                        // Set the event details in the modal body
                        $('#event-details').html('<p><strong>ID:</strong> ' + event.event_id + '</p><p><strong>Title:</strong> ' + event.title + '</p><p><strong>Start:</strong> ' + event.start.format("YYYY-MM-DD") + '</p><p><strong>End:</strong> ' + event.end.format("YYYY-MM-DD") + '</p>');
                        
                        // Update the data-event-id attribute of the buttons with the event's ID
                        $('#edit-event-btn').attr('data-event-id', event.event_id);
                        $('#delete-event-btn').attr('data-event-id', event.event_id);
                        
                        // Show the modal
                        $('#event-modal').modal('show');
                    });
                }
            }); //end fullCalendar block  
        }, //end success block
        error: function (xhr, status) {
            alert(response.msg);
        }
    }); //end ajax block    
}

// Handle delete button click
$('#delete-event-btn').click(function() {
    var eventId = $(this).attr('data-event-id'); // Get the event ID from the button's data attribute
    
    if (confirm('Are you sure you want to delete this event?')) {
        // Send AJAX request to delete event
        $.ajax({
            url: 'delete_event.php',
            type: 'POST',
            data: { event_id: eventId }, // Send the event ID to the PHP script
            success: function(response) {
                // If deletion is successful, hide the modal and refresh the calendar
                $('#calendar').fullCalendar('refetchEvents');
                $('#event-modal').modal('hide');
                location.reload();
            },
            error: function(xhr, status, error) {
                // If there's an error, display an alert
                alert('Error deleting event: ' + error);
            }
        });
    }
});

// Handle edit button click
$('#edit-event-btn').click(function() {
    var eventId = $(this).attr('data-event-id'); // Get the event ID from the button's data attribute
    
    // Hide the modal displaying event details
    $('#event-modal').modal('hide');
    
    // Open edit event modal and populate with event details
    $.ajax({
        url: 'get_event_details.php',
        type: 'POST',
        data: { event_id: eventId },
        dataType: 'json',
        success: function(response) {
            $('#edit-event-modal #event-id').val(response.event_id);
            $('#edit-event-modal #event-title').val(response.title);
            $('#edit-event-modal #event-start-date').val(response.start);
            $('#edit-event-modal #event-end-date').val(response.end);
            $('#edit-event-modal').modal('show');
        },
        error: function(xhr, status, error) {
            // If there's an error, display an alert
            alert('Error fetching event details: ' + error);
        }
    });
});


// Handle form submission for editing event
$('#edit-event-form').submit(function(event) {
    event.preventDefault(); // Prevent default form submission
    
    // Serialize form data
    var formData = $(this).serialize();
    
    // Send AJAX request to update event
    $.ajax({
        url: 'update_event.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            // If update is successful, refresh the calendar to reflect changes
            $('#calendar').fullCalendar('refetchEvents');
            $('#edit-event-modal').modal('hide');
        },
        error: function(xhr, status, error) {
            // If there's an error, display an alert
            alert('Error updating event: ' + error);
        }
    });
});


function save_event() {
    var event_name = $("#event_name").val();
    var event_start_date = $("#event_start_date").val();
    var event_end_date = $("#event_end_date").val();
    if (event_name == "" || event_start_date == "" || event_end_date == "") {
        alert("Please enter all required details.");
        return false;
    }
    $.ajax({
        url: "save_event.php",
        type: "POST",
        dataType: 'json',
        data: { event_name: event_name, event_start_date: event_start_date, event_end_date: event_end_date },
        success: function(response) {
            $('#event_entry_modal').modal('hide');
            if (response.status == true) {
                alert(response.msg);
                location.reload();
            } else {
                alert(response.msg);
            }
        },
        error: function(xhr, status) {
            console.log('ajax error = ' + xhr.statusText);
            alert(response.msg);
        }
    });
    return false;
}
</script>

</html> 
