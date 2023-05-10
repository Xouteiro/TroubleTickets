<?php

declare(strict_types=1); ?>

<?php
function output_yourtickets_page(Session $session)
{ ?>
<?php
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/client.class.php');
  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/messages.class.php');



  $db = getDataBaseConnection();
  $client = Client::getClientById($db, $session->getId());
 
  ?>

      <?php if ($client->isAdmin($db,$session->getId())) {//mudar para is Agent e mudar funcao de output ?>
        <section id="client-tickets" class="client-tickets">
      <?php output_client_tickets($db,$session); ?>
         </section>
      <?php } else if($client->isAdmin($db,$session->getId()))  { //mudar para is Agent e mudar funcao de output?>
        <section id="client-tickets" class="client-tickets">
      <?php output_client_tickets($db,$session); ?>
         </section>
      <?php } else { ?>
        <section id="client-tickets" class="client-tickets">
      <?php output_client_tickets($db,$session); ?>
         </section>
    <?php } 
    }
    ?>


<?php
function output_client_tickets(PDO $db, Session $session)
{

  $client = Client::getClientById($db, $session->getId());
  $messages = Message::getMessages($db,10);
  $message_to_use = new Message(0,0,0,'0', new DateTime());

?>
  <h2>MyTickets</h2>
  <h3>Open</h3>
  <div class="open-tickets">
  <?php
  $tickets = Ticket::getTicketsClient($db, $client->id, 5); 
  if (count($tickets) == 0) { //adicionar aqui opção de criar ticket?>
    <p>No tickets here yet!</p>
  <?php
  }
  foreach ($tickets as $ticket) {
    if($ticket->status == 'Open') { ?>
    <a href="../pages/message.php?id=<?=urlencode(strval($ticket->id))?>" class='ticket'>
        <h4>Ticket #<?php echo $ticket->id //ticket title ?>  </h4> 
        <?php foreach($messages as $message){
          if($message->ticket_id == $ticket->id){ ?>
           <p> <?php echo substr($message->message,0,200);
           $message_to_use = $message;?></p>
        <?php break; }
          }?>
        <h5><?php echo  $message_to_use->date_created->format('d/m/Y H:i:s')?></h5> 
    </a>
    <?php
  }
}
  ?>
  </div>
  <h3>Solved</h3>
  <div class="solved-tickets">
  <?php
  $tickets = Ticket::getTicketsClient($db, $client->id, 5); 
  if (count($tickets) == 0) { //adicionar aqui opção de criar ticket?>
    <p>No tickets here yet!</p>
  <?php
  }
  foreach ($tickets as $ticket) {
    if($ticket->status == 'Closed') { ?>
    <a href="../pages/message.php?id=<?=urlencode(strval($ticket->id))?>" class='ticket'>
        <h4>Ticket #<?php echo $ticket->id //ticket title ?>  </h4> 
        <?php foreach($messages as $message){
          if($message->ticket_id == $ticket->id){ ?>
           <p> <?php echo substr($message->message,0,200);
           $message_to_use = $message;?></p>
        <?php break; }
          }?>
        <h5><?php echo  $message_to_use->date_created->format('d/m/Y H:i:s')?></h5> 
    </a>
    <?php
  }
}
  ?>
  </div>
<?php
}
  ?>



