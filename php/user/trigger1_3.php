<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("localhost", "root", "", "cs306_db");
if ($mysqli->connect_errno) {
    die("DB connection failed: " . $mysqli->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trigger 3 – Check Full Flights</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f6f8;
            color: #2c3e50;
            padding: 40px;
        }

        h3 {
            font-size: 24px;
            color: #34495e;
        }

        p {
            font-size: 16px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: #fff;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #ecf0f1;
        }

        .full {
            color: red;
            font-weight: bold;
        }

        .available {
            color: green;
            font-weight: bold;
        }

        a {
            display: inline-block;
            margin-top: 40px;
            font-size: 16px;
            text-decoration: none;
            color: #2980b9;
        }

        a:hover {
            color: #1abc9c;
        }
    </style>
</head>
<body>

<h3>Trigger 3 – Prevent Overbooking</h3>
<p>
    The purpose of this trigger is to "prevent inserting new tickets into flights that are already fully booked".  
    This page checks each flight’s current ticket count against its aircraft capacity and indicates whether the flight is full.
</p>

<table>
    <tr>
        <th>Flight ID</th>
        <th>Aircraft Capacity</th>
        <th>Tickets Sold</th>
        <th>Status</th>
    </tr>

<?php
$query = "
    SELECT 
        F.flight_id,
        A.capacity,
        COUNT(T.ticket_id) AS tickets_sold
    FROM Flight F
    JOIN Aircraft A ON F.aircraft_id = A.aircraft_id
    LEFT JOIN Ticket T ON F.flight_id = T.flight_id
    GROUP BY F.flight_id, A.capacity
";

$result = $mysqli->query($query);

while ($row = $result->fetch_assoc()) {
    $fid = $row['flight_id'];
    $capacity = $row['capacity'];
    $sold = $row['tickets_sold'];

    $status = ($sold >= $capacity)
        ? "<span class='full'>Full Capacity</span>"
        : "<span class='available'>Available</span>";

    echo "<tr>
            <td>$fid</td>
            <td>$capacity</td>
            <td>$sold</td>
            <td>$status</td>
          </tr>";
}

$mysqli->close();
?>

</table>

<a href="/cs306_project/user/index.php">⬅️ Go to Homepage</a>

</body>
</html>



