<?php declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');

require_once(__DIR__ . '/../templates/normal.php');
require_once(__DIR__ . '/../templates/tickets.php');


$session = new Session();


output_header($session);
output_yourtickets_page($session);
output_footer();


?>