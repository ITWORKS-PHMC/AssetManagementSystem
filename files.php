<?php
require 'function/connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="style.css">
    <?php include("./layouts/navbar.php")?>
</head>
<script>
    function addfile(){
        document.getElementById("pop-up").style.display = "flex";
    }
</script>
<body>
    <div class="files-header">
        <h1>Files to Upload</h1>
        <button class="btnUpload-style" onclick=addfile()>Upload File</button>
        <div class ="upload-modal" id="pop-up">
        <form class="upload" method="POST">
        <input type="file" id="fileInput" multiple>
        <textarea id="description" placeholder="Add a description..."></textarea>
        <button id="submitBtn">Submit</button>
        </form>
        </div>

        </div>
       
        <hr>
        <br>
    </div>
    <div class="files-content" id="filesContent">
        <!-- Images and descriptions will be displayed here -->
    </div>
    
</body>
</html>
