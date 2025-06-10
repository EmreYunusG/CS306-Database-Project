<?php
require '../vendor/autoload.php';
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($username && $message) {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert([
            'username' => $username,
            'message' => $message,
            'status' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'comments' => []
        ]);
        $manager->executeBulkWrite("support_db.tickets", $bulk);

        echo "<div style='padding: 20px; font-family: sans-serif'>";
        echo "<p><strong>✅ Ticket successfully created.</strong></p>";
        echo "<a href='ticket_list.php' class='btn btn-primary'>→ View All Tickets</a> ";
        echo "<a href='index.php' class='btn btn-secondary'>← Go to Homepage</a>";
        echo "</div>";
        exit;
    } else {
        echo "<p><strong>⚠️ Please fill in all fields.</strong></p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Support Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Create Support Ticket</h2>

    <a href="index.php" class="btn btn-secondary mb-3">← Go to Homepage</a>

    <form method="post">
        <div class="mb-3">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Message:</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Create Ticket</button>
    </form>
</div>
</body>
</html>
