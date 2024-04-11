<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="style.css">
    <?php include("./layouts/navbar.php")?>
</head>
<body>
    <div class="files-header">
        <h1>Files to Upload</h1>
        <label for="fileInput" class="btnUpload-style">Upload Img</label>
        <input type="file" id="fileInput" multiple>
        <textarea id="description" placeholder="Add a description..."></textarea>
        <button id="submitBtn">Submit</button>
        <hr>
        <br>
    </div>
    <div class="files-content" id="filesContent">
        <!-- Images and descriptions will be displayed here -->
    </div>
    
</body>
</html>
