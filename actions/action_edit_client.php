<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/client.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/agent.class.php');

$db = getDataBaseConnection();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $clientType = $_POST['client_type'];

    // Update the client information in the database
    Client::updateUser($db, $username, $password, $email, $id);

    // Update the client type in the database
    if ($clientType === 'admin' && !Client::isAdmin($db, $id)) {
        Client::giveAdmin($db, $id);
    } elseif ($clientType === 'agent' && !Client::isAgent($db, $id)) {
        Client::giveAgent($db, $id);
    } elseif ($clientType === 'regular') {
        Client::RemoveAgentAndAdmin($db, $id);
    }

    // If the client is an agent, update the department
    if (Client::isAgent($db, $id)) {
        $departmentId = $_POST['department'];
        $agent = Agent::getAgentByClientId($db, $id);
        if ($departmentId == null) {
            $departmentId = 1;
        }
        $agent->department_id = $departmentId;
        //Update Agent
        Agent::updateAgent($db, $agent->agent_id, $agent->department_id);
    }

    // Redirect to the client edit page with a success message
    header('Location: ../pages/admin.php?id=' . $id . '&success=1');
    exit();
}

?>