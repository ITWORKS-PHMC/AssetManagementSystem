<?php
require 'config/connect.php';
include ("function_ticketing.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management - Ticketing</title>
    <link rel="stylesheet" href="style.css">
    <?php include("./resources/navbar.php") ?>
</head>
<style>
.table-container {
 box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    width: 1800px; /* Adjust width as needed */
    max-width: 100%; /* Set maximum width */
    margin: 0 auto; /* Center the container horizontally */
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #f2f2f2;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

.btn-edit, .btn-delete {
    cursor: pointer;
    padding: 8px 16px;
    transition: background-color 0.3s ease;
}

.btn-edit {
    background-color: #007bff;
    color: #fff;
}

.btn-delete {
    background-color: #dc3545;
    color: #fff;
}

.btn-edit:hover, .btn-delete:hover {
    background-color: #0056b3;
}
.edit-ticket-btn, .del-ticket-btn{
  appearance: none;
  border: 1px solid rgba(27, 31, 35, 0.15);
  border-radius: 6px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
  font-size: 14px;
  font-weight: 600;
  line-height: 20px;
  padding: 8px 20px;
  text-align: center;
  text-decoration: none;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: middle;
  white-space: nowrap;
  transition: background-color 0.3s ease;
  margin-right: 5px;
}
.edit-ticket-btn {
    background-color: #007bff; 
    color: #fff;
}

.del-ticket-btn {
    background-color: #dc3545; 
    color: #fff;
}
.edit-ticket-btn:hover {
    background-color: #0056b3; 
}

.del-ticket-btn:hover {
    background-color: #9c0000; 
}
</style>
<body>
<script src="./resources/script.js" defer></script>
    <div class="page-header">
        <div class="title-container">
            <p class="title-page">Ticketing</p>
        </div>
    </div>
    <br>
    <hr>
    <div class="toolbar">
        <div class="search-container">
            <form method="post" action="function_ticketing.php">
                <input type="text" id="searchTerm" name="searchTerm" placeholder="Search . . . . " value="<?php echo isset($_POST['searchTerm']) ? $_POST['searchTerm'] : ''; ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="button-container">
            <button class="buttonAdd" onclick="openForm()">+ Ticket</button>
        </div>
    </div><br>
    <!-- Modal for adding ticketing -->
    <div class="Modal" id="pop-up">
        <div class="popup">
            <form class="Form" method="post" id="addTicketForm" action="function_ticketing.php">
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
                <input type="hidden" name="addTicket" value="1"> <!-- Add this line -->
                <input type="submit" value="Submit" class="btn-add">
                <button type="button" class="btn-cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
    </div>
    <br>
    <div class="table-container">
    <div class="table-wrapper">
        <table class="table-design">
            <thead class="table-header">
                <th scope="col">Order No.</th>
                <th scope="col">Department</th>
                <th scope="col">Name</th>
                <th scope="col">Item</th>
                <th scope="col">Start-Date</th>
                <th scope="col">End-Date</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </thead>
            <tbody>
                <?php
                function getDurationText($duration) {
                    if ($duration <= 0) {
                        return '<span class="status-red">Reached Deadline</span>';
                    } elseif ($duration < 4) {
                        return '<span class="status-yellow">Near Deadline</span>';
                    } else {
                        return '<span class="status-green">On Progress</span>';
                    }
                }
                if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rowid = $row['id']; // identifier per row
            $department = $row['dept'];
            $Emp = $row['empname'];
            $item= $row['item'];
            $start = $row['startDate'];
            $end = $row['endDate'];
            $createdBy = $row['createdBy'];
            $status = $row['status'];
            $editor = $row['editedBy'];

            echo "<tr onmouseover='this.style.backgroundColor=\"#3498DB \"; this.style.color=\"#ffffff\";' onmouseout='this.style.backgroundColor=\"\"; this.style.color=\"\";'>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['dept'] . "</td>";
            echo "<td>" . $row['empname'] . "</td>";
            echo "<td>" . $row['item'] . "</td>";
            echo "<td>" . $row['startDate'] . "</td>";
            echo "<td>" . $row['endDate'] . "</td>";
            $startDate = strtotime($row['startDate']);
            $endDate = strtotime($row['endDate']);
            $duration = $endDate - $startDate;
            // Calculate days, hours, and minutes
            $days = floor($duration / (60 * 60 * 24));
            $hours = floor(($duration % (60 * 60 * 24)) / (60 * 60));
            $minutes = floor(($duration % (60 * 60)) / 60);
            $statusText = getDurationText($days);
            // Apply background color based on status
            $tdColor = '';
            if ($statusText == '<span class="status-yellow">Near Deadline</span>') {
                $tdColor = 'background-color: #F9E116;';
            } elseif ($statusText == '<span class="status-red">Reached Deadline</span>') {
                $tdColor = 'background-color: #DD494C;';
            } elseif ($statusText == '<span class="status-green">On Progress</span>') {
                $tdColor = 'background-color: #2ea44f;';
            }
            echo "<td style='$tdColor'>" . $statusText . "</td>";
            // Action buttons
            echo "<td style='text-align:center;'>";
            echo "<button class = 'edit-ticket-btn' edit-id='$rowid' edit-dept='$department' edit-name='$Emp' edit-item='$item' edit-start='$start' edit-end='$end' edit-created='$createdBy' edit-status='$status' edit-editor='$editor' onclick='EditTicket()'>Edit</button>";
            echo "<button class= 'del-ticket-btn' onclick='DelTicket()'>Delete</button>";
            echo "</td>";
            echo "</tr>";   
        }
    } else {
        echo "<tr><td colspan='11'>No matching records found.</td></tr>";
    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal for edit ticket -->
 <div class="Modal" id="editTicketPop" >
    <div class="popup">
        <form class="Form" method="post" id="editTicketForm" action="function_ticketing.php" >
            <h3>Edit Ticket</h3>
            <label>Order No. : </label>
            <input id="editId" type="text" readonly style="background-color: #DCDAD9;">
            <label>Department :</label>
            <input id="editDept" type="text">
            <label>Name : </label>
            <input id="editName" type="text">
            <label>Item : </label>
            <input id="editItem" type="text">
            <label>Start Date : </label>
            <input id="editStart" type="datetime-local">
            <label>End Date : </label>
            <input id="editEnd" type="datetime-local">
            <label>Created by : </label>
            <input id="editCreate" type="text" readonly style="background-color: #DCDAD9;">
            <label>Status : </label>
            <input id="editStatus" type="text">
            <label>Last edited by : </label>
            <input id="editEditor" type="text">
            <input type="hidden" name="editTicket" value="1">
            <input type="submit" value="Submit Edit" class="btn-add">
            <button type="button" class="btn-cancel" onclick="EditcloseForm()">Close</button>
        </form>
    </div>
</div>

</body>
<script>
function EditTicket() {
  document.getElementById("editTicketPop").style.display = "flex";
}
document.querySelectorAll(".edit-ticket-btn").forEach((button) => {
  button.addEventListener("click", function () {
    let editId = this.getAttribute("edit-id");
    let editDept = this.getAttribute("edit-dept");
    let editName = this.getAttribute("edit-name");
    let editItem = this.getAttribute("edit-item");
    let editStart = this.getAttribute("edit-start");
    let editEnd = this.getAttribute("edit-end");
    let editCreate = this.getAttribute("edit-created");
    let editStatus = this.getAttribute("edit-status");
    let editEditor = this.getAttribute("edit-editor");

    console.log("Data retrieved for editing:");
    console.log("Edit ID:", editId);
    console.log("Department:", editDept);
    console.log("Name:", editName);
    console.log("Item:", editItem);
    console.log("Start Date:", editStart);
    console.log("End Date:", editEnd);
    console.log("Created By:", editCreate);
    console.log("Status:", editStatus);
    console.log("Editor:", editEditor);

    // Populate the modal form with the retrieved data
    document.getElementById("editId").value = editId;
    document.getElementById("editDept").value = editDept;
    document.getElementById("editName").value = editName;
    document.getElementById("editItem").value = editItem;
    document.getElementById("editStart").value = editStart;
    document.getElementById("editEnd").value = editEnd;
    document.getElementById("editCreate").value = editCreate;
    document.getElementById("editStatus").value = editStatus;
    document.getElementById("editEditor").value = editEditor;
  });
});
</script>
</html>
<?php
$conn->close();
?>
