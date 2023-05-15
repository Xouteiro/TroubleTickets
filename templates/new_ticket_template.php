<?php

declare(strict_types=1); ?>

<?php
function output_new_ticket_page(Session $session)
{
    require_once(__DIR__ . '/../database/department.class.php');
    $db = getDataBaseConnection();
    $departments = Department::getDepartments($db,100);


?>
    <section id='new-ticket-form' class='new-ticket-form'>
    <h2>New Ticket</h2>
    <form id="new-ticket" action="../actions/action_create_ticket.php" method="post">
    <label for="department">Department:</label>
    <select id="departments" name="departments">
        <?php foreach($departments as $department){?>
            <option value="<?php echo $department->name?>"><?php echo $department->name?></option>
       <?php } 
        ?>
    </select>
    <label for="ticket-title">Title:</label>
    <input type="text" id="title" name="title" placeholder="Small description of the problem">
    <label for="ticket-message">Message:</label>
    <textarea id="message" name="message" placeholder="Detailed description of the problem" rows="10" cols="30"></textarea>
    <button type="submit" name="submit" class="ticket">Create Ticket</button>
    </section>
    </form>

<?php
}
?>