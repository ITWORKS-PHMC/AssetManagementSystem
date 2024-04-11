<?php
require 'function/connect.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $department = $_POST['dept'];
    $Name = $_POST['name'];
    $itemname = $_POST['item'];
    $order = $_POST['orderDate'];
    $deadline = $_POST['deadlineDate'];

    $sql = "INSERT INTO scheduling (dept,empname,item,ordrDate,deadlineDate)
    VALUES(?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss",$department,$Name,$itemname,$order,$deadline);
    if ($stmt->execute() === TRUE) {
        echo '<script>alert("New record inserted successfully");</script>';
       echo "<script> history.back()</script>";
       exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();

}
?>