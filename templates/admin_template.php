<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/client.class.php');


function output_admin(PDO $db, Session $session)
{
    // Check if the user is authenticated as an admin
    if (!Client::isAdmin($db, $session->getId())) {
        header('HTTP/1.1 403 Forbidden');
        exit('Access denied. You must be an admin to access this page.');
    }
    $clients = Client::getClients($db, 10);
    $agents = Client::getAgents($db, 10);

    // Output the HTML for managing users
    ?>
    <section id="user_manager">
        <section id="client_manager">
            <h2>Manage Clients</h2>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td>
                                <?= $client->username ?>
                            </td>
                            <td>
                                <?= $client->email ?>
                            </td>
                            <td>
                                <a href="edit_client.php?id=<?= $client->id ?>">Edit</a>
                                <a href="action_delete_client.php?id=<?= $client->id ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section id="agent_manager">
            <h2>Manage Agents</h2>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agents as $agent): ?>
                        <tr>
                            <td>
                                <?= $agent->username ?>
                            </td>
                            <td>
                                <?= $agent->email ?>
                            </td>
                            <td>
                                <a href="edit_agent.php?id=<?= $agent->id ?>">Edit</a>
                                <a href="delete_agent.php?id=<?= $agent->id ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </section>
    <?php
}



?>