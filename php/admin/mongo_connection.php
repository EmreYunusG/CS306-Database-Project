<?php
require '../vendor/autoload.php';

$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$dbName = "support_db";
$collectionName = "tickets";
?>
