<?php
require '../vendor/autoload.php';

$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$dbName = "support_db";
$collectionName = "tickets";

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Ticket ID not found.");
}

$filter = ['_id' => new MongoDB\BSON\ObjectID($id)];
$query = new MongoDB\Driver\Query($filter);
$result = $manager->executeQuery("$dbName.$collectionName", $query);
$ticket = current($result->toArray());

if (!$ticket) {
    die("Ticket not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Ticket Details</h2>
    <p><strong>Username:</strong> <?= $ticket->username ?></p>
    <p><strong>Message:</strong> <?= $ticket->message ?></p>
    <p><strong>Status:</strong> <?= $ticket->status ? "Active" : "Resolved" ?></p>
    <p><strong>Created At:</strong> 
        <?= is_object($ticket->created_at) ? $ticket->created_at->toDateTime()->format('Y-m-d H:i:s') : $ticket->created_at ?>
    </p>

    <h4>Comments:</h4>
    <?php if (!empty($ticket->comments)): ?>
        <ul class="list-group">
            <?php foreach ($ticket->comments as $comment): ?>
                <li class="list-group-item"><?= htmlspecialchars($comment) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">No comments yet.</p>
    <?php endif; ?>

    <a href="ticket_list.php" class="btn btn-secondary mt-4">← Back to Tickets</a>
</body>
</html>
