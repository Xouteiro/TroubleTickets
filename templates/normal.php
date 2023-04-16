<?php

declare(strict_types=1); ?>

<?php
function output_header(Session $session)
{ ?>
  <!DOCTYPE html>
  <html lang="en-US">

  <head>
    <title>TroubleTickets</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/text.css" rel="stylesheet">
    <link href="../css/layout.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">
    <script src="../js/script.js" defer></script>
  </head>

  <body>
    <header>
      <h1><a href="../pages/index.php">TroubleTickets</a></h1>
      <nav id="menu">
      <input type="checkbox" id="sidebar"> 
      <label class="sidebar" for="sidebar"></label>
      <?php
        if ($session->isLoggedIn()) { ?>
          <li><a href="../pages/newTicket.php">New Ticket</a></li>
          <?php } else { ?>
            <li><a href="../pages/login.php">New Ticket</a></li>
            <?php } ?>
            <?php
            if ($session->isLoggedIn()) { ?>
              <li><a href="../pages/tickets.php">Tickets</a></li>
              <li><a href="../pages/profile.php">
                <i class="material-icons icon-4x">account_circle</i>
              </a></li>
            <?php } else { ?>
              <li><a href="../pages/login.php">
                <i class="material-icons icon-4x">account_circle</i>
              </a></li>
            <?php }
            ?>
      <ul>
      </ul>
    </nav>
    </header>
    

  <?php } ?>

  <?php
  function output_footer()
  { ?>
    <div id="footer-prev"></div>
    <footer>
      <p>&copy; TroubleTickets, 2023</p>
    </footer>
  </body>

  </html>

<?php } ?>