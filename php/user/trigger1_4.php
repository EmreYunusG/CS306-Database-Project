<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mysqli = new mysqli("localhost", "root", "", "cs306_db");

if ($mysqli->connect_errno) {
    die("DB connection failed: " . $mysqli->connect_error);
}

$output = "";

$result = $mysqli->query("
    SELECT B.baggage_number, B.ticket_id, B.weight, B.extra_fee, P.f_name, P.l_name
    FROM Baggage B
    JOIN Ticket T ON B.ticket_id = T.ticket_id
    JOIN Passenger P ON T.passenger_id = P.passenger_id
    ORDER BY B.ticket_id, B.baggage_number
");

if ($result && $result->num_rows > 0) {
    $output .= "<table class='data-table'>";
    $output .= "<tr>
        <th>Ticket ID</th>
        <th>Baggage #</th>
        <th>Passenger</th>
        <th>Weight (kg)</th>
        <th>Extra Fee (₺)</th>
        <th>₺ / kg Over 25kg</th>
    </tr>";

    while ($row = $result->fetch_assoc()) {
        $overweight = $row['weight'] > 25 ? $row['weight'] - 25 : 0;
        $perKgFee = $overweight > 0 ? number_format($row['extra_fee'] / $overweight, 2) : '0.00';

        $output .= "<tr>
            <td>{$row['ticket_id']}</td>
            <td>{$row['baggage_number']}</td>
            <td>{$row['f_name']} {$row['l_name']}</td>
            <td>{$row['weight']}</td>
            <td>{$row['extra_fee']}</td>
            <td>{$perKgFee}</td>
        </tr>";
    }

    $output .= "</table>";
} else {
    $output = "<p class='message'>No baggage entries found.</p>";
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trigger 4 – Extra Baggage Fee</title>
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

        .data-table {
            margin: 30px auto;
            border-collapse: collapse;
            width: 90%;
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
    <h3><strong>Trigger 4:</strong> Auto-calculates extra baggage fees over 25kg</h3>
    <p>This table lists all baggage entries and shows whether extra fees were correctly applied by the trigger, along with the fee per kilogram over 25kg.</p>

    <?php echo $output; ?>

    <br><br>
    <a href="/cs306_project/user/index.php">⏪ Return to Homepage</a>
</body>
</html>

