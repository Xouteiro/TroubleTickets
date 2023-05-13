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
$department = $_POST["department_id"];
$ticket_id = $_POST["ticket_id"];
$ticket = Ticket::getTicketById($db, intval($ticket_id));


if (Ticket::updateTicket($db, intval($ticket_id), $ticket->agent_id ,$ticket->client_id, intval($department), $ticket->status, $ticket->title)) {
    $session->addMessage('success', 'Ticket department updated with success!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    $session->addMessage('error', 'Ticket department update failed!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
