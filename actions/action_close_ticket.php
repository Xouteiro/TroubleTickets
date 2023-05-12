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


if (Ticket::updateTicket($db, intval($ticket_id), $ticket->agent_id, $ticket->client_id, $ticket->department_id, 'Closed', $ticket->title)) {
    if (Client::isAgent($db, $user->id)) {
        if (Message::createMessage($db, intval($ticket_id), $user->id, "Since the problem appears to have been resolved, I am closing this ticket. Please do not hesitate to reopen it or contact us if you need any further assistance. Thank you for contacting us! ", new DateTime('now')))
            $session->addMessage('success', 'Ticket updated with success!');
        header('Location: ../pages/tickets_client.php');
    }
} else {
    $session->addMessage('error', 'Ticket update failed!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
