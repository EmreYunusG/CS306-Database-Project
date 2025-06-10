<?php
require 'mongo_connection.php';

$id = $_POST['id'];

$bulk = new MongoDB\Driver\BulkWrite;
$bulk->update(
    ['_id' => new MongoDB\BSON\ObjectID($id)],
    ['$set' => ['status' => false]]
);
$manager->executeBulkWrite("$dbName.$collectionName", $bulk);
header("Location: index.php");
