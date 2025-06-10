<?php
require '../vendor/autoload.php';

$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

$username = $_GET['username'] ?? null;

$filter = [];
if ($username) {
    $filter['username'] = $username;
}

$query = new MongoDB\Driver\Query($filter, ['sort' => ['created_at' => -1]]);
$cursor = $manager->executeQuery("support_db.tickets", $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Support Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-2">Support Tickets</h2>

    <a href="index.php" class="btn btn-secondary mb-3">← Go to Homepage</a>

    <?php if ($username): ?>
        <p class="text-muted">Filtered by user: <strong><?= htmlspecialchars($username) ?></strong></p>
    <?php endif; ?>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
        <tr>
            <th>Username</th>
            <th>Message</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cursor as $ticket): ?>
            <tr>
                <td><?= htmlspecialchars($ticket->username ?? '-') ?></td>
                <td><?= htmlspecialchars($ticket->message ?? '-') ?></td>
                <td><?= ($ticket->status === true) ? 'Active' : 'Resolved' ?></td>
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
                    <a href="ticket_detail.php?id=<?= $ticket->_id ?>" class="btn btn-sm btn-info">Details</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
