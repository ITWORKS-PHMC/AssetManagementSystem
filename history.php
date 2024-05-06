<?php
require 'config/connect.php';
$sql = "SELECT * FROM ticketing ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management - History</title>
    <link rel="stylesheet" href="style.css">
    <?php include("./resources/navbar.php")?>
</head>
<body>
    <header>
    <p class="title-page">History to</p>
    <br><hr>
    <br>
    </header>
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
                function getStatusText($status) {
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
                function getDurationText($duration) {
                    if ($duration < 0) {
                        return '<span class="status-red">Reached Deadline</span>';
                    } elseif ($duration < 4) {
                        return '<span class="status-yellow">Near Deadline</span>';
                    } else {
                        return '<span class="status-green">On Progress</span>';
                    }
                }
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