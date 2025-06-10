<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "cs306_db";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Database connection error: " . $conn->connect_error);
}

// Check for delete action
if (isset($_GET['delete_id'])) {
    $ticket_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM ticket WHERE ticket_id = $ticket_id";
    $conn->query($delete_sql);
    header("Location: admin_ticket_list.php");
    exit();
}

// Fetch all tickets
$sql = "SELECT * FROM ticket";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - All Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Admin Panel - All Tickets</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
        <tr>
            <th>Ticket ID</th>
            <th>User ID</th>
            <th>Flight ID</th>
            <th>Seat Number</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['ticket_id'] ?></td>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['flight_id'] ?></td>
                    <td><?= $row['seat_number'] ?></td>
                    <td><?= $row['ticket_date'] ?></td>
                    <td>
                        <a href="admin_ticket_list.php?delete_id=<?= $row['ticket_id'] ?>"
                           onclick="return confirm('Are you sure you want to delete this ticket?')"
                           class="btn btn-sm btn-danger">Delete</a>
                        <a href="ticket_detail.php?id=<?= $row['ticket_id'] ?>" class="btn btn-sm btn-info">Details</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">No tickets available.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
