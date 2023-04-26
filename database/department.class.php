<?php

class Department
{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = (string) $name;
    }

    static function updateDepartment(PDO $db, int $id, string $name): bool
    {
        $stmt = $db->prepare('UPDATE DEPARTMENTS SET department_name = ? WHERE department_id = ?');
        try {
            $stmt->execute(array($name, $id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function getDepartments(PDO $db, int $count): array
    {
        $stmt = $db->prepare('SELECT department_id, department_name FROM DEPARTMENTS LIMIT ?');
        $stmt->execute(array($count));

        $departments = array();
        while ($department = $stmt->fetch()) {
            $departments[] = new Department(
                $department['department_id'],
                $department['department_name']
            );
        }
        return $departments;
    }

    static function getDepartmentById(PDO $db, int $id): ?Department
    {
        $stmt = $db->prepare('SELECT department_id, department_name FROM DEPARTMENTS WHERE department_id = ?');
        $stmt->execute(array($id));

        $department = $stmt->fetch();
        if ($department) {
            return new Department(
                intval($department['department_id']),
                $department['department_name']
            );
        } else {
            return null;
        }
    }

    static function newDepartment(PDO $db, string $name): bool
    {
        $stmt = $db->prepare('INSERT INTO DEPARTMENTS (department_name) VALUES (?)');
        try {
            $stmt->execute(array($name));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>