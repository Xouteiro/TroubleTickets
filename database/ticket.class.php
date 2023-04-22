<?php

declare(strict_types=1);

class Ticket
{
    public int $id;
    public int $agent_id;
    public int $client_id;
    public int $department_id;
    public bool $status;
    public string $hashtag_id;

    public function __construct(int $id, int $agent_id, int $client_id, int $department_id, bool $status, string $hashtag_id)
    {
        $this->id = $id;
        $this->agent_id = $agent_id;
        $this->client_id = $client_id;
        $this->department_id = $department_id;
        $this->status = $status;
        $this->hashtag_id = $hashtag_id;
    }

    static function updateTicket(PDO $db, int $id, int $agent_id, int $client_id, int $department_id, bool $status, string $hashtag_id): bool
    {
        $stmt = $db->prepare('UPDATE TICKETS SET agent_id = ?, client_id = ?, department_id = ?, status = ?, hashtag_id = ? WHERE ticket_id = ?');
        try {
            $stmt->execute(array($agent_id, $client_id, $department_id, $status, $hashtag_id, $id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function getTickets(PDO $db, int $count): array
    {
        $stmt = $db->prepare('SELECT ticket_id, agent_id, client_id, department_id, status, hashtag_id FROM TICKETS LIMIT ?');
        $stmt->execute(array($count));

        $tickets = array();
        while ($ticket = $stmt->fetch()) {
            $tickets[] = new Ticket(
                $ticket['ticket_id'],
                $ticket['agent_id'],
                $ticket['client_id'],
                $ticket['department_id'],
                $ticket['status'],
                $ticket['hashtag_id']
            );
        }
        return $tickets;
    }

    static function getTicketById(PDO $db, int $id): ?Ticket
    {
        $stmt = $db->prepare('SELECT ticket_id, agent_id, client_id, department_id, status, hashtag_id FROM TICKETS WHERE ticket_id = ?');
        $stmt->execute(array($id));

        $ticket = $stmt->fetch();
        if ($ticket) {
            return new Ticket(
                intval($ticket['ticket_id']),
                $ticket['agent_id'],
                $ticket['client_id'],
                $ticket['department_id'],
                $ticket['status'],
                $ticket['hashtag_id']
            );
        } else {
            return null;
        }
    }

    static function newTicket(PDO $db, int $agent_id, int $client_id, int $department_id, bool $status, string $hashtag_id): bool
    {
        $stmt = $db->prepare('INSERT INTO TICKETS (agent_id, client_id, department_id, status, hashtag_id) VALUES (?, ?, ?, ?, ?)');
        try {
            $stmt->execute(array($agent_id, $client_id, $department_id, $status, $hashtag_id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>