<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');

require_once(__DIR__ . '/../database/client.class.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/department.class.php');


$session = new Session();
$db = getDataBaseConnection();


Ticket::deleteTicket($db,5);

