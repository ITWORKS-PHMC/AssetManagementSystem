<?php
require 'config/connect.php';
// Check for success or error messages
if (isset($_SESSION['message'])) {
    echo '<div class="message">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']); // Clear the message
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management - Scheduling</title>
    <?php include("./resources/navbar.php")?>
    <link rel="stylesheet" href="style.css">
</head>
<style>
.schedule-container {
        display: flex;
        flex-wrap: wrap; 
    }
.button-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}
.buttonAdd {
    width: 200px;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}
.buttonAdd:hover {
    background-color: #45a049;
}
.list-container {
    background-color: #DCDAD9; 
    width: 400px;
    display: flex;
    flex-direction: column; 
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    margin: 20px 20px 20px 0;   
    padding: 20px;
    max-height: 700px;
    overflow-y: scroll;
    overflow-x: hidden;
}
.list-content {
    flex: 1; 
}
.list-content p {
    margin-bottom: 10px;
}
.edit-btn {
    background-color: #4e7cbf;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.edit-btn:hover {
    background-color: #355f99; 
}
.delete-btn {
    margin-left: 10px;
    background-color: #d9534f;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.delete-btn:hover {
    background-color: #b02a25;
}
</style>
<body>
<script src="./resources/script.js" defer></script>
<header>
<p class="title-page">Scheduling</p>
</header>
<br><hr>
<br>
<!-- CALENDAR MODULE -->
<div class="schedule-container">
    <div class="calendar-container" style="flex: 1; max-width: 70%;">
        <?php include("scheduling-calendar.php"); ?>
    </div>
    <div class="list-container">
        <div class="button-container">
            <button class="buttonAdd" onclick="openForm()">+ Schedule</button>
        </div>
        <div class="list-content">
            <p>SCHEDULED MAINTENANCE :</p>
            <?php
            // Place the PHP code here to display schedule maintenance
            $query = "SELECT id,title, schedule_date, end_date FROM scheduling";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $eventId = $row['id']; 
                    $title = $row['title'];
                    $schedule_date = date("F d, Y | h:ia", strtotime($row['schedule_date'])); 
                    $end_date = date("F d, Y | h:ia", strtotime($row['end_date'])); 
                    echo "<p><strong>Title:</strong> $title</p>";
                    echo "<p><strong>Schedule Date:</strong> $schedule_date</p>";
                    echo "<p><strong>End Date:</strong> $end_date</p>";
                    echo "<button class='edit-btn' style='cursor:pointer;' data-title='$title' data-start-date='$schedule_date' data-end-date='$end_date' data-event-id='$eventId'>Edit</button>";                            
                    echo "<button class='delete-btn' style='cursor:pointer;' data-title='$title' data-start-date='$schedule_date' data-end-date='$end_date' data-event-id='$eventId'>Delete</button>";
                    echo "<hr>";
                }
            } else {
                echo "<p>No scheduled events.</p>";
            }
            mysqli_close($conn);
    ?>
</div>
    </div>
</div>
<!-- CALENDAR MODAL for adding schedule dates -->
<div class="Modal" id="pop-up">
    <div class="popup">
        <form class="Form" method="post" id="addSchedule" action="function_calendar.php">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title"><br>
            <label for="startdate">Start-Date:</label><br>
            <input type="datetime-local" id="startDate" name="startDate" step="1"><br>
            <label for="enddate">End-Date:</label><br>
            <input type="datetime-local" id="endDate" name="endDate" step="1"><br><br>
            <input type="hidden" name="addSchedule" value="1">
            <input type="submit" value="Submit" class="btn-add">
            <button type="button" class="btn-cancel" onclick="closeForm()">Close</button>
        </form>
    </div>
</div>
<!-- CALENDAR MODAL for editing schedule dates -->
<div class="Modal" id="edit-pop-up">
    <div class="popup">
        <form class="Form" method="post" id="editSchedule" action="function_calendar.php">
            <h3>Edit Schedule</h3>
            <input type="hidden" id="editId" name="editId" value="">
            <label for="editTitle">Title:</label><br>
            <input type="text" id="editTitle" name="editTitle"><br>
            <label for="edit-startdate">Start-Date:</label><br>
            <input type="datetime-local" id="editStartDate" name="editStartDate" step="60"><br>
            <label for="edit-enddate">End-Date:</label><br>
            <input type="datetime-local" id="editEndDate" name="editEndDate" step="60" ><br><br>
            <input type="hidden" name="editSchedule" value="1"> 
            <input type="submit" value="Save Changes" class="btn-edit" style="cursor:pointer;">
            <button type="button" class="btn-cancel" onclick="closeEditForm()">Cancel</button>
        </form>
    </div>
</div>

<!-- CALENDAR MODAL for deleting schedule dates -->
<div class="Modal" id="delete-pop-up">
    <div class="popup">
        <form class="Form" method="post" id="deleteScheduleForm" action="function_calendar.php">
            <h3>Are you sure you want to delete event?</h3>
            <label for="title"><strong>Title:</strong></label>
            <input type="text" id="deleteTitle" name="deleteTitle" value="" style="background-color: #f0f0f0;" readonly>
            <label for="schedule_date"><strong>Schedule Date:</strong></label>
            <input type="text" id="deleteStart" name="deleteStart" value="" style="background-color: #f0f0f0;" readonly>
            <label for="end_date"><strong>End Date:</strong></label>
            <input type="text" id="deleteEnd" name="deleteEnd" value="" style="background-color: #f0f0f0;" readonly>
            <input type="submit" value="Delete Event" name="deleteSchedule" class="delete-schedule-btn" ></input>
            <input type="hidden" id="deleteId" name="deleteId" value="<?php echo $eventId; ?>">
            <button type="button" class="btn-cancel" onclick="closeDelForm()">Cancel</button>
        </form>
    </div>
</div>

 <script>
  
		</script>
</body>
</html>