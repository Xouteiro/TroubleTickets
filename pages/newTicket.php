<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/normal.php');
require_once(__DIR__ . '/../templates/new_ticket_template.php');


$session = new Session();

$db = getDatabaseConnection();


output_header($session);
output_new_ticket_page($session);

foreach ($session->getMessages() as $message) {
    echo '<div class="' . $message['type'] . '">' . $message['text'] . '</div>';
}


output_footer();
?>