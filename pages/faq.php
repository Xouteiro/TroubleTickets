<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/normal.php');
require_once(__DIR__ . '/../templates/faq_template.php');


$session = new Session();

$db = getDatabaseConnection();


output_header($session);
output_faq_page($session);

output_footer();
?>