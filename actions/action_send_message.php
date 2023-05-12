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


if($ticket->status=='Closed'){
    if (Ticket::updateTicket($db, intval($ticket_id), $ticket->agent_id, $ticket->client_id, $ticket->department_id, 'Open', $ticket->title)) {
        if (Message::createMessage($db, intval($ticket_id), $user->id, $message , new DateTime('now')))
            $session->addMessage('success', 'Message sent and ticket updated with success!');
            header('Location: ../pages/tickets_client.php');
    } else {
        $session->addMessage('error', 'Ticket update failed!');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
else if(Client::isAgent($db, $user->id) && $ticket->status == 'Not Assigned'){
    if (Ticket::updateTicket($db, intval($ticket_id), $user->id, $ticket->client_id, $ticket->department_id, 'Open', $ticket->title)) {
        if (Message::createMessage($db, intval($ticket_id), $user->id, $message , new DateTime('now')))
            $session->addMessage('success', 'Message sent,ticket updated with success and assigned');
            header('Location: ../pages/tickets_client.php');
    } else {
        $session->addMessage('error', 'Ticket update failed!');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

}
else if (Message::createMessage($db, intval($ticket_id), $user->id, $message , new DateTime('now'))) {
    $session->addMessage('success', 'Message sent with success!');
    header('Location: ../pages/message.php?id=' . $ticket_id . '');
} else {
    $session->addMessage('error', 'Message failed!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
