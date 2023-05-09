<?php

declare(strict_types=1); ?>

<?php
function output_header(Session $session)
{ ?>
  <?php
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/client.class.php');

  if ($session->isLoggedIn()) {
    $db = getDataBaseConnection();
    $client = Client::getClientById($db, $session->getId());
  }
  ?>
  <!DOCTYPE html>
  <html lang="en-US">

  <head>
    <title>TroubleTickets</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/text.css" rel="stylesheet">
    <link href="../css/layout.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">
    <script src="../js/script.js" defer></script>
  </head>

  <body>
    <header>
      <h1><a href="../pages/index.php">Trouble</a><a href="../pages/index.php">Tickets</a></h1>
    </header>

    <input type="checkbox" id="sidebar">
    <label class="sidebar" for="sidebar"></label>
    <?php
    if ($session->isLoggedIn()) { ?>
      <div class="username">
        <img src="https://picsum.photos/200" alt="profile photo">
        <h3>
          <?php echo $client->username ?>
        </h3>
      </div>
    <?php } else { ?>
      <div class="filler"></div>
    <?php } ?>

    <nav id="menu">
      <ul>
        <?php
        if ($session->isLoggedIn()) { ?>
          <li><a href="../pages/newTicket.php">New</a><a href="../pages/newTicket.php">Ticket</a></li>
        <?php } else { ?>
          <li><a href="../pages/newTicket.php">New</a><a href="../pages/newTicket.php">Ticket</a></li>
        <?php } ?>
        <?php
        if ($session->isLoggedIn()) { ?>
          <li><a href="../pages/tickets_client.php">My</a><a href="../pages/tickets_client.php">Tickets</a></li>
          <?php if (Client::isAdmin($db, $session->getId())) { ?>
            <li><a href="../pages/admin.php">Admin</a><a href="../pages/admin.php">Page</a></li>
          <?php }
          ?>
          <li><a href="../pages/faq.php">FAQ</a></li>
        <?php } else { ?>
          <li><a href="../pages/faq.php">FAQ</a></li>
        <?php }
        ?>
        <?php
        if ($session->isLoggedIn()) { ?>
          <form action="../actions/action_logout.php" method="post" id="logout">
            <button id="logout-button" class="logout">Logout</button>
          </form>
        <?php } else { ?>
          <form action="../pages/login.php" method="post" id="login">
            <button id="login-button" class="logout">Login</button>
          </form>
        <?php }
        ?>
      </ul>

    </nav>

  <?php } ?>

  <?php
  function output_footer()
  { ?>
    <footer>
      <p>&copy; TroubleTickets, 2023</p>
    </footer>
  </body>

  </html>

<?php } ?>