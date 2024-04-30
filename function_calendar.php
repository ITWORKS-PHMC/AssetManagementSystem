<?php
// Establish a database connection
$con = new mysqli('localhost', 'root', '', 'assetmanagement');

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Inserting schedules to database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['addSchedule'])){
        // Validation if all the fields are empty
        if(!empty($_POST['title']) && !empty($_POST['startDate']) && !empty($_POST['endDate'])) {
            $title = $_POST['title'];
            $startdate = $_POST['startDate'];
            $enddate = $_POST['endDate'];

            // Prepare and bind statement to prevent SQL injection
            $insertSql = $con->prepare("INSERT INTO scheduling (title, schedule_date, end_date) VALUES (?, ?, ?)");
            $insertSql->bind_param("sss", $title, $startdate, $enddate);

            // Execute SQL query
            if ($insertSql->execute() === TRUE) {
                header("Location: scheduling.php"); // Corrected redirect path
                echo "<script>console.log('Data: $title <br> $startdate <br> $enddate')</script>";
                exit();
            } else {
                echo "Error: " . $insertSql->error;
            }
            $insertSql->close();
        } else {
            // JavaScript prompt if any field is empty
           echo "<script>alert('All fields are required.'); window.history.back();</script>";
            exit();
        }
    }
}
     // Updating schedules from the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editSchedule'])) {
        $eventId = $_POST['editId'];
        $title = $_POST['editTitle'];
        $startdate = $_POST['editStartDate'];
        $enddate = $_POST['editEndDate'];

        // Prepare and bind SQL query
        $updateSql = $con->prepare("UPDATE scheduling SET title = ?, schedule_date = ?, end_date = ? WHERE id = ?");
        $updateSql->bind_param("sssi", $title, $startdate, $enddate, $eventId);

        // Execute SQL query
        if ($updateSql->execute() === TRUE) {
            header("Location: scheduling.php");
            exit();
        } else {
            echo "Error: " . $updateSql->error;
        }

        $updateSql->close();
    }
}


    //Delete schedules from the database
    







// Query to fetch scheduling data to display in the calendar module
// Fetch scheduling data from the database
$display_query = "SELECT id, title, schedule_date, end_date FROM scheduling";
$results = $con->query($display_query);

// Check if there are any results
if ($results && $results->num_rows > 0) {
    // Initialize an array to hold the scheduling data
    $data_arr = array();

    // Fetch data and format it
    while ($data_row = $results->fetch_assoc()) {
        // Adjust the end date to include the last day of the event
        $end_date = date("Y-m-d", strtotime($data_row['end_date'] . ' +1 day'));

        // Add the event to the data array
        $data_arr[] = array(
            'id' => $data_row['id'],
            'title' => $data_row['title'],
            'start' => date("Y-m-d", strtotime($data_row['schedule_date'])),
            'end' => $end_date,
            'color' => '#640a00', // Set color as desired
            'url' => '#' // Set URL as desired
        );
    }

    // Prepare response data for scheduling data
    $scheduleData = array(
        'status' => true,
        'msg' => 'Data retrieved successfully!',
        'data' => $data_arr
    );
} else {
    // If no results found for scheduling data
    $scheduleData = array(
        'status' => false,
        'msg' => 'Error: No data found!'
        
    );
}

// Output JSON response for scheduling data
echo json_encode($scheduleData);

// Close database connection
$con->close();

?>
