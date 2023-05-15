<?php





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



    static function getClientWithPassword(PDO $db, string $email, string $password): ?Client
    {
        $stmt = $db->prepare(
            'SELECT client_id, username, password, email FROM CLIENTS WHERE email = ? AND password = ?'
        );
        $stmt->execute(array($email, $password));

        if ($user = $stmt->fetch()) {
            return new Client(
                intval($user['client_id']),
                $user['username'],
                $user['email'],
                $user['password'],
            );
        }

        return null;
    }


    static function getClients(PDO $db, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT client_id, username, email, password
                 FROM CLIENTS
                 LIMIT ?'
        );
        $stmt->execute(array($count));

        $users = array();
        while ($user = $stmt->fetch()) {
            $users[] = new Client(
                $user['client_id'],
                $user['username'],
                $user['email'],
                $user['password'],
            );
        }
        return $users;
    }


    static function getClientById(PDO $db, int $id): ?Client
    {
        $stmt = $db->prepare(
            'SELECT client_id, username, password, email FROM  CLIENTS WHERE client_id = ?'
        );
        $stmt->execute(array($id));

        $user = $stmt->fetch();
        if ($user) {
            return new Client(
                intval($user['client_id']),
                $user['username'],
                $user['email'],
                $user['password']
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

    static function giveAdmin(PDO $db, $id)
    {
        $stmt = $db->prepare('INSERT INTO AGENTS (client_id) VALUES (?)');
        try {
            $stmt->execute(array($id));
        } catch (PDOException $e) {
            return false;
        }

        $stmt = $db->prepare('SELECT agent_id FROM AGENTS WHERE client_id = ?');
        try {
            $stmt->execute(array($id));
            $user = $stmt->fetch();
            if ($user) {
                $agent_id = $user['agent_id'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return false;
        }

        $stmt = $db->prepare('INSERT INTO ADMINS (client_id, agent_id) VALUES (?,?)');
        try {
            $stmt->execute(array($id, $agent_id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function getAgents(PDO $db, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT c.client_id AS t1, c.username, c.email, c.password
            FROM CLIENTS c
            INNER JOIN AGENTS a ON c.client_id = a.client_id
            LIMIT ?'
        );
        $stmt->execute(array($count));

        $users = array();
        while ($user = $stmt->fetch()) {
            $users[] = new Client(
                $user['t1'],
                $user['username'],
                $user['email'],
                $user['password'],
            );
        }
        return $users;
    }

    static function isAdmin(PDO $db, $id)
    {
        $stmt = $db->prepare('SELECT * FROM ADMINS WHERE client_id = ?');
        $stmt->execute(array($id));
        return ($stmt->fetch() !== false);
    }
    static function isAgent(PDO $db, $id)
    {
        $stmt = $db->prepare('SELECT * FROM AGENTS WHERE client_id = ?');
        $stmt->execute(array($id));
        return ($stmt->fetch() !== false);
    }

    static function deleteClient(PDO $db, $id)
    {
        $stmt = $db->prepare('DELETE FROM CLIENTS WHERE client_id = ?');
        try {
            $stmt->execute(array($id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function getAdmins(PDO $db, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT c.client_id AS t1, c.username, c.email, c.password
            FROM CLIENTS c
            INNER JOIN ADMINS a ON c.client_id = a.client_id
            LIMIT ?'
        );
        $stmt->execute(array($count));

        $users = array();
        while ($user = $stmt->fetch()) {
            $users[] = new Client(
                $user['t1'],
                $user['username'],
                $user['email'],
                $user['password'],
            );
        }
        return $users;
    }

    static function getOnlyClients(PDO $db, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT C.client_id, C.username, C.email, C.password
         FROM CLIENTS C
         LEFT JOIN AGENTS A ON C.client_id = A.client_id
         LEFT JOIN ADMINS ADM ON C.client_id = ADM.client_id
         WHERE A.client_id IS NULL AND ADM.client_id IS NULL
         LIMIT :count'
        );
        $stmt->bindValue(':count', $count, PDO::PARAM_INT);
        $stmt->execute();

        $users = array();
        while ($user = $stmt->fetch()) {
            $users[] = new Client(
                $user['client_id'],
                $user['username'],
                $user['email'],
                $user['password'],
            );
        }
        return $users;
    }

    static function getOnlyAgents(PDO $db, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT C.client_id, C.username, C.email, C.password
         FROM CLIENTS C
         INNER JOIN AGENTS A ON C.client_id = A.client_id
         LEFT JOIN ADMINS ADM ON C.client_id = ADM.client_id
         WHERE ADM.client_id IS NULL
         LIMIT :count'
        );
        $stmt->bindValue(':count', $count, PDO::PARAM_INT);
        $stmt->execute();

        $users = array();
        while ($user = $stmt->fetch()) {
            $users[] = new Client(
                $user['client_id'],
                $user['username'],
                $user['email'],
                $user['password'],
            );
        }
        return $users;
    }

    static function getOnlyAdmins(PDO $db, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT C.client_id, C.username, C.email, C.password
         FROM CLIENTS C
         INNER JOIN ADMINS ADM ON C.client_id = ADM.client_id
         LIMIT :count'
        );
        $stmt->bindValue(':count', $count, PDO::PARAM_INT);
        $stmt->execute();

        $users = array();
        while ($user = $stmt->fetch()) {
            $users[] = new Client(
                $user['client_id'],
                $user['username'],
                $user['email'],
                $user['password'],
            );
        }
        return $users;
    }
} ?>