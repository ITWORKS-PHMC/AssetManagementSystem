<?php
require 'config/connect.php';
include ("function_ticketing.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management - Ticketing</title>
    <link rel="stylesheet" href="style.css">
    <?php include("./resources/navbar.php") ?>
</head>
<body>
<script src="./resources/script.js" defer></script>
    <div class="page-header">
        <div class="title-container">
            <p class="title-page">Ticketing</p>
        </div>
    </div>
    <div class="toolbar">
        <div class="search-container">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" id="searchTerm" name="searchTerm" placeholder="Search . . . . " value="<?php echo isset($_POST['searchTerm']) ? $_POST['searchTerm'] : ''; ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="button-container">
            <button class="buttonAdd" onclick="openForm()">+ Ticket</button>
        </div>
    </div>
    <br>
    <hr>

    <!-- Modal for adding ticketing -->
    <div class="Modal" id="pop-up">
        <div class="popup">
            <form class="Form" method="post" id="addTicketForm" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="dept">Department:</label><br>
                <input type="text" id="dept" name="dept"><br>
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name"><br>
                <label for="item">Item:</label><br>
                <input type="text" id="item" name="item"><br>
                <label for="createdBy">Created-By:</label><br>
                <input type="text" id="createBy" name="createBy"><br>
                <label for="editor">Edited-by:</label><br>
                <input type="text" id="editor" name="editor"><br>
                <label for="orderDate">Start-Date:</label><br>
                <input type="datetime-local" id="startDate" name="startDate"><br>
                <label for="enddate">End-Date:</label><br>
                <input type="datetime-local" id="endDate" name="endDate"><br><br>
                <input type="hidden" name="addTicket" value="1"> <!-- Add this line -->
                <input type="submit" value="Submit" class="btn-add">
                <button type="button" class="btn-cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
    </div>
    <br>
    <div class="table-wrapper">
        <table class="table-design">
            <thead class="table-header">
                <th scope="col">Order No.</th>
                <th scope="col">Department</th>
                <th scope="col">Name</th>
                <th scope="col">Item</th>
                <th scope="col">Created-By</th>
                <th scope="col">Start-Date</th>
                <th scope="col">End-Date</th>
                <th scope="col">Duration</th>
                <th scope="col">Edited-By</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </thead>
            <tbody>
                <?php
                function getDurationText($duration) {
                    if ($duration <= 0) {
                        return '<span class="status-red">Reached Deadline</span>';
                    } elseif ($duration < 4) {
                        return '<span class="status-yellow">Near Deadline</span>';
                    } else {
                        return '<span class="status-green">On Progress</span>';
                    }
                }
                if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rowid = $row['id']; // identifier per row
            echo "<tr onclick='Ticket-row-click($rowid)' onmouseover='this.style.backgroundColor=\"#3498DB \"; this.style.color=\"#ffffff\";' onmouseout='this.style.backgroundColor=\"\"; this.style.color=\"\";'>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['dept'] . "</td>";
            echo "<td>" . $row['empname'] . "</td>";
            echo "<td>" . $row['item'] . "</td>";
            echo "<td>" . $row['createdBy'] . "</td>";
            echo "<td>" . $row['startDate'] . "</td>";
            echo "<td>" . $row['endDate'] . "</td>";
            $startDate = strtotime($row['startDate']);
            $endDate = strtotime($row['endDate']);
            $duration = $endDate - $startDate;
            // Calculate days, hours, and minutes
            $days = floor($duration / (60 * 60 * 24));
            $hours = floor(($duration % (60 * 60 * 24)) / (60 * 60));
            $minutes = floor(($duration % (60 * 60)) / 60);
            echo "<td>" . $days . " days, " . $hours . " hours, " . $minutes . " minutes</td>";
            echo "<td>" . $row['editedBy'] . "</td>";
            $statusText = getDurationText($days);
            // Apply background color based on status
            $tdColor = '';
            if ($statusText == '<span class="status-yellow">Near Deadline</span>') {
                $tdColor = 'background-color: #F9E116;';
            } elseif ($statusText == '<span class="status-red">Reached Deadline</span>') {
                $tdColor = 'background-color: #DD494C;';
            } elseif ($statusText == '<span class="status-green">On Progress</span>') {
                $tdColor = 'background-color: #2ea44f;';
            }
            echo "<td style='$tdColor'>" . $statusText . "</td>";
            // Action buttons
            echo "<td style='text-align:center;'>";
            echo "<button style='cursor:pointer; color: white; background-color: #2592FF; margin-right: 10px;  display: inline-block; padding: 8px 16px; border-radius: 4px;'>Edit</button>";
            echo "<button style='cursor:pointer; color: white; background-color: #DD494C; margin-right: 10px;  display: inline-block; padding: 8px 16px; border-radius: 4px;'>Delete</button>";
            echo "</td>";
            echo "</tr>";   
        }
    } else {
        echo "<tr><td colspan='11'>No matching records found.</td></tr>";
    }
                ?>
            </tbody>
        </table>
    </div>

<!-- Modal for viewing ticketing -->
 <div class="Modal" id="pop-up">
        <div class="popup">
            <form class="Form" method="post" id="editTicketForm" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="dept">Department:</label><br>
            </form>
        </div>
    </div>

</body>
</html>
<?php
$conn->close();
?>
