<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$mysqli = new mysqli("localhost", "root", "", "cs306_db");

if ($mysqli->connect_errno) {
    die("DB connection failed: " . $mysqli->connect_error);
}

$output = "";
$js_alert = "";
$flight_id = 999; // Test flight ID
$passenger_id = 1; // Example fixed passenger

// Handle add/remove buttons
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        if (isset($_POST['add_ticket'])) {
            $mysqli->query("INSERT INTO Ticket (ticket_id, flight_id, passenger_id) VALUES (NULL, $flight_id, $passenger_id)");
        } elseif (isset($_POST['remove_ticket'])) {
            $mysqli->query("
                DELETE FROM Ticket 
                WHERE ticket_id = (
                    SELECT ticket_id FROM (
                        SELECT ticket_id FROM Ticket 
                        WHERE flight_id = $flight_id 
                        ORDER BY ticket_id DESC 
                        LIMIT 1
                    ) AS sub
                )
            ");
        }
    } catch (mysqli_sql_exception $e) {
        if (str_contains($e->getMessage(), "fully booked")) {
            $js_alert = "Flight is fully booked!";
        } else {
            $js_alert = "An error occurred: " . $e->getMessage();
        }
    }
}

// Flight status and ticket check for all flights
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
        <th>Tickets Count</th>
        <th>Status</th>
        <th>Trigger Result</th>
    </tr>";

    while ($row = $result->fetch_assoc()) {
        $status_message = "";

        if ($row['ticket_count'] == 0 && $row['status'] === 'Cancelled') {
            $status_message = "<span class='success'>✅ Trigger worked</span>";
        } elseif ($row['ticket_count'] == 0 && $row['status'] !== 'Cancelled') {
            $status_message = "<span class='error'>❌ Trigger failed</span>";
        } else {
            $status_message = "<span class='info'>🎟️ Active Tickets</span>";
        }

        $output .= "<tr>
            <td>{$row['flight_id']}</td>
            <td>{$row['ticket_count']}</td>
            <td>{$row['status']}</td>
            <td>$status_message</td>
        </tr>";
    }

    $output .= "</table>";
} else {
    $output = "<p class='message'>No flight data found.</p>";
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trigger 1 – CancelFlightIfNoTickets</title>
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
            margin: 8px;
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
    <h3><strong>Trigger 1:</strong> Cancel Flight if No Tickets</h3>
    <p>This tool checks all flights and shows whether the cancellation trigger works properly.</p>

    <form method="post">
        <button name="add_ticket" type="submit">➕ Add Ticket to Flight 999</button>
        <button name="remove_ticket" type="submit">➖ Remove Ticket from Flight 999</button>
        <button type="submit">🔍 Refresh Table</button>
    </form>

    <br>
    <?php if ($output) echo $output; ?>

    <?php if (!empty($js_alert)): ?>
    <script>alert("<?= htmlspecialchars($js_alert) ?>");</script>
    <?php endif; ?>

    <br><br>
    <a href="/cs306_project/user/index.php">⏪ Return to Homepage</a>
</body>
</html>
