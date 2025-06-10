<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$mysqli = new mysqli("localhost", "root", "", "cs306_db");
if ($mysqli->connect_errno) die("DB connection failed: " . $mysqli->connect_error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Passenger Flights</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            color: #2c3e50;
            padding: 40px;
        }

        h2 {
            color: #34495e;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 30px;
        }

        label {
            font-size: 16px;
            margin-right: 10px;
        }

        input[type="number"] {
            padding: 8px;
            font-size: 16px;
            width: 150px;
        }

        input[type="submit"] {
            padding: 8px 20px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2ecc71;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #ecf0f1;
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

<h2>🧍 Passenger Flight Information</h2>

<form method="get">
    <label for="pid">Passenger ID:</label>
    <input type="number" name="pid" id="pid" required>
    <input type="submit" value="Get Flights">
</form>

<?php
if (isset($_GET['pid'])) {
    $passenger_id = intval($_GET['pid']);
    $result = $mysqli->query("CALL GetPassengerFlights($passenger_id)");

    if ($result) {
        echo "<table><tr>";
        while ($f = $result->fetch_field()) echo "<th>{$f->name}</th>";
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $val) echo "<td>$val</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color:red;'>Error: " . $mysqli->error . "</p>";
    }
}
$mysqli->close();
?>

<a href="/cs306_project/user/index.php">⬅️ Go to Homepage</a>

</body>
</html>
