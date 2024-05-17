<?php
require 'config/connect.php';
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If form is submitted to add a ticket
    if (isset($_POST['addTicket'])) {
        // Extract form data
        $dept = $_POST['dept'];
        $empname = $_POST['name'];
        $item = $_POST['item'];
        $createdBy = $_POST['createBy'];
        $editedBy = $_POST['editor'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        // SQL to insert data into ticketing table
        $insertSql = "INSERT INTO ticketing (dept, empname, item, startDate, endDate, createdBy, editedBy, status) 
                      VALUES ('$dept', '$empname', '$item', '$startDate', '$endDate', '$createdBy', '$editedBy', 1)";

        if ($conn->query($insertSql) === TRUE) {
            // Redirect to avoid duplicate form submission
            header("Location: ticketing.php");
            exit();
        } else {
           echo "<script>alert('Error: " . addslashes($conn->error) . "'); window.location.href='ticketing.php';</script>";
        }
    }

    // If form is submitted to edit a ticket
   if (isset($_POST['editTicket'])) {
    // Extract form data
    $id = $_POST['editId'];
    $dept = $_POST['editDept'];
    $empname = $_POST['editName'];
    $item = $_POST['editItem'];
    $startDate = $_POST['editStart'];
    $endDate = $_POST['editEnd'];
    $status = $_POST['editStatus'];
    $editor = $_POST['editEditor'];
    
    $startDateTime = new DateTime($startDate); // Convert dates to DateTime objects for comparison
    $endDateTime = new DateTime($endDate);
    
    $interval = $startDateTime->diff($endDateTime); // Calculate the interval between start and end dates
   
    if ($interval->days <= 7 && $interval->invert == 0) {  // Check if start date is within 7 days before end date
        $status = 2;
    }
 
    if ($startDateTime > $endDateTime) {    // Check if start date is after end date
        $status = 3;
    }
  
    $updateSql = $conn->prepare("UPDATE ticketing SET dept=?, empname=?, item=?, startDate=?, endDate=?, editedBy=?, status=? WHERE id=?");   // SQL to update data in ticketing table
    $updateSql->bind_param("sssssssi", $dept, $empname, $item, $startDate, $endDate, $editor, $status, $id); // Bind parameters
    if ($updateSql->execute()) {
        header("Location: ticketing.php"); // Redirect to avoid resubmission on page refresh
        exit();
    } else {
            echo "<script>alert('Error Updating record'); window.location.href='ticketing.php';</script>";
    }
    $updateSql->close();
}
}

// Delete ticket from the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['DelTicketForm'])) {
        $ticketId = $_POST['delId']; 

        if (!empty($ticketId) && is_numeric($ticketId)) {
            $deleteSql = $con->prepare("DELETE FROM ticketing WHERE id = ?");
            $deleteSql->bind_param("i", $ticketId);

            if ($deleteSql->execute() === TRUE) {
                header("Location: ticketing.php");
                exit();
            } else {
                echo "Error: " . $deleteSql->error;
            }

            $deleteSql->close();
        } else {
            // Display error message in an alert and redirect back to ticketing.php
            echo "<script>alert('Error: No Ticket Id found'); window.location.href='ticketing.php';</script>";
        }
    }
}

// Fetch tickets from database
$searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';
$sql = "SELECT * FROM ticketing";
if (!empty($searchTerm)) {
    $sql .= " WHERE dept LIKE '%$searchTerm%' OR empname LIKE '%$searchTerm%' OR item LIKE '%$searchTerm%'";
}
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

