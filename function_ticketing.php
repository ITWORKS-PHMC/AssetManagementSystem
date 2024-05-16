<?php
require 'config/connect.php';
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If search term is provided
    if (isset($_POST['searchTerm']) && !empty($_POST['searchTerm'])) {
        $searchTerm = $_POST['searchTerm'];
        $sql = "SELECT * FROM ticketing WHERE dept LIKE '%$searchTerm%' OR empname LIKE '%$searchTerm%' OR item LIKE '%$searchTerm%'";
    } else {
        $sql = "SELECT * FROM ticketing";
    }

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
            echo "Error: " . $insertSql . "<br>" . $conn->error;
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

    // SQL to update data in ticketing table
    $updateSql = $conn->prepare("UPDATE ticketing SET dept=?, empname=?, item=?, startDate=?, endDate=?, editedBy=?, status=? WHERE id=?");
    // Bind parameters
    $updateSql->bind_param("sssssis", $dept, $empname, $item, $startDate, $endDate, $editor, $status, $id);

    if ($updateSql->execute()) {
        // Redirect to avoid resubmission on page refresh
        header("Location: ticketing.php");
        exit();
    } else {
        echo "Error updating record: " . $updateSql->error;
    }
        $updateSql->close();
}
}
?>
