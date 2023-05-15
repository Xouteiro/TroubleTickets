<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');

require_once(__DIR__ . '/../database/client.class.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/messages.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../actions/action_create_ticket.php');

$session = new Session();





$db = getDatabaseConnection();
$department = $_POST["departments"];
$title = $_POST["ticket-title"];
$message = $_POST["ticket-message"];

$tickets = Ticket::getTickets($db,500);
$departmentObj = Department::getDepartmentByName($db, $department);

foreach($tickets as $ticket){
    if($ticket->title == $title && $ticket->department_id == $department && $ticket->client_id==$session->getId()){
        $session->addMessage('error', 'You already have a similar ticket');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}


if (empty($_POST['departments']) || empty($_POST['ticket-title']) || empty($_POST['ticket-message']) || strlen($_POST['ticket-message'])>30) {
    $session->addMessage('error', 'All fields must be filled or message is too long!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    if (Ticket::createTicket($db, $session->getId(), $departmentObj->id,'Not Assigned', $title)) {
        $afterTickets = Ticket::getTickets($db,500);
        foreach($afterTickets as $afterTicket){
            if($afterTicket->title == $title && $afterTicket->department_id == $departmentObj->id && $afterTicket->client_id==$session->getId()){
                $lastTicket = $afterTicket;
                if(Message::createMessage($db,$lastTicket->id,$session->getId(),$message, new DateTime('now', new DateTimeZone('Europe/Lisbon')))){
                    $session->addMessage('success', 'Message created with success!');
                }
                else{
                    $session->addMessage('error', 'Message creation failed!');
                    Ticket::deleteTicket($db,$lastTicket->id);
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
        }
    }
        $session->addMessage('success', 'Ticket created with success!');
        header('Location: ../pages/tickets_client.php');
    } else {
        $session->addMessage('error', 'Ticket creation failed!');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}


