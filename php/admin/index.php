<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require "mongo_connection.php";

// Check query parameter to determine filter
$showResolved = isset($_GET['show']) && $_GET['show'] === 'resolved';

$filter = $showResolved ? ['status' => false] : ['status' => true];
$query = new MongoDB\Driver\Query($filter, ['sort' => ['created_at' => -1]]);
$tickets = $manager->executeQuery("$dbName.$collectionName", $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Ticket List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">
        <?= $showResolved ? 'Resolved Support Tickets' : 'Active Support Tickets' ?> (Admin Panel)
    </h2>

    <!-- Buttons to toggle views -->
    <div class="mb-3">
        <?php if ($showResolved): ?>
            <a href="index.php" class="btn btn-secondary">← Show Active Tickets</a>
        <?php else: ?>
            <a href="index.php?show=resolved" class="btn btn-outline-secondary">Show Resolved Tickets</a>
        <?php endif; ?>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Username</th>
            <th>Message</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= htmlspecialchars($ticket->username) ?></td>
                <td><?= htmlspecialchars($ticket->message) ?></td>
                <td>
                    <?php
                    if (isset($ticket->created_at)) {
                        echo is_object($ticket->created_at)
                            ? $ticket->created_at->toDateTime()->format('Y-m-d H:i:s')
                            : $ticket->created_at;
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td>
                    <a href="detail.php?id=<?= $ticket->_id ?>" class="btn btn-sm btn-info">Details</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
