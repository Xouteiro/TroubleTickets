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
  require_once(__DIR__ . '/../database/department.class.php');
  require_once(__DIR__ . '/../database/hashtag.class.php');


  $user = Client::getClientById($db, $session->getId());
  $client = Client::getClientById($db, $ticket->client_id);
  if ($ticket->status != 'Not Assigned') {
    $agent = Client::getClientById($db, $ticket->agent_id);
  }
  $messages = Message::getMessages($db, 100);
  $hashtags = Hashtag::getTicketHashtags($db, $ticket->id);

  ?>
  <section id='chat' class='chat'>
    <?php
    if (!Client::isAgent($db, $user->id)) { ?>
      <h2><?php echo $ticket->title ?> </h2>
    <?php }
    if (Client::isAgent($db, $user->id)) { ?>
      <div class='full-line'>
        <h2><?php echo $ticket->title . ' -&nbsp;' ?> </h2>
        <div class='change-status' id='department'>
          <form action="../actions/action_change_department.php" method="post">
            <input type="hidden" name="ticket_id" value="<?php echo $ticket->id ?>">
            <select name="department_id" id="department_id">
              <option value="<?php echo $ticket->department_id ?>"><?php echo Department::getDepartmentById($db, $ticket->department_id)->name ?></option>
              <?php
              $departments = Department::getDepartments($db, 50);
              foreach ($departments as $department) {
                if ($ticket->department_id != $department->id) { ?>
                  <option value="<?php echo $department->id ?>"><?php echo $department->name ?></option>
              <?php }
              } ?>
            </select>
            <input type="submit" value="Change department">
          </form>
        </div>
      </div>
    <?php } ?>

    <?php
    if ($ticket->status == 'Open') { ?>
      <div class='full-line' id='red'>
        <h3>Status: </h3>
        <h3 data-ticketid='<?php echo $ticket->id ?>'><?php echo $ticket->status ?></h3>
        <span class="dot"></span>
        <div class='hashtags'>      
            <input type="text" id="new-hashtag" name="new-hashtag" placeholder="Type #">
            <button type="submit" name="submit" id="add-hashtag">Add Hashtag</button>

          <?php foreach ($hashtags as $hashtag) { ?>
            <input type="button" class="remove-hashtag" data-name="<?php echo $hashtag->hashtag_id ?>" value='<?php echo $hashtag->hashtag_name . ' &#10006;' ?>'></input>
          <?php } ?>
        </div>
        <div class='change-status'>
          <form action="../actions/action_close_ticket.php" method="post">
            <input type="hidden" name="ticket_id" value="<?php echo $ticket->id ?>">
            <input type="submit" value="Close Ticket">
          </form>
        </div>
      </div>
    <?php }
    if ($ticket->status == 'Not Assigned') { ?>
      <div class='full-line' id='yellow'>
        <h3>Status: </h3>
        <h3 data-ticketid='<?php echo $ticket->id ?>'><?php echo $ticket->status ?></h3>
        <span class="dot"></span>
        <div class='hashtags'>      
            <input type="text" id="new-hashtag" name="new-hashtag" placeholder="Type #">
            <button type="submit" name="submit" id="add-hashtag">Add Hashtag</button>

          <?php foreach ($hashtags as $hashtag) { ?>
            <input type="button" class="remove-hashtag" data-name="<?php echo $hashtag->hashtag_id ?>" value='<?php echo $hashtag->hashtag_name . ' &#10006;' ?>'></input>
          <?php } ?>
        </div>
        <?php if (Client::isAgent($db, $user->id) && $ticket->status == 'Not Assigned') { ?>
          <div class='change-status'>
            <form action="../actions/action_assing_agent.php" method="post">
              <input type="hidden" name="ticket_id" value="<?php echo $ticket->id ?>">
              <select name="agent_id" id="agent_id">
                <option value="0">Select Agent</option>
                <option value="<?php echo $user->id ?>"><?php echo $user->username ?></option>
                <?php
                $agents = Client::getClients($db);
                foreach ($agents as $agent) { ?>
                  <?php if (Client::isAgent($db, $agent->id) && $user->id != $agent->id) { ?>
                    <option value="<?php echo $agent->id ?>"><?php echo $agent->username ?></option>
                <?php }
                } ?>
              </select>
              <input type="submit" value="Assign Agent">
            </form>
          </div>
        <?php } ?>
      </div>
    <?php }
    if ($ticket->status == 'Closed') { ?>
      <div class='full-line' id='green'>
        <h3>Status: </h3>
        <h3 data-ticketid='<?php echo $ticket->id ?>'><?php echo $ticket->status ?></h3>
        <span class="dot"></span>
        <div class='hashtags'>      
            <input type="text" id="new-hashtag" name="new-hashtag" autocomplete='on' placeholder="Type #">
            <button type="submit" name="submit" id="add-hashtag">Add Hashtag</button>

          <?php foreach ($hashtags as $hashtag) { ?>
            <input type="button" class="remove-hashtag" data-name="<?php echo $hashtag->hashtag_id ?>" value='<?php echo $hashtag->hashtag_name . ' &#10006;' ?>'></input>
          <?php } ?>
        </div>
        <div class='change-status  '>
          <form action="../actions/action_reopen_ticket.php" method="post">
            <input type="hidden" name="ticket_id" value="<?php echo $ticket->id ?>">
            <input type="submit" value="Reopen this ticket">
          </form>
        </div>
      </div>
    <?php } ?>


    <div class="messages">
      <div class="text">
        <?php
        foreach ($messages as $message) {
          if ($message->ticket_id == $ticket->id) {
            if ($message->client_id == $ticket->client_id) { ?>
              <div class='client-message'>
                <div class='full-line'>
                  <h4>Client:</h4>
                  <h4><?php echo '&nbsp;';
                      echo $client->username
                      ?></h4>
                </div>
                <p><?php echo $message->message ?></p>
                <h5><?php echo $message->date_created->format('d/m/Y H:i:s') ?></h5>
              </div>
              <?php }
            if ($ticket->status != 'Not Assigned') {
              if ($message->client_id == $ticket->agent_id) { ?>
                <div class='agent-message'>
                  <div class='full-line'>
                    <h4>Agent:</h4>
                    <h4><?php echo '&nbsp;';
                        echo $agent->username
                        ?></h4>
                  </div>
                  <p><?php echo $message->message ?></p>
                  <h5><?php echo $message->date_created->format('d/m/Y H:i:s') ?></h5>
                </div>

        <?php }
            }
          }
        }

        ?>
      </div>

      <div class="message-input">
        <form action="../actions/action_send_message.php" method="post">
          <input type="hidden" name="ticket_id" value="<?php echo $ticket->id ?>">
          <input type="hidden" name="user_id" value="<?php echo $user->id ?>">
          <input type="text" name="message" id="message" placeholder="Enter your message here">
          <input type="submit" id='send' value="Send">
        </form>
      </div>

    </div>




  </section>




<?php
}
?>