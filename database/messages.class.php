<?php


class Message
{
    public int $id;
    public int $ticket_id;
    public int $client_id;
    public string $message;
    public DateTime $timestamp;

    public function __construct(int $id, int $ticket_id, int $client_id, string $message, DateTime $timestamp)
    {
        $this->id = $id;
        $this->ticket_id = $ticket_id;
        $this->client_id = $client_id;
        $this->message = $message;
        $this->timestamp = $timestamp;
    }

    static function updateMessage(PDO $db, int $id, int $ticket_id, int $client_id, string $message, DateTime $timestamp)
    {
        $stmt = $db->prepare('UPDATE MESSAGES SET ticket_id = ?, client_id = ?, message = ?, timestamp = ? WHERE message_id =
?');
        try {
            $stmt->execute(array($ticket_id, $client_id, $message, $timestamp->format('Y-m-d H:i:s'), $id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function getMessages(PDO $db, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT message_id, ticket_id, client_id, message, timestamp FROM MESSAGES LIMIT ?'
        );
        $stmt->execute(array($count));

        $messages = array();
        while ($message = $stmt->fetch()) {
            $messages[] = new Message(
                $message['message_id'],
                $message['ticket_id'],
                $message['client_id'],
                $message['message'],
                new DateTime($message['timestamp']),
            );
        }
        return $messages;
    }

    static function getMessageById(PDO $db, int $id): ?Message
    {
        $stmt = $db->prepare(
            'SELECT message_id, ticket_id, client_id, message, timestamp FROM MESSAGES WHERE message_id = ?'
        );
        $stmt->execute(array($id));

        if ($message = $stmt->fetch()) {
            return new Message(
                $message['message_id'],
                $message['ticket_id'],
                $message['client_id'],
                $message['message'],
                new DateTime($message['timestamp']),
            );
        }

        return null;
    }

    static function createMessage(PDO $db, int $ticket_id, int $client_id, string $message, DateTime $timestamp): ?Message
    {
        $stmt = $db->prepare('INSERT INTO MESSAGES (ticket_id, client_id, message, timestamp) VALUES (?, ?, ?, ?)');
        try {
            $stmt->execute(array($ticket_id, $client_id, $message, $timestamp->format('Y-m-d H:i:s')));
            return self::getMessageById($db, $db->lastInsertId());
        } catch (PDOException $e) {
            return null;
        }
    }

}
?>