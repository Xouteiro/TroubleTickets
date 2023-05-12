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
$new_agent_id = $_POST["agent_id"];
$agent = Client::getClientById($db, intval($new_agent_id));
$ticket_id = $_POST["ticket_id"];
$ticket = Ticket::getTicketById($db, intval($ticket_id));


if (Ticket::updateTicket($db, intval($ticket_id), intval($new_agent_id),$ticket->client_id, $ticket->department_id, 'Open', $ticket->title)) {
    if(Message::createMessage($db, intval($ticket_id), intval($new_agent_id), "Hello, I am $agent->username, this ticket is now open and I got assigned to solve it. I will do it as soon as possible! See you soon! ", new DateTime('now')))
    $session->addMessage('success', 'Ticket updated with success!');
    header('Location: ../pages/tickets_client.php');
} else {
    $session->addMessage('error', 'Ticket update failed!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
