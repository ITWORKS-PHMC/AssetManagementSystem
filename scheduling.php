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
    .button-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        height: 50px;
        width: 100%;
    }

    .calendar-container {
        flex: 1; 
        max-width: 70%; 
    }

    .schedule-container {
        display: flex;
        flex-wrap: wrap; 
    }

    .buttonAdd {
        width: 250px;
    }

    .list-container {
        background-color: #DCDAD9; 
        width: 400px;
        max-width: 30%; 
        display: flex;
        flex-direction: column; 
        height: 800px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        margin: 0 auto; 
        padding: 20px;
        margin-left: 1vw; 
        margin-top:20px;
    }

    .list-content {
        flex: 1; 
    }
</style>


<body>
<header>
    <p class="title-page">Scheduling</p>
</header>

<br><hr>
<br>
<!-- CALENDAR MODULE -->
<div class="schedule-container">
    <div class="calendar-container">
        <?php include("scheduling-calendar.php"); ?>
    </div>
    <div class="list-container">
        <div class="button-container">
            <button class="buttonAdd" onclick="openForm()">+ Schedule</button>
        </div>
        <div class="list-content">
            <p>Scheduled Maintenance : </p>
                    <?php
                    // Place the PHP code here to display schedule maintenance
                    $query = "SELECT title, schedule_date, end_date FROM scheduling";
                    $result = mysqli_query($conn, $query);
        
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $title = $row['title'];
                            $schedule_date = date("F d, Y | h:ia", strtotime($row['schedule_date'])); // Format schedule_date
                            $end_date = date("F d, Y | h:ia", strtotime($row['end_date'])); // Format end_date
                            echo "<p><strong>Title:</strong> $title</p>";
                            echo "<p><strong>Schedule Date:</strong> $schedule_date</p>";
                            echo "<p><strong>End Date:</strong> $end_date</p>";
                            echo "<button class='edit-btn' style='cursor:pointer;'data-title='$title' data-start-date='$schedule_date' data-end-date='$end_date'>Edit</button>";
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
        <form class="Form" method="post" id="addTicketForm" action="function_calendar.php">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title"><br>
            <input type="datetime-local" id="startDate" name="startDate" step="1"><br>
            <label for="enddate">End-Date:</label><br>
            <input type="datetime-local" id="endDate" name="endDate" step="1"><br><br>
            <input type="hidden" name="addSchedule" value="1"> <!-- Add this line -->
            <input type="submit" value="Submit" class="btn-add">
            <button type="button" class="btn-cancel" onclick="closeForm()">Close</button>
        </form>
    </div>
</div>
<!-- CALENDAR MODAL for editing schedule dates -->
<div class="Modal" id="edit-pop-up">
    <div class="popup">
        <form class="Form" method="post" id="editTicketForm" action="function_calendar.php">
            <input type="hidden" id="editId" name="editId" value="">
            <label for="editTitle">Title:</label><br>
            <input type="text" id="editTitle" name="editTitle"><br>
            <label for="editStartDate">Start Date:</label><br>
            <input type="datetime-local" id="editStartDate" name="editStartDate"><br>
            <label for="editEndDate">End Date:</label><br>
            <input type="datetime-local" id="editEndDate" name="editEndDate"><br><br>
            <input type="hidden" name="addSchedule" value="1"> <!-- Add this line -->
            <input type="submit" value="Save Changes" class="btn-edit" style="cursor:pointer;" onclick="submitEditForm()">
            <button type="button" class="btn-cancel" onclick="closeEditForm()">Cancel</button>
        </form>
    </div>
</div>
 <script>
        function openForm() {
            document.getElementById("pop-up").style.display = "flex";
        }
        function closeForm() {
            document.getElementById("pop-up").style.display = "none";
        }
         // Edit button click event
        document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            let title = this.getAttribute('data-title');
            let startDate = this.getAttribute('data-start-date');
            let endDate = this.getAttribute('data-end-date');

            document.getElementById('editTitle').value = title;
            document.getElementById('editStartDate').value = startDate;
            document.getElementById('editEndDate').value = endDate;

            // Set the event ID in a hidden field for submission
            let eventId = this.getAttribute('data-event-id');
            document.getElementById('editId').value = eventId;

            openEditForm();
        });
    });
    // Function to open edit form
    function openEditForm() {
        document.getElementById('edit-pop-up').style.display = 'flex';
    }
    // Function to close edit form
    function closeEditForm() {
        document.getElementById('edit-pop-up').style.display = 'none';
    }
		</script>
</body>
</html>
