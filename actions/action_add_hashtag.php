<?php

require_once('../database/hashtag.class.php');
require_once('../database/connection.db.php');

$db = getDatabaseConnection();


$hashtagName = $_POST["hashtag_name"];
$ticketId = $_POST["ticket_id"];

if(!$hashtagName == null){
    if($hashtagName[0] != "#"){
        $hashtagName = "#" . $hashtagName;
    }

    $success = Hashtag::createTicketHashtag($db, intval($ticketId), $hashtagName);

    if ($success) {
        $response = array("status" => "success", "hashtag_id" => $db->lastInsertId());
    } else {
        $response = array("status" => "failure", "error" => "Failed to create hashtag.");
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
