<?php

declare(strict_types=1); ?>

<?php
function output_message(PDO $db, Ticket $ticket, Session $session)
{ ?>
<?php
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/client.class.php');
  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/messages.class.php');


  $client = Client::getClientById($db, $ticket->client_id);
  if($ticket->status != 'Not Assigned'){
  $agent = Client::getClientById($db,$ticket->agent_id);
  }
  $messages = Message::getMessages($db,10);
 
  ?>
  <section id='chat' class='chat'>
    <h2><?php echo $ticket->title ?> </h2>
    <?php 
    if($ticket->status=='Open'){?>
      <div class='full-line' id='green'> <h3>Status: </h3>
      <h3><?php echo $ticket->status?></h3>
      <span class="dot"></span>
      </div>
    <?php }
    if($ticket->status == 'Not Assigned'){?>
    <div class='full-line' id='yellow'> <h3>Status: </h3>
      <h3><?php echo $ticket->status  ?></h3>
      <span class="dot"></span>
      </div>
    <?php } 
    if($ticket->status == 'Closed'){?> 
    <div class='full-line' id='green'> <h3>Status: </h3>
      <h3><?php echo $ticket->status ?></h3>
      <span class="dot"></span>
      </div>
    <?php }?>
    
    <div class="messages">
      <div class="text">
    <?php 
    foreach($messages as $message){
      if($message->ticket_id == $ticket->id){
        if($message->client_id == $ticket->client_id){?>
          <div class='client-message'>
            <div class='full-line'><h4>Client:</h4><h4><?php echo '&nbsp;';echo $client->username //por Agent: a laranja?></h4></div>
            <p><?php echo $message->message?></p>
            <h5><?php echo $message->date_created->format('d/m/Y H:i:s')?></h5>
          </div>
        <?php } 
        if($ticket->status != 'Not Assigned'){
          if($message->client_id == $ticket->agent_id){?>
          <div class='agent-message'>
          <div class='full-line'><h4>Agent:</h4><h4><?php echo '&nbsp;'; echo $agent->username //por Agent: a laranja?></h4></div>
          <p><?php echo $message->message?></p>
          <h5><?php echo $message->date_created->format('d/m/Y H:i:s')?></h5>
        </div>

        <?php }
        } 
    }
  }
    
    ?>
      </div>
    <div class="message-input">
      <input type="text" placeholder="Enter your message">
    </div>
    </div>
    
    

    
  </section>
  



    <?php 
    }
    ?>

