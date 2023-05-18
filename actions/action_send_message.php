<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');

require_once(__DIR__ . '/../database/client.class.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/messages.class.php');
require_once(__DIR__ . '/../database/department.class.php');

$session = new Session();

$db = getDatabaseConnection();
$user = Client::getClientById($db, $session->getId());
$ticket_id = $_POST["ticket_id"];
$ticket = Ticket::getTicketById($db, intval($ticket_id));
$message = $_POST["message"];

$response = [];

if ($ticket->status == 'Closed') {
    if (Ticket::updateTicket($db, intval($ticket_id), $ticket->agent_id, $ticket->client_id, $ticket->department_id, 'Open', $ticket->title)) {
        if (Message::createMessage($db, intval($ticket_id), $user->id, $message, new DateTime('now', new DateTimeZone('Europe/Lisbon')))) {
            $response["status"] = "success";
            $response["message"] = "Message sent and ticket updated successfully.";
            $response["username"] = $user->username;
        } else {
            $response["status"] = "error";
            $response["message"] = "Message creation failed!";
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "Ticket update failed!";
    }
    $response["redirect"] = $_SERVER['HTTP_REFERER'];
} else if (Client::isAgent($db, $user->id) && $ticket->status == 'Not Assigned') {
    if (Ticket::updateTicket($db, intval($ticket_id), $user->id, $ticket->client_id, $ticket->department_id, 'Open', $ticket->title)) {
        if (Message::createMessage($db, intval($ticket_id), $user->id, $message, new DateTime('now', new DateTimeZone('Europe/Lisbon')))) {
            $response["status"] = "success";
            $response["message"] = "Message sent, ticket updated, and assigned successfully.";
            $response["username"] = $user->username;
            $response["redirect"] = "../pages/tickets_client.php";
        } else {
            $response["status"] = "error";
            $response["message"] = "Message creation failed!";
            $response["redirect"] = "../pages/message.php?id=" . $ticket_id;
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "Ticket update failed!";
        $response["redirect"] = $_SERVER['HTTP_REFERER'];
    }
} else if (Message::createMessage($db, intval($ticket_id), $user->id, $message, new DateTime('Europe/Lisbon'))) {
    $response["status"] = "success";
    $response["message"] = "Message sent successfully.";
    $response["username"] = $user->username;
    $response["redirect"] = "../pages/message.php?id=" . $ticket_id;
} else {
    $response["status"] = "error";
    $response["message"] = "Message creation failed!";
    $response["redirect"] = "../pages/message.php?id=" . $ticket_id;
}

header('Content-Type: application/json');
echo json_encode($response);

?>