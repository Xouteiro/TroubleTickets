<?php

declare(strict_types=1);

require_once __DIR__ . '/../utils/session.php';
require_once __DIR__ . '/../utils/security.php';

require_once __DIR__ . '/../database/client.class.php';
require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/ticket.class.php';
require_once __DIR__ . '/../database/messages.class.php';
require_once __DIR__ . '/../database/department.class.php';

$session = new Session();

$ticket_id = isset($_POST["ticket_id"]) ? intval($_POST["ticket_id"]) : 0;
$message = isset($_POST["message"]) ? htmlspecialchars($_POST["message"]) : '';

$response = [];

if ($ticket_id <= 0) {
    $response["status"] = "error";
    $response["message"] = "Invalid ticket ID.";
    echo json_encode($response);
    exit;
}

$db = getDatabaseConnection();
$user = Client::getClientById($db, $session->getId());
$ticket = Ticket::getTicketById($db, $ticket_id);

if (!$ticket) {
    $response["status"] = "error";
    $response["message"] = "Ticket not found.";
    echo json_encode($response);
    exit;
}

// Check if the user has permission to access the ticket
if ($ticket->client_id !== $user->id && !Client::isAgent($db, $user->id)) {
    $response["status"] = "error";
    $response["message"] = "Access denied.";
    echo json_encode($response);
    exit;
}

// Perform actions based on ticket status and user role
if ($ticket->status == 'Closed') {
    // Reopen the closed ticket
    reopenTicket($db, $ticket_id, $user, $message, $response);
} else if (Client::isAgent($db, $user->id) && $ticket->status == 'Not Assigned') {
    // Assign the ticket to the agent and update its status
    assignTicket($db, $ticket_id, $user, $message, $response);
} else {
    // Create a new message for the ticket
    createMessage($db, $ticket_id, $user, $message, $response);
}

header('Content-Type: application/json');
echo json_encode($response);

// Function to reopen the closed ticket
function reopenTicket($db, $ticket_id, $user, $message, &$response) {
    $status = 'Open';
    $title = $ticket->title;

    if (Ticket::updateTicket($db, $ticket_id, $ticket->agent_id, $ticket->client_id, $ticket->department_id, $status, $title)) {
        if (createMessage($db, $ticket_id, $user, $message, $response)) {
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
}

// Function to assign the ticket to the agent
function assignTicket($db, $ticket_id, $user, $message, &$response) {
    $status = 'Open';
    $title = $ticket->title;

    if (Ticket::updateTicket($db, $ticket_id, $user->id, $ticket->client_id, $ticket->department_id, $status, $title)) {
        if (createMessage($db, $ticket_id, $user, $message, $response)) {
            $response["status"] = "success";
            $response["message"] = "Message sent, ticket updated, and assigned successfully.";
            $response["username"] = $user->username;
            $response["redirect"] = "../pages/message.php?id=";
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
}

// Function to create a new message for the ticket
function createMessage($db, $ticket_id, $user, $message, &$response) {
    $now = new DateTime('now', new DateTimeZone('Europe/Lisbon'));

    if (Message::createMessage($db, $ticket_id, $user->id, $message, $now)) {
        $response["status"] = "success";
        $response["message"] = "Message sent successfully.";
        $response["username"] = $user->username;
        $response["redirect"] = "../pages/message.php?id=" . $ticket_id;
        return true;
    } else {
        $response["status"] = "error";
        $response["message"] = "Message creation failed!";
        $response["redirect"] = "../pages/message.php?id=" . $ticket_id;
        return false;
    }
}
?>