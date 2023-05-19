<?php

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/client.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/agent.class.php');

function output_edit(PDO $db, Session $session)
{
    // Check if the user is authenticated as an admin
    if (!Client::isAdmin($db, $session->getId())) {
        header('HTTP/1.1 403 Forbidden');
        exit('Access denied. You must be an admin to access this page.');
    }

    $client = Client::getClientById($db, $_GET['id']);

    // Fetch departments
    $departments = Department::getDepartments($db, 10);

    // Output the HTML for managing users
    ?>
    <section id="editer">
        <section id="client_editer">
            <h3>Edit Client Info</h3>

            <form action="../actions/action_edit_client.php" method="post">
                <input type="hidden" name="id" value="<?= $client->id ?>">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?= $client->username ?>">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= $client->email ?>">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="" placeholder="Change the password">
                <label>
                    <input type="radio" name="client_type" value="admin" <?php if (Client::isAdmin($db, $client->id)) {
                        echo "checked";
                    } ?>>
                    Admin
                </label>
                <label>
                    <input type="radio" name="client_type" value="agent" <?php if (Client::isAgent($db, $client->id) && !Client::isAdmin($db, $client->id)) {
                        echo "checked";
                    } ?>>
                    Agent
                </label>
                <label>
                    <input type="radio" name="client_type" value="regular" <?php if (!Client::isAdmin($db, $client->id) && !Client::isAgent($db, $client->id)) {
                        echo "checked";
                    } ?>>
                    Regular User
                </label>
                <?php if (Client::isAgent($db, $client->id)) {
                    $agent = Agent::getAgentByClientId($db, $client->id);
                    ?>
                    <label for="department">Department</label>
                    <select name="department" id="department">
                        <?php foreach ($departments as $department) { ?>
                            <option value="<?= $department->id ?>" <?php if ($agent->department_id == $department->id) {
                                  echo "selected";
                              } ?>>
                                <?= $department->name ?>
                            </option>
                        <?php } ?>
                    </select>
                <?php } ?>
                <button type="submit">Submit</button>
            </form>

            <form action="../actions/action_delete_client.php" method="post"
                onsubmit="return confirm('Are you sure you want to delete this user?');">
                <input type="hidden" name="id" value="<?= $client->id ?>">
                <button type="submit">Delete User</button>
            </form>
        </section>
    </section>
    <?php
}