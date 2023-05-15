<?php


class Message
{
    public int $id;
    public int $ticket_id;
    public int $client_id;
    public string $message;
    public DateTime $date_created;

    public function __construct(int $id, int $ticket_id, int $client_id, string $message, DateTime $date_created)
    {
        $this->id = $id;
        $this->ticket_id = $ticket_id;
        $this->client_id = $client_id;
        $this->message = $message;
        $this->date_created = $date_created;
    }

    static function updateMessage(PDO $db, int $id, int $ticket_id, int $client_id, string $message, DateTime $date_created)
    {
        $stmt = $db->prepare('UPDATE MESSAGES SET ticket_id = ?, client_id = ?, message_content = ?, date_created = ? WHERE message_id =
?');
        try {
            $stmt->execute(array($ticket_id, $client_id, $message, $date_created->format('Y-m-d H:i:s'), $id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function getMessages(PDO $db, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT message_id, ticket_id, client_id, message_content, date_created FROM MESSAGES LIMIT ?'
        );
        $stmt->execute(array($count));

        $messages = array();
        while ($message = $stmt->fetch()) {
            $messages[] = new Message(
                $message['message_id'],
                $message['ticket_id'],
                $message['client_id'],
                $message['message_content'],
                new DateTime($message['date_created']),
            );
        }
        return $messages;
    }

    static function getMessageById(PDO $db, int $id): ?Message
    {
        $stmt = $db->prepare(
            'SELECT message_id, ticket_id, client_id, message_content, date_created FROM MESSAGES WHERE message_id = ?'
        );
        $stmt->execute(array($id));

        if ($message = $stmt->fetch()) {
            return new Message(
                $message['message_id'],
                $message['ticket_id'],
                $message['client_id'],
                $message['message_content'],
                new DateTime($message['date_created']),
            );
        }

        return null;
    }

    static function createMessage(PDO $db, int $ticket_id, int $client_id, string $message_content, DateTime $date_created): bool
    {
        $stmt = $db->prepare('INSERT INTO MESSAGES (ticket_id, client_id, message_content, date_created) VALUES (?, ?, ?, ?)');
        try {
            $stmt->execute(array($ticket_id, $client_id, $message_content, $date_created->format('Y-m-d H:i:s')));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function getMessagebyTicketID(PDO $db, int $ticket_id): ?Message
    {
        $stmt = $db->prepare(
            'SELECT message_id, ticket_id, client_id, message_content, date_created FROM MESSAGES WHERE ticket_id = ?'
        );
        $stmt->execute(array($ticket_id));

        if ($message = $stmt->fetch()) {
            return new Message(
                $message['message_id'],
                $message['ticket_id'],
                $message['client_id'],
                $message['message_content'],
                new DateTime($message['date_created']),
            );
        }

        return null;
    }

}
?>