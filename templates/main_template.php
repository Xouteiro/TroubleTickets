<?php

declare(strict_types=1); ?>

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

    $recentTickets = Ticket::getTickets($db, 10);
    $messages = Message::getMessages($db, 10);
    $message_to_use = new Message(0, 0, 0, '0', new DateTime());


    ?>
    <section id='main-page' class='main-page'>

        <h3>How TroubleTickets works</h3>
        <div class='steps'>
            <div class='step'>
            <img src='/images/ticket.png'  alt='ticket image'>
                <p>1st - Open a ticket with a description of your problem</p>
            </div>
            <span class='arrow'></span>
            <div class='step'>
                <img src='/images/agent.png' alt='assigned image'>
                <p>2nd - Your ticket will be assigned to one of our agents</p>
            </div>
            <span class='arrow'></span>
            <div class='step'>
                <img src='/images/chat.png' alt='chat image'>
                <p>3rd - Talk to our agent until your problem is solved</p>
            </div>
        </div>
</div>



        <h3>Most Recent Tickets</h3>
        <div class="tickets">
            <?php
            foreach ($recentTickets as $ticket) { ?>
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
            <?php } ?>
        </div>
        <article class='faq'>
            <h3>See if your problem already has a solution</h3>
            <a href='../pages/faq.php'>Take a look at our Frequently Asked Questions</a>
        </article>
    </section>


<?php
}
?>