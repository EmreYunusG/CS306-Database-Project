<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CS306 Project Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 40px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 40px;
        }

        h2 {
            color: #34495e;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
        }

        a {
            text-decoration: none;
            color: #2980b9;
            font-size: 16px;
            transition: all 0.2s ease;
        }

        a:hover {
            color: #1abc9c;
            font-weight: bold;
            text-decoration: underline;
        }

        .section {
            margin-bottom: 40px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

    <h1>🛫 CS306 Project – Triggers, Procedures & Tickets</h1>

    <div class="section">
        <h2>🧨 Triggers</h2>
        <ul>
            <li><a href="trigger1.php">Trigger 1 – Cancel Flight if No Tickets</a></li>
            <li><a href="trigger1_2.php">Trigger 2 – Reactivate Flight if Ticket Added</a></li>
            <li><a href="trigger1_3.php">Trigger 3 – Prevent Overbooking</a></li>
            <li><a href="trigger1_4.php">Trigger 4 – Auto Calculate Extra Baggage Fee</a></li>
        </ul>
    </div>

    <div class="section">
        <h2>📦 Stored Procedures</h2>
        <ul>
            <li><a href="procedure1.php">Procedure 1 – GetPassengerFlights</a></li>
            <li><a href="procedure2.php">Procedure 2 – AssignCrewToFlight</a></li>
            <li><a href="procedure3.php">Procedure 3 – GetFlightSummary</a></li>
        </ul>
    </div>

    <div class="section">
        <h2>📬 MongoDB Support Tickets</h2>
        <ul>
            <li><a href="ticket_create.php">➕ Create Ticket</a></li>
            <li><a href="ticket_list.php">📄 View Tickets</a></li>
        </ul>
    </div>

</body>
</html>

