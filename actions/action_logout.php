<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');

$session = new Session();
if (!$session->isLoggedIn()) die(header('Location: /'));

$session->logout();

header('Location: ' . '../pages/login.php');

?>