<?php
require 'function/connect.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If search term is provided
    if (isset($_POST['searchTerm']) && !empty($_POST['searchTerm'])) {
        $searchTerm = $_POST['searchTerm'];
        $sql = "SELECT * FROM ticketing WHERE dept LIKE '%$searchTerm%' OR empname LIKE '%$searchTerm%' OR item LIKE '%$searchTerm%'";
    } else {
        $sql = "SELECT * FROM ticketing";
    }
} else {
    $sql = "SELECT * FROM ticketing";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management - Ticketing</title>
    <link rel="stylesheet" href="style.css">
    
    <?php include("./layouts/navbar.php") ?>
</head>

<body>
    <div class="page-header">
        <div class="title-container">
            <h1 class="title-header">Ticketing for Maintenance Tasks </h1>
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
            <button class="add-ticket" onclick="openForm()">+ Ticket</button>
        </div>
    </div>
    <br>
    <hr>

    <script>
        function openForm() {
            document.getElementById("pop-up").style.display = "flex";
        }
        function closeForm() {
            document.getElementById("pop-up").style.display = "none";
        }
         document.getElementById('searchTerm').addEventListener('input', function() {
            var searchTerm = this.value.toLowerCase();
            var tableRows = document.querySelectorAll('.table-design tbody tr');

            tableRows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
          </script>
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
            </thead>
            <tbody>
                <?php
             
function getStatusText($status)
{
    $statusText = '';
    if ($status == 1) {
        $statusText = '<span class="status-yellow">On Progress</span>';
    } elseif ($status == 2) {
        $statusText = '<span class="status-red">Deadline</span>';
    } elseif ($status == 3) {
        $statusText = '<span class="status-green">Accomplished</span>';
    }
    return $statusText;
}

function getDurationText($duration)
{
    if ($duration < 0) {
        return '<span class="status-red">Reached Deadline</span>';
    } elseif ($duration < 4) {
        return '<span class="status-yellow">Near Deadline</span>';
    } else {
        return '<span class="status-green">On Progress</span>';
    }
}

require 'function/connect.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If search term is provided
    if (isset($_POST['searchTerm']) && !empty($_POST['searchTerm'])) {
        $searchTerm = $_POST['searchTerm'];
        $sql = "SELECT * FROM ticketing WHERE dept LIKE '%$searchTerm%' OR empname LIKE '%$searchTerm%' OR item LIKE '%$searchTerm%'";
    } else {
        $sql = "SELECT * FROM ticketing";
    }
} else {
    $sql = "SELECT * FROM ticketing";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
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
            $tdColor = 'background-color: yellow;';
        } elseif ($statusText == '<span class="status-red">Reached Deadline</span>') {
            $tdColor = 'background-color: red;';
        }
        echo "<td style='$tdColor'>" . $statusText . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>No matching records found.</td></tr>";
}
?>

            </tbody>
        </table>
    </div>
</body>
</html>
<?php
$conn->close();
?>
