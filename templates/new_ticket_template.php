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
    <select id="departments" name="departments" style="color: white; background-color: #CFCFCF; border-radius: 5px; border-color: #CFCFCF; width:657px; height: 30px;">
        <?php foreach($departments as $department){?>
            <option value="<?php echo $department->name?>"><?php echo $department->name?></option>
       <?php } 
        ?>
    </select>
    <label for="ticket-title" style="color: white;">Title:</label>
    <input type="text" id="ticket-title" name="ticket-title" placeholder="Small description of the problem (Max: 30 characters)" style="color: white; background-color: #CFCFCF; border-radius: 5px; border-color: #CFCFCF; width: 650px; height: 30px;">
    <label for="ticket-message" style="color: white;">Message:</label>
    <textarea id="ticket-message" name="ticket-message" placeholder="Detailed description of the problem." rows="10" cols="30" style="color: white; background-color: #CFCFCF; border-radius: 5px; border-color: #CFCFCF; width: 650px; height: 150px;"></textarea>
    <button type="submit" name="submit" class="ticket" style="color: white; background-color: #F47458; border-radius: 5px; border-color: #F47458; width: 657px; height: 30px; margin-top: 10px;">Create Ticket</button>
    </form>
    </section>

<?php
}
?>
