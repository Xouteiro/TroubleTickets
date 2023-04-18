<?php

require_once(__DIR__ . '/database/connection.db.php');
require_once(__DIR__ . '/database/client.class.php');

$db = getDatabaseConnection();

$client = Client::getClientById($db, 2);

Client::GiveADmin($db, $client->id);

?>