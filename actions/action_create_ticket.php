<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');

require_once(__DIR__ . '/../database/client.class.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../actions/action_create_ticket.php');

$session = new Session();





$db = getDatabaseConnection();
$department = $_POST["departments"];
$title = $_POST["title"];
$message = $_POST["message"];

$departmentObj = Department::getDepartmentByName($db, $department);


if (empty($_POST['departments']) || empty($_POST['title']) || empty($_POST['message']) ) {
    $session->addMessage('error', 'All fields must be filled');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    if (Ticket::createTicket($db, $session->getId(), $departmentObj->id,'Not Assigned', $title)) {
        $session->addMessage('success', 'Ticket created with success!');
        header('Location: ../pages/tickets_client.php');
    } else {
        $session->addMessage('error', 'Ticket creation failed!');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}


