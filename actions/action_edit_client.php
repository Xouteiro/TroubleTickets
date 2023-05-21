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
    $clientType = $_POST['client_type'];

   Client::updateUser($db, $username, $password, $email, $id);

    if ($clientType === 'admin' && !Client::isAdmin($db, $id)) {
        Client::giveAdmin($db, $id);
    } elseif ($clientType === 'agent' && !Client::isAgent($db, $id)) {
        Client::giveAgent($db, $id);
    } elseif ($clientType === 'regular') {
        Client::RemoveAgentAndAdmin($db, $id);
    }
    if (Client::isAgent($db, $id)) {
        $departmentId = $_POST['department'];
        $agent = Agent::getAgentByClientId($db, $id);
        if ($departmentId == null) {
            $departmentId = 1;
        }
        $agent->department_id = $departmentId;
        Agent::updateAgent($db, $agent->agent_id, $agent->department_id);
    }
    header('Location: ../pages/admin.php?id=' . $id . '&success=1');
    exit();
}

?>