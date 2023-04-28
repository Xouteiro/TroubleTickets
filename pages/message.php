<?php declare(strict_types = 1); ?>

<?php
  require_once(__DIR__ . '/../utils/session.php');

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/messages.class.php');
  require_once(__DIR__ . '/../database/client.class.php');

  require_once(__DIR__ . '/../templates/normal.php');
  require_once(__DIR__ . '/../templates/message_template.php');


  $session = new Session();

  $db = getDatabaseConnection();

  $id = $_GET['id'];
  $ticket = Ticket::getTicketById($db, intval($id));

  output_header($session);
  output_message($db, $ticket, $session); 
  output_footer();
?>