<?php


require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/client.class.php');


function output_admin(PDO $db, Session $session)
{
    // Check if the user is authenticated as an admin
    if (!Client::isAdmin($db, $session->getId())) {
        header('HTTP/1.1 403 Forbidden');
        exit('Access denied. You must be an admin to access this page.');
    }
    $clients = Client::getOnlyClients($db, 20);
    $agents = Client::getOnlyAgents($db, 20);
    $admins = Client::getOnlyAdmins($db, 20);

    // Output the HTML for managing users
    ?>

    <section id="user_manager">
        <section id="client_manager">
            <h3>Manage Clients</h3>

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
                                <a href="edit.php?id=<?= $client->id ?>">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section id="agent_manager">
            <h3>Manage Agents</h3>

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
                                <a href="edit.php?id=<?= $agent->id ?>">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section id="admin_manager">
            <h3>Manage Admins</h3>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td>
                                <?= $admin->username ?>
                            </td>
                            <td>
                                <?= $admin->email ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $admin->id ?>">Edit</a>
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