<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Real-Time Calendar with Sidebar & Topbar Logout</title>
<link rel="stylesheet" href="..css/studio.css">
</head>
<body>

<div class="sidebar">
    <a href="#" class="active">Dashboard</a>
    <a href="../booking/booking.php">Bookings</a>
    <a href="../studio/studio.php">Studio</a>
    <a href="#">Reports</a>
</div>

<div class="main-content">

<div class="topbar">
    <div class="logo">LENTECH'S</div>
    <div class="top-menu">
        <span>Studio</span>
        <span class="active">Bookings</span>
        <a href="Logout.php" class="logout-btn">Logout</a> <!-- Logout in topbar -->
    </div>
</div>

<div id="nav">
    <button onclick="changeMonth(-1)">Prev</button>
    <span id="current-month"></span>
    <button onclick="changeMonth(1)">Next</button>
</div>

</div> <!-- main-content -->

<script>
let currentDate = new Date();

function renderCalendar(events=[]) {
    const month = currentDate.getMonth();
    const year = currentDate.getFullYear();
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    document.getElementById("current-month").innerText =
        currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });

    const calendarBody = document.getElementById("calendar-body");
    calendarBody.innerHTML = "";

    let date = 1;
    for(let i = 0; i < 6; i++) {
        let row = document.createElement("tr");
        for(let j = 0; j < 7; j++) {
            let cell = document.createElement("td");
            if(i === 0 && j < firstDay || date > lastDate) {
                cell.innerHTML = "";
            } else {
                cell.innerHTML = date;

                const today = new Date();
                if(date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    cell.classList.add("today");
                }

                events.forEach(e => {
                    const eventDate = new Date(e.date);
                    if(eventDate.getDate() === date &&
                       eventDate.getMonth() === month &&
                       eventDate.getFullYear() === year) {
                        const div = document.createElement("div");
                        div.className = "event";
                        div.innerText = e.title;
                        cell.appendChild(div);
                    }
                });

                date++;
            }
            row.appendChild(cell);
        }
        calendarBody.appendChild(row);
    }
}

async function fetchEvents() {
    const month = currentDate.getMonth() + 1;
    const year = currentDate.getFullYear();
    const res = await fetch(`get_events.php?month=${month}&year=${year}`);
    const data = await res.json();
    renderCalendar(data);
}

function changeMonth(offset) {
    currentDate.setMonth(currentDate.getMonth() + offset);
    fetchEvents();
}

fetchEvents();

setInterval(fetchEvents, 10000);
</script>

</body>
</html>