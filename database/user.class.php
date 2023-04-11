<?php

declare(strict_types=1);



class User
{
    public int $id;
    public string $first_name;
    public string $last_name;
    public ?string $address;
    public ?string $city;
    public ?string $country;
    public ?string $phone;
    public string $email;
    public string $password;

    public function __construct(int $id, string $first_name, string $last_name, ?string $address, ?string $city, ?string $country, ?string $phone, string $email, string $password)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
    }

    function name()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    static function updateUser(PDO $db, string $email, string $first_name, string $last_name, string $address, string $city, string $country, string $phone, int $id)
    {
        $stmt = $db->prepare('
            UPDATE USER SET email = ?, firstName = ?, lastName = ?, address = ?, city = ?, country = ?, phone = ?
            WHERE idUser = ?
        ');

        try {
            $stmt->execute(array($email, $first_name, $last_name, $address, $city, $country, $phone, $id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }



    static function getUserWithPassword(PDO $db, string $email, string $password): ?User
    {
        $stmt = $db->prepare(
            'SELECT idUser, firstName, lastName, address, city, country, phone, email, password FROM USER WHERE email = ? AND password = ?'
        );
        $stmt->execute(array($email, $password));

        if ($user = $stmt->fetch()) {
            return new User(
                intval($user['idUser']),
                $user['firstName'],
                $user['lastName'],
                $user['address'],
                $user['city'],
                $user['country'],
                $user['phone'],
                $user['email'],
                $user['password']
            );
        }

        return null;
    }


    static function getUsers(PDO $db, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT idUser, firstName, lastName, address, city, country, phone, email, password
                 FROM User
                 LIMIT ?'
        );
        $stmt->execute(array($count));

        $users = array();
        while ($user = $stmt->fetch()) {
            $users = new User(
                $user['idUser'],
                $user['firstName'],
                $user['lastName'],
                $user['address'],
                $user['city'],
                $user['country'],
                $user['phone'],
                $user['email'],
                $user['password']
            );
        }
        return $users;
    }


    static function getUserById(PDO $db, int $id): User
    {
        $stmt = $db->prepare(
            'SELECT idUser, firstName, lastName, address, city, country, phone, email, password FROM  USER WHERE idUser = ?'
        );
        $stmt->execute(array($id));

        $user = $stmt->fetch();

        return new User(
            intval($user['idUser']),
            $user['firstName'],
            $user['lastName'],
            $user['address'],
            $user['city'],
            $user['country'],
            $user['phone'],
            $user['email'],
            $user['password']
        );
    }

    static function emailInUse(PDO $db, $email)
    {
        $stmt = $db->prepare('SELECT * FROM User where email = ?');
        $stmt->execute(array(strtolower($email)));
        return ($stmt->fetch() !== false);
    }


    static function newUser($db, $first_name, $last_name, $email, $password)
    {
        $stmt = $db->prepare('INSERT INTO User (firstName, lastName, email, password) values(?, ?, ?, ?)');
        try {
            $stmt->execute(array($first_name, $last_name, $email, $password));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

};