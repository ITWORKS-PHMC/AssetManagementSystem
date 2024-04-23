<?php
require 'function/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management - Scheduling</title>
    <?php include("./layouts/navbar.php")?>
    <link rel="stylesheet" href="style.css">
    </head>
<body>
    <h1>Scheduling for Maintenance Tasks</h1>
    <br><hr>
    <br>
<!---- CALENDAR ----->
 <div class="button-container">
            <button class="add-ticket" onclick="openForm()">+ Schedule</button>
        </div>
<div class="calendar-container">
<?php
    include ("scheduling-calendar.php");
?>
</div>
<!-- CALENDAR MODAL for inserting schedule dates -->
 <div class="Modal" id="pop-up">
        <div class="popup">
            <form class="Form" method="post" id="addTicketForm" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="title">Title:</label><br>
                <input type="text" id="title" name="title"><br>
                <input type="datetime-local" id="startDate" name="startDate"><br>
                <label for="enddate">End-Date:</label><br>
                <input type="datetime-local" id="endDate" name="endDate"><br><br>
                <input type="hidden" name="addTicket" value="1"> <!-- Add this line -->
                <input type="submit" value="Submit" class="btn-add">
                <button type="button" class="btn-cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
    </div>
</body>
</html>