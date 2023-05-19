<?php
require_once(__DIR__ . '/../database/connection.db.php');


function output_profile(PDO $db, Session $session)
{
    $client = Client::getClientById($db, $session->getId());

    ?>
    <section class="profile-page">
    <h2>Edit Your Profile</h2>
    <section class="profile">

        <form action="../actions/action_edit_profile.php" method="post">
            <input type="hidden" name="id" value="<?= $client->id ?>">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?= $client->username ?>">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $client->email ?>">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value='' placeholder="Change your password here">
            <button type="submit">Submit</button>
    </section>
    </section>
    <?php
}