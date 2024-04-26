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

    $insertSql ="INSERT INTO scheduling (title, schedule_date, end_date) 
                 VALUES('$title','$startdate','$enddate')";

    // Execute SQL query
    if ($con->query($insertSql) === TRUE) {
        // Redirect to avoid duplicate form submission
        header("Location: scheduling.php"); // Corrected redirect path
        exit();
    } else {
        echo "Error: " . $insertSql . "<br>" . $con->error;
    }
   }
    
}

// Query to fetch scheduling data
$display_query = "SELECT id, title, schedule_date, end_date FROM scheduling";
$results = mysqli_query($con, $display_query);

// Check if there are any results
if ($results) {
    $count = mysqli_num_rows($results);

    // Initialize an array to hold the scheduling data
    $data_arr = array();
    $i = 1;

    // Fetch data and format it
    while ($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $data_arr[$i]['id'] = $data_row['id'];
        $data_arr[$i]['title'] = $data_row['title'];
        // Format dates to 'Y-m-d' format
    $data_arr[$i]['start'] = date("Y-m-d", strtotime($data_row['schedule_date']));
	$data_arr[$i]['end'] = date("Y-m-d", strtotime($data_row['end_date']));

        $data_arr[$i]['color'] = '#640a00'; // Set color as desired
        $data_arr[$i]['url'] = '#'; // Set URL as desired
        $i++;
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
mysqli_close($con);
?>
