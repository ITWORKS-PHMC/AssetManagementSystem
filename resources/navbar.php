<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preventive Maintenance</title>
    <link rel="stylesheet" href="style.css">
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Roboto&display=swap");
        /* Style for active link */
        .active-link {
            color: #27b339 !important;
        }
        body {
        width: 100vw !important;
        margin-top: 20px !important;
        margin: 0 auto !important;
      font-family: "Roboto", sans-serif !important;
      background-color: #f5f5f5 !important;
      overflow-x: hidden;
    }

    .navigation-bar {
      width: 100vw !important;
      height: 60px !important;
      display: flex !important;
      justify-content: space-between !important;
      align-items: center !important;
      padding: 0 20px !important;
      background-color: #ffffff !important;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }

    .header-content {
      display: flex !important;
      align-items: center !important;
      justify-content: flex-start !important;
      width: 100vw !important;
    }

    .header-title {
      font-family: "Roboto", sans-serif !important;
      font-size: 1.6rem !important;
      font-weight: bold !important;
      color: #333333 !important;
      margin-right: 20px !important;
    }

    .header-sections {
      display: flex !important;
      font-family: "Roboto", sans-serif !important;
      font-size: 1.2rem !important;
    }

    .nav-link {
      margin-left: 20px !important;
      text-decoration: none !important;
      color: #333333 !important;
      font-weight: bold !important;
      transition: color 0.2s ease !important;
    }

    .nav-link:hover {
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