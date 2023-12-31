<?php
function output_main_page(Session $session)
{ ?>
    <?php
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/client.class.php');
    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/messages.class.php');
    require_once(__DIR__ . '/../database/department.class.php');
    require_once(__DIR__ . '/../database/agent.class.php');



    $db = getDataBaseConnection();

    $recentTickets = Ticket::getTickets($db, 200);
    $messages = Message::getMessages($db, 200);
    $message_to_use = new Message(0, 0, 0, '0', new DateTime());


    ?>
    <section id='main-page' class='main-page'>

        <div class='steps'>
            <div class='step active'>
                <?php if ($session->isLoggedIn()) { ?>
                    <a href='/pages/login.php'>
                    <?php } else { ?>
                        <a href='/pages/newTicket.php'>
                        <?php } ?>
                        <img src='/images/ticket.png' alt='ticket image'></a>
                        <p>Open a ticket with a description of your problem</p>
            </div>
            <span class='arrow'></span>
            <div class='step'>
                <img src='/images/agent.png' alt='assigned image'>
                <p>Your ticket will be assigned to one of our agents</p>
            </div>
            <span class='arrow'></span>
            <div class='step'>
                <img src='/images/chat.png' alt='chat image'>
                <p>Talk to our agent until your problem is solved</p>
            </div>
        </div>
        <div class='tickets-container'>
            <div class="tickets">
                <?php
                foreach ($recentTickets as $ticket) { ?>
                    <a href="../pages/message.php?id=<?= urlencode(strval($ticket->id)) ?>" class='ticket'>
                        <h4>
                            <?php echo $ticket->title //ticket title 
                            ?>
                        </h4>
                        <h5>
                            <?php echo Department::getDepartmentById($db, $ticket->department_id)->name; ?>
                        </h5>
                        <?php foreach ($messages as $message) {
                            if ($message->ticket_id == $ticket->id) { ?>

                                <p>
                                    <?php echo substr($message->message, 0, 200);
                                    $message_to_use = $message; ?>
                                </p>
                        <?php break;
                            }
                        } ?>
                        <h6>
                            <?php echo $message_to_use->date_created->format('d/m/Y H:i:s') ?>
                        </h6>
                    </a>
                <?php } ?>

                <button class="slide-button left"><span class='left'></span></button>
                <button class="slide-button right"><span class='right'></span></button>
            </div>

        </div>

        <div class='faq'>

            <a href='../pages/faq.php'><img src='/images/faq.png' alt='ticket image'></a>
            <a href='../pages/faq.php'>See if your question has already been answered in our FAQ</a>

        </div>



    </section>


<?php
}
?>