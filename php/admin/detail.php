<?php
require 'mongo_connection.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Ticket ID not found.";
    exit;
}

$filter = ['_id' => new MongoDB\BSON\ObjectID($id)];
$query = new MongoDB\Driver\Query($filter);
$result = $manager->executeQuery("$dbName.$collectionName", $query);
$ticket = current($result->toArray());

if (!$ticket) {
    echo "Ticket not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Ticket Details</h2>
    <p><strong>Username:</strong> <?= $ticket->username ?? 'Unknown' ?></p>
    <p><strong>Message:</strong> <?= $ticket->message ?></p>
    <p><strong>Status:</strong> <?= $ticket->status ? 'Active' : 'Resolved' ?></p>
    <p><strong>Created At:</strong> <?= $ticket->created_at ?></p>

    <h4>Comments:</h4>
    <ul>
        <?php foreach ($ticket->comments ?? [] as $comment): ?>
            <li><?= $comment ?></li>
        <?php endforeach; ?>
    </ul>

    <form action="add_comment.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <label>Add Comment:</label>
        <input type="text" name="comment" class="form-control" required>
        <button type="submit" class="btn btn-primary mt-2">Submit Comment</button>
    </form>

    <form action="resolve_ticket.php" method="post" class="mt-3">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" class="btn btn-success">Mark as Resolved</button>
    </form>

    <a href="index.php" class="btn btn-secondary mt-3">← Back to List</a>
</body>
</html>
