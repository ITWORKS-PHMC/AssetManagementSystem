<?php
require './config/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
$sql = "SELECT file_content FROM upload ORDER BY id DESC"; // Assuming 'file_content' contains image data
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($file_content); // Bind the result to a variable
?>

<?php
while ($stmt->fetch()) {
    // Output the image directly
    echo '<img src="data:image/jpeg;base64,' . base64_encode($file_content) . '" alt="file-image" height="200" width="200">';
}
$stmt->close(); // Close the statement
$conn->close(); // Close the connection
?>
</body>
</html>
