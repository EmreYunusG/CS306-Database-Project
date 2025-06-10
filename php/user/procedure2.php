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
    <title>Assign Crew to Flight</title>
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
            background-color: #fff;
            padding: 20px;
            width: 400px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
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

        .result {
            font-size: 16px;
            margin-top: 20px;
            font-weight: bold;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
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

<h2>👨‍✈️ Assign Crew to Flight</h2>

<form method="post">
    <label for="flight_id">Flight ID:</label>
    <input type="number" name="flight_id" id="flight_id" required>

    <label for="crew_id">Crew ID:</label>
    <input type="number" name="crew_id" id="crew_id" required>

    <label for="role">Role:</label>
    <input type="text" name="role" id="role" required>

    <input type="submit" value="Assign">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $f = intval($_POST['flight_id']);
    $c = intval($_POST['crew_id']);
    $r = $mysqli->real_escape_string($_POST['role']);

    $res = $mysqli->query("CALL AssignCrewToFlight($f, $c, '$r')");
    if ($res) {
        echo "<p class='result success'>✅ Crew successfully assigned to the flight.</p>";
    } else {
        echo "<p class='result error'>❌ Error: " . $mysqli->error . "</p>";
    }
}
$mysqli->close();
?>

<a href="/cs306_project/user/index.php">⬅️ Go to Homepage</a>

</body>
</html>

