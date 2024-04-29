<?php
// Establish a database connection
$con = new mysqli('localhost', 'root', '', 'assetmanagement');

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if form is submitted for insertion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['addSchedule'])){
        $title = $_POST['title'];
        $startdate = $_POST['startDate'];
        $enddate = $_POST['endDate'];

        // Prepare and bind statement to prevent SQL injection
        $insertSql = $con->prepare("INSERT INTO scheduling (title, schedule_date, end_date) VALUES (?, ?, ?)");
        $insertSql->bind_param("sss", $title, $startdate, $enddate);

        // Execute SQL query
        if ($insertSql->execute() === TRUE) {
            // Redirect to avoid duplicate form submission
            header("Location: scheduling.php"); // Corrected redirect path
            echo "<script>console.log('Datas: $title <br> $startdate <br> $enddate')</script>";
            exit();
        } else {
            echo "Error: " . $insertSql->error;
        }
        $insertSql->close();
    }
}
// Check if form is submitted for updating
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    if (isset($_POST['editSchedule'])){
        // Debugging: Echo out received POST data
        echo "<script>console.log('Received POST data:<br>')</script>";
        var_dump($_POST);

        $id = $_POST['editId'];
        $title = $_POST['editTitle'];
        $startdate = $_POST['editStartDate'];
        $enddate = $_POST['editEndDate'];

        // Prepare and bind statement to prevent SQL injection
        $updateSql = $con->prepare("UPDATE scheduling SET title = ?, schedule_date = ?, end_date = ? WHERE id = ?");
        $updateSql->bind_param("sssi", $title, $startdate, $enddate, $id);

        // Execute SQL query
        if ($updateSql->execute() === TRUE) {
            // Redirect to avoid duplicate form submission
            header("Location: scheduling.php"); // Corrected redirect path
            exit();
        } else {
            // Print error message including SQL query
            echo "Error: " . $updateSql->error;
            
        }
        $updateSql->close(); 
    }  
}

// Query to fetch scheduling data
$display_query = "SELECT id, title, schedule_date, end_date FROM scheduling";
$results = $con->query($display_query);

// Check if there are any results
if ($results && $results->num_rows > 0) {
    // Initialize an array to hold the scheduling data
    $data_arr = array();

    // Fetch data and format it
    while ($data_row = $results->fetch_assoc()) {
        $data_arr[] = array(
            'id' => $data_row['id'],
            'title' => $data_row['title'],
            'start' => date("Y-m-d", strtotime($data_row['schedule_date'])),
            'end' => date("Y-m-d", strtotime($data_row['end_date'])),
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
