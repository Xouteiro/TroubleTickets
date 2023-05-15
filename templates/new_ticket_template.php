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
    <h2 style="color: white;">Create your ticket</h2>
    <form id="new-ticket" action="../actions/action_create_ticket.php" method="post">
    <label for="departments" style="color: white;">Department:</label>
    <select id="departments" name="departments" class="selectdepartment">
        <?php foreach($departments as $department){?>
            <option value="<?php echo $department->name?>"><?php echo $department->name?></option>
       <?php } 
        ?>
    </select>
    <label for="ticket-title" style="color: white;">Title:</label>
    <input type="text" id="ticket-title" name="ticket-title" placeholder="Small description of the problem (Max: 30 characters)" class="input-ticket-title">
    <label for="ticket-message" style="color: white;">Message:</label>
    <textarea id="ticket-message" name="ticket-message" placeholder="Detailed description of the problem." rows="10" cols="30" class="textarea-ticket-message"></textarea>
    <button type="submit" name="submit" class="button-create-ticket">Create Ticket</button>
    </form>
    </section>
    

<?php
}
?>
