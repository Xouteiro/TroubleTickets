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
  require_once(__DIR__ . '/../database/department.class.php');
  require_once(__DIR__ . '/../database/agent.class.php'); 



  $db = getDataBaseConnection();

 
  ?>
        <section id="client-tickets" class="client-tickets">
      <?php output_client_tickets($db,$session); ?>
         </section>
    <?php } 
    ?>


<?php
function output_client_tickets(PDO $db, Session $session)
{

  $client = Client::getClientById($db, $session->getId());
  $agent = Agent::getAgentByClientId($db,$client->id);

  $messages = Message::getMessages($db,10);
  $message_to_use = new Message(0,0,0,'0', new DateTime());

?>
  <h2>MyTickets</h2>
  <h3>Open</h3>
  <div class="open-tickets">
  <?php
  $OpenTickets = Ticket::getTicketsClientByStatus($db, $client->id, 'Open'); 
  $ClosedTickets = Ticket::getTicketsClientByStatus($db, $client->id, 'Closed');
  $UnassignedTickets = Ticket::getTicketsByStatus($db, 'Not Assigned');
  if (count($OpenTickets) == 0) { //adicionar aqui opção de criar ticket?>
    <p>No tickets here yet!</p>
  <?php
  }
  foreach ($OpenTickets as $ticket) { ?>
    <a href="../pages/message.php?id=<?=urlencode(strval($ticket->id))?>" class='ticket'>
        <h4><?php echo $ticket->title //ticket title ?>  </h4> 
        <?php foreach($messages as $message){
          if($message->ticket_id == $ticket->id){ ?>
           <p> <?php echo substr($message->message,0,200);
           $message_to_use = $message;?></p>
        <?php break; }
          }?>
        <h6><?php echo  $message_to_use->date_created->format('d/m/Y H:i:s')?></h6> 
    </a>
    <?php

}
  ?>
  </div>
  <h3>Solved</h3>
  <div class="solved-tickets">
  <?php
  if (count($ClosedTickets) == 0) { //adicionar aqui opção de criar ticket?>
    <p>No tickets here yet!</p>
  <?php
  }
  foreach ($ClosedTickets as $ticket) { ?>
    <a href="../pages/message.php?id=<?=urlencode(strval($ticket->id))?>" class='ticket'>
        <h4><?php echo $ticket->id //ticket title ?>  </h4> 
        <?php foreach($messages as $message){
          if($message->ticket_id == $ticket->id){ ?>
           <p> <?php echo substr($message->message,0,200);
           $message_to_use = $message;?></p>
        <?php break; }
          }?>
        <h6><?php echo  $message_to_use->date_created->format('d/m/Y H:i:s')?></h6> 
    </a>
    <?php
  
}
  ?>
  </div>
  <?php
  if(Client::isAgent($db,$client->id)){ ?>
  </div>
  <div class='full-line'><h3>Unassigned</h3><h3><?php echo '&nbsp;-&nbsp;'; echo Department::getDepartmentById($db,$agent->department_id)->name ?? 'Admin' ?></h3></div>

  <div class="unassigned-tickets">
  <?php
  if (count($UnassignedTickets) == 0) { //adicionar aqui opção de criar ticket?>
    <p>No tickets here yet!</p>
  <?php
  }
  foreach ($UnassignedTickets as $ticket) {?>
    <a href="../pages/message.php?id=<?=urlencode(strval($ticket->id))?>" class='ticket'>
        <h4><?php echo $ticket->title ?>  </h4> 
        <h5><?php echo Department::getDepartmentById($db,$ticket->department_id)->name;?></h5>
        <?php foreach($messages as $message){
          if($message->ticket_id == $ticket->id){ ?>
           <p> <?php echo substr($message->message,0,50);
           $message_to_use = $message;?>...</p>
        <?php break; }
          }?>
        <h6><?php echo  $message_to_use->date_created->format('d/m/Y H:i:s')?></h6> 
    </a>
    <?php
  
}
  ?>
  </div>
    

<?php  }

}
  ?>



