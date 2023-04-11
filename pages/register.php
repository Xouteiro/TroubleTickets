<?php declare(strict_types = 1); 

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../utils/security.php');
  
  require_once(__DIR__ . '/../templates/normal.php');
  require_once(__DIR__ . '/../templates/account.php');
  

  $session = new Session();
  

  output_header($session);
  if (isset($_SESSION['id'])) { 
    header('Location: ../pages/profile.php');
  }
  else { 
    output_register($session);
  }
  output_footer();

?>