<?php

declare(strict_types=1); ?>

<?php
function output_yourtickets_page(Session $session)
{ ?>
<?php
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/client.class.php');
  require_once(__DIR__ . '/../database/ticket.class.php');


  $db = getDataBaseConnection();
  $client = Client::getClientById($db, $session->getId());
 
  ?>

      <?php if ($client->isAdmin($db,$session->getId())) {//mudar para is Agent e mudar funcao de output ?>
        <section id="client-tickets" class="client-tickets">
      <?php output_client_tickets($db); ?>
         </section>
      <?php } else if($client->isAdmin($db,$session->getId()))  { //mudar para is Agent e mudar funcao de output?>
        <section id="client-tickets" class="client-tickets">
      <?php output_client_tickets($db); ?>
         </section>
      <?php } else { ?>
        <section id="client-tickets" class="client-tickets">
      <?php output_client_tickets($db); ?>
         </section>
    <?php } 
    }
    ?>


<?php
function output_client_tickets(PDO $db)//deve ser preciso o session quando se filtrar por cliente
{

?>
  <h2>MyTickets</h2>
  <h3>Open</h3>
  <div class="open-tickets">
  <?php
  $tickets = Ticket::getTickets($db, 10); ////é preciso uma função que dê os tickets por id de client e ccom o status
  if (count($tickets) == 0) { //adicionar aqui opção de criar ticket?>
    <p>No tickets here yet!</p>
  <?php
  }
  foreach ($tickets as $ticket) { ?>
    <section class="ticket">
        <p><?php echo $ticket->id ?></p>
        <p>a little bit of the ticket message<p>
    </section>
    <?php
  }
  ?>
  </div>
  <h3>Solved</h3>
  <div class="solved-tickets">
  <?php
  $tickets = Ticket::getTickets($db, 10); ////é preciso uma função que dê os tickets por id de client e ccom o status
  if (count($tickets) == 0) { //adicionar aqui opção de criar ticket?>
    <p>No tickets here yet!</p>
  <?php
  }
  foreach ($tickets as $ticket) { ?>
    <section class="ticket">
        <h4><?php echo $ticket->id ?></h4>
        <p>a little bit of the ticket message<p>
    </section>
    <?php
  }?>
  </div>
<?php
}
  ?>



