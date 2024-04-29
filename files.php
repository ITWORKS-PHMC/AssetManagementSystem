<?php
require 'config/connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file is uploaded successfully
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        // File uploaded successfully
        $file_desc = $_POST['description'];
        $file_name = $_FILES["file"]["name"];
        $file_content = addslashes(file_get_contents($_FILES["file"]["tmp_name"])); // Get file content
        $upload_date = date("Y-m-d H:i:s"); // Current datetime

        // Insert file details into database
        $sql = "INSERT INTO upload (file_desc, file_name, upload_date) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $file_desc, $file_name, $upload_date);
        
        if ($stmt->execute()) {
            // Redirect to avoid duplicate form submission
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="style.css">
    <?php include("./resources/navbar.php")?>
    <style>
       /* Hide the default file input button */
        input[type="file"] {
            display: none;
        }

        /* Style the custom file input button */
        .custom-file-input {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        /* Style the file name display */
        .file-name {
            display: inline-block;
            margin-left: 10px;
            color: #333;
            cursor: default;
        }

        /* Style the image preview box */
        .preview-box {
            margin-bottom: 10px;
            text-align: center;
        }

        .preview-box img {
            max-width: 200px;
            max-height: 200px;
            display: block;
            margin: auto;
        }

        /* Positioning for modal content */
        .modal-content {
            display: flex;
            justify-content: space-between;
        }

        .upload-section,
        .description-section {
            flex: 1;
            padding: 10px;
        }

        .button-section {
            text-align: center;
            margin-top: 20px;
        }
        .file-item {
        display: inline-block;
        vertical-align: top;
        margin-right: 20px; /* Adjust as needed */
    }

    .file-box {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        position: relative;
        width: 200px; /* Set a fixed width for consistency */
        text-align: center; /* Center the content */
        
    }

    .files-content {
        text-align: center; /* Center the file items */
    }

    </style>
</head>
<script>
    // Function to update the file name display and image preview
    function updateFileNameAndPreview(input) {
    var fileName = input.files[0] ? input.files[0].name : 'No file chosen';
    var fileNameDisplay = document.getElementById('file-name-display');
    fileNameDisplay.textContent = fileName;

    // Preview the image
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById('preview-image').setAttribute('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

    // Trigger the file input click event when the custom button is clicked
    document.getElementById('custom-button').addEventListener('click', function() {
        document.getElementById('file-input').click();
    });

    function openForm(){
        document.getElementById("pop-up").style.display = "flex";
    }

    function closeForm() {
        document.getElementById("pop-up").style.display = "none";
    }
</script>

<body>
<div class="files-header">
    <p class="title-page">Files to Upload</p>
    <button class="btnUpload-style" onclick="openForm()">Upload File</button>
    <div class="Modal" id="pop-up">
        <form class="Form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <div class="modal-content">
                <!-- Left section for upload button and preview -->
                <div class="upload-section">
                    <!-- Image preview box -->
                    <div class="preview-box">
                        <img id="preview-image" src="#" alt="Preview">
                    </div>
                    <!-- Custom file input button -->
                    <label for="file-input" class="custom-file-input" id="custom-button">Upload File</label>
                    <!-- Actual file input field (hidden) -->
                    <input type="file" name="file" id="file-input" onchange="updateFileNameAndPreview(this)">
                    <!-- Display file name -->
                    <span class="file-name" id="file-name-display">No file chosen</span>
                </div>
                <!-- Right section for description input -->
                <div class="description-section">
                              <input type="text" id="description" name="description" placeholder="Add a description...">
                </div>
            </div>
            <!-- Button section -->
            <div class="button-section">
                <input type="submit" value="Submit" class="btn-upload"></input>
                <button type="button" class="btn-cancel" onclick="closeForm()">Close</button>
            </div>
        </form>
    </div>
</div>
<hr>
<br>
<div class="files-content" id="filesContent">
    <!-- Images and descriptions will be displayed here -->
        <!-- Display uploaded files from database -->
<?php  
// Fetch uploaded files from the database
$query = "SELECT * FROM upload";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="file-item">'; // Start a container for each file
    echo '<div class="file-box">'; // Start styled box for the file
    echo '<img src="data:image;base64,' . $row['file_name'] . '" alt="file-image" height="200" width="200">'; // Display the image
    echo '<p><b>' . $row['file_desc'] . '</b></p>'; // Display file description
    echo '<p>' . $row['Upload_date'] . '</p>'; // Display file description
    echo '</div>'; // Close the styled box
    echo '</div>'; // Close the container
}

?>
</div>
</body>
<script>  
</script>
</html>
