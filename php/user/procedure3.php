<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = new mysqli("localhost", "root", "", "cs306_db");
if ($mysqli->connect_errno) {
    die("DB connection failed: " . $mysqli->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flight Summary</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            color: #2c3e50;
            padding: 40px;
        }

        h2 {
            color: #34495e;
        }

        h3 {
            margin-top: 40px;
            color: #2c3e50;
        }

        form {
            background-color: #fff;
            padding: 20px;
            width: 400px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2ecc71;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            margin-top: 10px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #ecf0f1;
        }

        .error {
            color: red;
            margin-top: 20px;
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
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>📊 Flight Summary</h2>

<form method="get">
    <label for="flight_id">Enter Flight ID:</label>
    <input type="number" name="flight_id" id="flight_id" required>
    <input type="submit" value="Get Summary">
</form>

<?php
if (isset($_GET['flight_id'])) {
    $flight_id = intval($_GET['flight_id']);

    // ✈️ Flight Info
    $query = "CALL GetFlightSummary($flight_id)";
    if ($result = $mysqli->query($query)) {
        echo "<h3>✈️ Flight Details</h3><table><tr>";
        while ($field = $result->fetch_field()) echo "<th>" . htmlspecialchars($field->name) . "</th>";
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $val) echo "<td>" . htmlspecialchars($val) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $mysqli->next_result();
    } else {
        echo "<p class='error'>❌ Error: " . $mysqli->error . "</p>";
    }

    // 🧍 Passenger List
    $result = $mysqli->query("
        SELECT P.passenger_id, P.f_name, P.l_name
        FROM Ticket T
        JOIN Passenger P ON T.passenger_id = P.passenger_id
        WHERE T.flight_id = $flight_id
    ");
    echo "<h3>🧍 Passenger List</h3>";
    if ($result && $result->num_rows > 0) {
        echo "<table><tr><th>Passenger ID</th><th>First Name</th><th>Last Name</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['passenger_id']}</td><td>{$row['f_name']}</td><td>{$row['l_name']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No passengers found.</p>";
    }

    // 🧳 Baggage Info
    $result = $mysqli->query("
        SELECT B.bag_number, B.ticket_id, B.weight, B.extra_fee
        FROM Baggage B
        JOIN Ticket T ON B.ticket_id = T.ticket_id
        WHERE T.flight_id = $flight_id
    ");
    echo "<h3>🧳 Baggage Info</h3>";
    if ($result && $result->num_rows > 0) {
        echo "<table><tr><th>Baggage #</th><th>Ticket ID</th><th>Weight</th><th>Extra Fee</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['bag_number']}</td><td>{$row['ticket_id']}</td><td>{$row['weight']}</td><td>{$row['extra_fee']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No baggage info found.</p>";
    }

    // 👨‍✈️ Crew Info
    $result = $mysqli->query("
        SELECT C.crew_id, C.first_name, C.last_name, A.role
        FROM assigned_to A
        JOIN Crew C ON A.crew_id = C.crew_id
        WHERE A.flight_id = $flight_id
    ");
    echo "<h3>👨‍✈️ Crew Info</h3>";
    if ($result && $result->num_rows > 0) {
        echo "<table><tr><th>Crew ID</th><th>First Name</th><th>Last Name</th><th>Role</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['crew_id']}</td><td>{$row['first_name']}</td><td>{$row['last_name']}</td><td>{$row['role']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No crew members assigned to this flight.</p>";
    }
}

$mysqli->close();
?>

<a href="/cs306_project/user/index.php">⬅️ Go to Homepage</a>

</body>
</html>
