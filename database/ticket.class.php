<?php

class Ticket
{
    public int $id;
    public int $agent_id;
    public int $client_id;
    public int $department_id;
    public string $status;
    public string $title;

    public function __construct(int $id, int $agent_id, int $client_id, int $department_id, string $status, string $title)
    {
        $this->id = $id;
        $this->agent_id = $agent_id;
        $this->client_id = $client_id;
        $this->department_id = $department_id;
        $this->status = $status;
        $this->title = $title;
    }

    static function updateTicket(PDO $db, int $id, int $agent_id, int $client_id, int $department_id, string $status, string $title): bool
    {
        $stmt = $db->prepare('UPDATE TICKETS SET agent_id = ?, client_id = ?, department_id = ?, status = ?, title = ? WHERE ticket_id = ?');
        try {
            $stmt->execute(array($agent_id, $client_id, $department_id, $status, $title, $id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function getTickets(PDO $db, int $count): array
    {
        $stmt = $db->prepare('SELECT ticket_id, agent_id, client_id, department_id, status, title FROM TICKETS LIMIT ?');
        $stmt->execute(array($count));

        $tickets = array();
        while ($ticket = $stmt->fetch()) {
            $tickets[] = new Ticket(
                $ticket['ticket_id'],
                $ticket['agent_id'],
                $ticket['client_id'],
                $ticket['department_id'],
                $ticket['status'],
                $ticket['title']
            );
        }
        return $tickets;
    }

    static function getTicketById(PDO $db, int $id): ?Ticket
    {
        $stmt = $db->prepare('SELECT ticket_id, agent_id, client_id, department_id, status, title FROM TICKETS WHERE ticket_id = ?');
        $stmt->execute(array($id));

        $ticket = $stmt->fetch();
        if ($ticket) {
            return new Ticket(
                intval($ticket['ticket_id']),
                $ticket['agent_id'],
                $ticket['client_id'],
                $ticket['department_id'],
                $ticket['status'],
                $ticket['title']
            );
        } else {
            return null;
        }
    }

    static function createTicket(PDO $db, int $client_id, int $department_id, string $status, string $title, ?int $agent_id = 0): bool
    {
        $stmt = $db->prepare('INSERT INTO TICKETS (agent_id, client_id, department_id, status, title) VALUES (?, ?, ?, ?, ?)');
        try {
            $stmt->execute(array($agent_id !== null ? $agent_id : null, $client_id, $department_id, $status, $title));
            return true;
        } catch (PDOException $e) {
            echo "Error creating ticket: " . $e->getMessage();
            return false;
        }
    }

    static function getTicketsClient(PDO $db, int $client_id, int $count): array
    {
        $stmt = $db->prepare('SELECT ticket_id, agent_id, client_id, department_id, status,title FROM TICKETS WHERE client_id = ? LIMIT ?');
        $stmt->execute(array($client_id, $count));

        $tickets = array();
        while ($ticket = $stmt->fetch()) {
            $tickets[] = new Ticket(
                $ticket['ticket_id'],
                $ticket['agent_id'],
                $ticket['client_id'],
                $ticket['department_id'],
                $ticket['status'],
                $ticket['title']
            );
        }
        return $tickets;
    }
}
?>