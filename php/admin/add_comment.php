<?php
require 'mongo_connection.php';

$id = $_POST['id'] ?? null;
$comment = trim($_POST['comment'] ?? '');

if (!$id || !$comment) {
    die("Missing ticket ID or comment.");
}

$bulk = new MongoDB\Driver\BulkWrite;
$bulk->update(
    ['_id' => new MongoDB\BSON\ObjectID($id)],
    ['$push' => ['comments' => "admin: " . $comment]]
);

$manager->executeBulkWrite("$dbName.$collectionName", $bulk);

// Yönlendirme geri detay sayfasına
header("Location: detail.php?id=$id");
exit;
