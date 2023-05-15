<?php

class Agent
{
    public int $agent_id;
    public int $client_id;
    public int $department_id;

    public function __construct(int $agent_id, int $client_id, int $department_id)
    {
        $this->agent_id = $agent_id;
        $this->client_id = $client_id;
        $this->department_id = $department_id;
    }

    static function getAgentByClientId(PDO $db, int $id): ?Agent
    {
        $stmt = $db->prepare(
            'SELECT agent_id, client_id, department_id FROM  AGENTS WHERE client_id = ?'
        );
        $stmt->execute(array($id));

        $user = $stmt->fetch();
        if ($user) {
            return new Agent(
                intval($user['agent_id']),
                intval($user['client_id']),
                intval($user['department_id'])
            );
        } else {
            return null;
        }
    }

    static function updateAgent(PDO $db, int $id, int $departmentId): void
    {
        $stmt = $db->prepare(
            'UPDATE AGENTS SET department_id = ? WHERE client_id = ?'
        );
        $stmt->execute(array($departmentId, $id));
    }

}
?>