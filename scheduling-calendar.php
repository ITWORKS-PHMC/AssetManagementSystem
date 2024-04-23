<!DOCTYPE html>
<html>
<head>
<title>assetmanagement-calendar</title>
<!-- *Note: You must have internet connection on your laptop or pc otherwise below code is not working -->
<!-- CSS for full calendar -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
<!-- JS for jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- JS for full calendar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<!-- bootstrap js -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
 <script>
        function openForm() {
            document.getElementById("pop-up").style.display = "flex";
        }
        function closeForm() {
            document.getElementById("pop-up").style.display = "none";
        }
		</script>
<style>
body {
    font-family: Arial, sans-serif;
    color: #333;
    margin: 20px;
}

.container {
    max-width: 80%;
    margin: 0 auto;
	
}

#calendar {
    margin: 20px auto;
    background-color: #fff;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.fc-left {
    padding-left: 20px;
}

.fc-sun:hover,
.fc-mon:hover,
.fc-tue:hover,
.fc-wed:hover,
.fc-thu:hover,
.fc-fri:hover,
.fc-sat:hover {
    color: #f8dd00;
    transition: .3s;
    padding: 10px 10px 10px 10px;
    letter-spacing: 2px;
}

.fc-sun:not(hover),
.fc-mon:not(hover),
.fc-tue:not(hover),
.fc-wed:not(hover),
.fc-thu:not(hover),
.fc-fri:not(hover),
.fc-sat:not(hover) {
    transition: .3s;
}

.fc-title {
    cursor: default;
}

.fc-content {
    cursor: default;
}
.fc-day-grid-event,
.fc-h-event,
.fc-event,
.fc-start,
.fc-not-end,
.fc-draggable {
    background-color: #00ab41!important;
	border-color:#008631 !important;
}
</style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div id="calendar"></div>
        </div>
    </div>
</div>
</body>
<script>
$(document).ready(function() {
    display_events();
});

function display_events() {
    var events = [];
    $.ajax({
        url: 'function_calendar.php',
        dataType: 'json',
        success: function(response) {
            var result = response.data;
            $.each(result, function(i, item) {
                events.push({
                    event_id: result[i].event_id,
                    title: result[i].title,
                    name: result[i].name,
                    start: result[i].start,
                    end: result[i].end,
                    color: result[i].color,
                    url: result[i].url
                });
            });

            var calendar = $('#calendar').fullCalendar({
                defaultView: 'month',
                timeZone: 'local',
                editable: true,
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    $('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
                    $('#event_end_date').val(moment(end).format('YYYY-MM-DD'));
                },
                events: events,
            });
        },
        error: function(xhr, status) {
            alert(response.msg);
        }
    });
}
</script>
</html>
