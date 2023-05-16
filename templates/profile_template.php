<?php
require_once(__DIR__ . '/../database/connection.db.php');


function output_profile(PDO $db, Session $session)
{
    $client = Client::getClientById($db, $session->getId());

    ?>
    <section class="profile">
        <h3>Profile</h3>
        <img src="https://picsum.photos/200" alt="profile picture">
        <form action="../actions/action_edit_profile.php" method="post">
            <input type="hidden" name="id" value="<?= $client->id ?>">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?= $client->username ?>">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $client->email ?>">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="<?= $client->password ?>">
            <button type="submit">Submit</button>
    </section>

    <?php
}