<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preventive Maintenance</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style for active link */
        .active-link {
            color: #27b339 !important;
        }
    </style>
</head>

<body>
  <!----Navigation Menu------->
<div class="navigation-bar">
  <div class="header-content">
    <div class="header-title">
      <p>PREVENTIVE MAINTENANCE</p>
    </div>
    <div class="header-sections">
      <a href="dashboard.php" class="nav-link" onclick="highlightLink(this)">Dashboard</a>
      <a href="scheduling.php" class="nav-link" onclick="highlightLink(this)">Scheduling</a>
      <a href="files.php" class="nav-link" onclick="highlightLink(this)">Files</a>
      <a href="ticketing.php" class="nav-link" onclick="highlightLink(this)">Ticketing</a>
      <a href="history.php" class="nav-link" onclick="highlightLink(this)">History</a>
    </div>
  </div>
</div>

<script>
function highlightLink(link) {
    // Remove 'active-link' class from all links
    var links = document.querySelectorAll('.nav-link');
    links.forEach(function(item) {
        item.classList.remove('active-link');
    });
    // Add 'active-link' class to the clicked link
    link.classList.add('active-link');
}
</script>

</body>
</html>