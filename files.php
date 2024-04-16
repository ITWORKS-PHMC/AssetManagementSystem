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
    function openForm(){
        document.getElementById("pop-up").style.display = "flex";
    }
    
    function closeForm() {
        document.getElementById("pop-up").style.display = "none";
    }
    
</script>
<body>
<div class="files-header">
    <h1>Files to Upload</h1>
    <button class="btnUpload-style" onclick="openForm()">Upload File</button>
    <div class="Modal" id="pop-up">
        <form class="Form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <input type="text" id="description" name="description" placeholder="Add a description...">
            <button type="submit" class="btn-upload">Upload</button>
            <button type="button" class="btn-cancel" onclick="closeForm()">Close</button>
        </form>
    </div>
</div>
<hr>
<br>
<div class="files-content" id="filesContent">
    <!-- Images and descriptions will be displayed here -->
</div>
</body>
</html>
