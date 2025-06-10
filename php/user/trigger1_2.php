<?php
$mysqli = new mysqli("localhost", "root", "", "cs306_db");

if ($mysqli->connect_errno) {
    die("DB connection failed: " . $mysqli->connect_error);
}

$output = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $query = "
        SELECT 
            F.flight_id,
            F.status,
            COUNT(T.ticket_id) AS ticket_count
        FROM Flight F
        LEFT JOIN Ticket T ON F.flight_id = T.flight_id
        GROUP BY F.flight_id
        ORDER BY F.flight_id
    ";

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $output .= "<table class='data-table'>";
        $output .= "<tr>
            <th>Flight ID</th>
            <th>Tickets Present</th>
            <th>Status</th>
            <th>Trigger Status</th>
        </tr>";

        while ($row = $result->fetch_assoc()) {
            $message = "";

            if ($row['ticket_count'] > 0) {
                if ($row['status'] === 'On Time') {
                    $message = "<span class='success'>✅ Ticket exists</span>";
                } else {
                    $message = "<span class='error'>❌ Status not updated</span>";
                }
            } else {
                $message = "<span class='info'>⚠️ No ticket present</span>";
            }

            $output .= "<tr>
                <td>{$row['flight_id']}</td>
                <td>{$row['ticket_count']}</td>
                <td>{$row['status']}</td>
                <td>$message</td>
            </tr>";
        }

        $output .= "</table>";
    } else {
        $output = "<p class='message'>No flight data available.</p>";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trigger 2 – ReactivateFlightIfTicketAdded</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            color: #2c3e50;
            padding: 40px;
            text-align: center;
        }

        h3 {
            font-size: 28px;
            color: #34495e;
        }

        p {
            font-size: 16px;
            margin-bottom: 30px;
        }

        form button {
            padding: 12px 24px;
            background-color: #3498db;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #2ecc71;
        }

        .data-table {
            margin: 30px auto;
            border-collapse: collapse;
            width: 80%;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 12px 16px;
            font-size: 16px;
        }

        .data-table th {
            background-color: #3498db;
            color: white;
        }

        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .success {
            color: #27ae60;
            font-weight: bold;
        }

        .error {
            color: #e74c3c;
            font-weight: bold;
        }

        .info {
            color: #f39c12;
            font-weight: bold;
        }

        .message {
            font-style: italic;
            color: #7f8c8d;
            margin-top: 20px;
        }

        a {
            display: inline-block;
            margin-top: 40px;
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }

        a:hover {
            color: #2ecc71;
        }
    </style>
</head>
<body>
    <h3><strong>Trigger 2:</strong> Reactivate Flight if Ticket Added</h3>
    <p>This page checks if any cancelled flights now have tickets and whether their status was updated correctly.</p>

    <form method="post">
        <button type="submit">Check All Flights</button>
    </form>

    <br>
    <?php if ($output) echo $output; ?>

    <br><br>
    <a href="/cs306_project/user/index.php">⏪ Return to Homepage</a>
</body>
</html>

