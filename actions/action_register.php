<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../utils/security.php');

    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $session = new Session();
    


if (!valid_input_list(array(
    $_POST["email"],
    $_POST["username"],
    $_POST["password"],
    $_POST["confirm_password"],
))) {
    $session->addMessage('error', 'Invalid input!');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
}

$db = getDatabaseConnection();
$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

if (empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
    $session->addMessage('error', 'You have to fill in all fields.');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
} else if (User::emailInUse($db, $email)) {
    $session->addMessage('error', 'Email already in use');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
} else if ($confirm_password != $password) {
    $session->addMessage('error', "Passwords don't match");
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
} else if (User::newUser($db, $username, $email, $password)) {
    $session->addMessage('success', 'Register successfull!');
    die(header('Location: ../pages/login.php'));
}