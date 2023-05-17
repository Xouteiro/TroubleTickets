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
    <?php output_client_tickets($db, $session); ?>
  </section>
<?php }
?>


<?php
function output_client_tickets(PDO $db, Session $session)
{

  $user = Client::getClientById($db, $session->getId());
  $agent = Agent::getAgentByClientId($db, $user->id);

  $messages = Message::getMessages($db, 10);
  $message_to_use = new Message(0, 0, 0, '0', new DateTime());
  $OpenTickets = Ticket::getTicketsClientByStatus($db, $user->id, 'Open');
  $ClosedTickets = Ticket::getTicketsClientByStatus($db, $user->id, 'Closed');
  $OpenAgentTickets = Ticket::getTicketsAgentByStatus($db, $user->id, 'Open');
  $ClosedAgentTickets = Ticket::getTicketsAgentByStatus($db, $user->id, 'Closed');
  $UnassignedTickets = Ticket::getTicketsByStatus($db, 'Not Assigned');
  $UnassignedClientTickets = Ticket::getTicketsClientByStatus($db, $user->id, 'Not Assigned');

?>
  <h2>MyTickets</h2>
  <?php if (Client::isAgent($db, $user->id)) { ?>
    <div class='department'>
      <h3 data-agent-dep="<?php echo $agent->department_id; ?>"><?php echo '&nbsp;';
                                                                echo (Department::getDepartmentById($db, $agent->department_id)->name  ?? 'Administrator\'s') . ' Department' ?></h3>
    </div>
  <?php } ?>
  <h3>Open</h3>
  <div class='tickets-container'>
    <div class="tickets">
      <?php
      if (Client::isAgent($db, $user->id)) {
        $OpenTickets = $OpenAgentTickets;
      }

      foreach ($OpenTickets as $ticket) { ?>
        <a href="../pages/message.php?id=<?= urlencode(strval($ticket->id)) ?>" class='ticket'>
          <h4><?php echo $ticket->title //ticket title 
              ?> </h4>
          <h5><?php echo Department::getDepartmentById($db, $ticket->department_id)->name; ?></h5>
          <?php foreach ($messages as $message) {
            if ($message->ticket_id == $ticket->id) { ?>

              <p> <?php echo substr($message->message, 0, 200);
                  $message_to_use = $message; ?></p>
          <?php break;
            }
          } ?>
          <h6><?php echo  $message_to_use->date_created->format('d/m/Y H:i:s') ?></h6>
        </a>
      <?php

      }
      ?>

      <a href="../pages/newTicket.php" class='ticket'>
        <h4>New Ticket</h4>
        <h5>Need help?</h5>
        <p>Click here to solve your problem </p>
        <h6>24 hours 7 days a week</h6>
      </a>
      <button class="slide-button" id='left'><span id='left'></span></button>
      <button class="slide-button" id='right'><span id='right'></span></button>
    </div>
  </div>
  
  <h3>Solved</h3>

  <div class='tickets-container'>
    <div class="tickets">
      <?php
      if (Client::isAgent($db, $user->id)) {
        $ClosedTickets = $ClosedAgentTickets;
      }
      if (count($ClosedTickets) == 0) { //adicionar aqui opção de criar ticket
      ?>
        <p>No tickets here yet!</p>
      <?php
      }

      foreach ($ClosedTickets as $ticket) { ?>
        <a href="../pages/message.php?id=<?= urlencode(strval($ticket->id)) ?>" class='ticket'>
          <h4><?php echo $ticket->title ?> </h4>
          <h5><?php echo Department::getDepartmentById($db, $ticket->department_id)->name; ?></h5>
          <?php foreach ($messages as $message) {
            if ($message->ticket_id == $ticket->id) { ?>
              <p> <?php echo substr($message->message, 0, 200);
                  $message_to_use = $message; ?></p>
          <?php break;
            }
          } ?>
          <h6><?php echo  $message_to_use->date_created->format('d/m/Y H:i:s') ?></h6>
        </a>
      <?php

      }
      ?>
      <button class="slide-button" id='left'><span id='left'></span></button>
      <button class="slide-button" id='right'><span id='right'></span></button>
    </div>
  </div>
  <div class='full-line'>
    <h3>Unassigned</h3>
    <?php
    if (Client::isAgent($db, $user->id)) { ?>

      <input type="checkbox" id="show-department-tickets" name="show-department-tickets">
      <label class="show-department-tickets" for="show-department-tickets">
        <?php echo '&nbsp;' ?>Show only your department tickets
      </label>
    <?php } ?>
  </div>
  <div class='tickets-container'>
    <div class="tickets" id='unassigned-tickets' data-unassigned-tickets="<?php $UnassignedTickets; ?>">
      <?php
      if (!Client::isAgent($db, $user->id)) {
        $UnassignedTickets = $UnassignedClientTickets;
      }
      if (count($UnassignedTickets) == 0) { //adicionar aqui opção de criar ticket
      ?>
        <p>No tickets here yet!</p>
      <?php
      }
      foreach ($UnassignedTickets as $ticket) { ?>
        <a href="../pages/message.php?id=<?= urlencode(strval($ticket->id)) ?>" class='ticket'>
          <h4><?php echo $ticket->title ?> </h4>
          <h5 data-ticket-dep="<?php echo $ticket->department_id; ?>"><?php echo Department::getDepartmentById($db, $ticket->department_id)->name; ?></h5>
          <?php foreach ($messages as $message) {
            if ($message->ticket_id == $ticket->id) { ?>
              <p> <?php echo substr($message->message, 0, 50);
                  $message_to_use = $message; ?>...</p>
          <?php break;
            }
          } ?>
          <h6><?php echo  $message_to_use->date_created->format('d/m/Y H:i:s') ?></h6>
        </a>
      <?php

      }
      ?>
      <button class="slide-button" id='left'><span id='left'></span></button>
      <button class="slide-button" id='right'><span id='right'></span></button>
    </div>
  </div>

<?php
}
?>