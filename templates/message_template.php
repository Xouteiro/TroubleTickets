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
    <h3>Status: <?php echo $ticket->status //mudar a cor do Open para verde  ?></h3>
    <div class="messages">
      <div class="text">
    <?php 
    foreach($messages as $message){
      if($message->ticket_id == $ticket->id){
        if($message->client_id == $ticket->client_id){?>
          <div class='client-message'>
            <h4>Client: <?php echo $client->username //por Agent: a laranja?></h4>
            <p><?php echo $message->message?></p>
            <h5><?php echo $message->date_created->format('d/m/Y H:i:s')?></h5>
          </div>
        <?php } 
        if($ticket->status != 'Not Assigned'){
          if($message->client_id == $ticket->agent_id){?>
          <div class='agent-message'>
          <h4>Agent: <?php echo $agent->username //por Agent: a laranja?></h4>
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

