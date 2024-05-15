<?php
require 'config/connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file is uploaded successfully
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        // File uploaded successfully
        $file_desc = $_POST['description'];
        $file_name = $_FILES["file"]["name"];
        $file_tmp_name = $_FILES["file"]["tmp_name"];
        $file_content = addslashes(file_get_contents($file_tmp_name)); // Get file content
        $upload_date = date("Y-m-d H:i:s"); // Current datetime

        // Upload the file to a folder
        $upload_folder = "uploads/";
        move_uploaded_file($file_tmp_name, $upload_folder . $file_name);

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
        input[type="file"] {
            display: none;
        }
        .custom-file-input {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .file-name {
            display: inline-block;
            margin-left: 10px;
            color: #333;
            cursor: default;
        }
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
        margin-right: 20px;
        }
        .file-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .file-box img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .file-desc {
            font-weight: bold;
            margin-top: 5px;
        }
        .upload-date {
            color: #777;
            font-size: 0.9em;
        }
        .files-content {
            text-align: center; 
        }
       .delete-button {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .delete-button:hover {
        background-color: #c82333;
    }

    .file-box {
        position: relative;
    }

    .file-box:hover .delete-button {
        display: block;
    }

    .file-box:hover img,
    .file-box:hover .file-name,
    .file-box:hover .upload-date {
        opacity: 0.3;
        transition: opacity 0.3s ease;
    }

    .file-item {
        position: relative;
        display: inline-block;
        margin: 10px;
    }
    </style>
</head>
<body>
<script src="./resources/script.js" defer></script>
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
<?php  
$query = "SELECT * FROM upload";
$result = mysqli_query($conn, $query);

// Loop through each row in the result set
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="file-item">'; 
    echo '<div class="file-box">'; 
    
    // Displaying the image from the upload folder
    $imagePath = "uploads/" . $row['file_name']; // Path to the image
    if (file_exists($imagePath)) {
        echo '<img src="' . $imagePath . '" alt="file-image" height="200" width="200">'; 
    } else {
        echo '<p>Image not found</p>';
    }
echo '<br><p class="file-name">' . $row['file_name'] . '</p>';
$upload_date = strtotime($row['Upload_date']);
$year = date('Y', $upload_date);
$month = date('F', $upload_date);
$day = date('j', $upload_date);
$time = date('h:i A', $upload_date);

echo '<p class="upload-date">' . $month . ' ' . $day . ', ' . $year . '<br>' . $time . '</p>'; 
    echo '<button class="delete-button" onclick="deleteFile(' . $row['id'] . ')">Delete</button>';


echo '</div>'; 
echo '</div>';
}
?>
</div>
</body>
<script>  
</script>
</html>
