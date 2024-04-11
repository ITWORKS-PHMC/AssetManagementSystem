<?php
// Database connection parameters
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "assetmanagement"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from input field
    $input_data = $_POST['input_data'];

    // Prepare SQL statement
    $sql = "INSERT INTO sampledb (semple) VALUES (?)";

    // Prepare and bind parameter
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $input_data);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "New record inserted successfully";
        echo '<script>alert("New record inserted successfully");</script>'; // Add JavaScript alert
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Data</title>
</head>
<body>

<h2>Insert Data</h2>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="input_data">Input Data:</label><br>
    <input type="text" id="input_data" name="input_data"><br><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>

