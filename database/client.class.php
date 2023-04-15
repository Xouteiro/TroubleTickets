<?php

declare(strict_types=1);



class Client
{
    public int $id;
    public string $username;
    public string $email;
    public string $password;

    public function __construct(int $id, string $username, string $email, string $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }


    static function updateUser(PDO $db, string $username, string $password, string $email, int $id)
    {
        $stmt = $db->prepare('
    UPDATE CLIENTS SET username = ?, password = ?, email = ?
    WHERE idUser = ?
    ');
        try {
            $stmt->execute(array($username, $password, $email, $id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }



    static function getClientWithPassword(PDO $db, string $username, string $password): ?Client
    {
        $stmt = $db->prepare(
            'SELECT client_id, username, password, email FROM CLIENTS WHERE username = ? AND password = ?'
        );
        $stmt->execute(array($username, $password));

        if ($user = $stmt->fetch()) {
            return new Client(
                intval($user['idUser']),
                $user['username'],
                $user['password'],
                $user['email'],
            );
        }

        return null;
    }


    static function getClients(PDO $db, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT client_id, username, password, email
                 FROM CLIENTS
                 LIMIT ?'
        );
        $stmt->execute(array($count));

        $users = array();
        while ($user = $stmt->fetch()) {
            $users[] = new Client(
                $user['idUser'],
                $user['username'],
                $user['password'],
                $user['email'],
            );
        }
        return $users;
    }


    static function getClientById(PDO $db, int $id): ?Client
    {
        $stmt = $db->prepare(
            'SELECT client_id, username, password, email FROM  CLIENTS WHERE idUser = ?'
        );
        $stmt->execute(array($id));

        $user = $stmt->fetch();
        if ($user) {
            return new Client(
                intval($user['idUser']),
                $user['username'],
                $user['password'],
                $user['email']
            );
        } else {
            return null;
        }
    }

    static function emailInUse(PDO $db, $email)
    {
        $stmt = $db->prepare('SELECT * FROM CLIENTS where email = ?');
        $stmt->execute(array(strtolower($email)));
        return ($stmt->fetch() !== false);
    }


    static function newClient($db, $username, $email, $password)
    {
        $stmt = $db->prepare('INSERT INTO CLIENTS (username, password, email) values(?, ?, ?)');
        try {
            $stmt->execute(array($username, $password, $email));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

}
;