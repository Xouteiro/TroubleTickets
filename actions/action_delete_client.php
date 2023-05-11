<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/client.class.php');

$db = getDatabaseConnection();

Client::deleteClient($db, $_GET['id']);

header('Location: ../pages/admin.php');

?>