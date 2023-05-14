<?php

require_once('../database/hashtag.class.php');
require_once('../database/connection.db.php');

$db = getDatabaseConnection();


$hashtagId = $_POST["hashtag_id"];
$ticketId = $_POST["ticket_id"];

echo $ticketId;
echo $hashtagId;

Hashtag::removeTicketHashtag($db, intval($ticketId), intval($hashtagId));


?>
