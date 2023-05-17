<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/client.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/agent.class.php');

$db = getDataBaseConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    Client::updateUser($db, $username, $password, $email, $id);

    header('Location: ../pages/profile.php?id=' . $id . '&success=1');
    exit();
}


?>