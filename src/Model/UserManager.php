<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'users';

    /**
     * Insert new item in database
     */
    public function insert(array $users): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (lastname, firstname, email, address, admin) 
            VALUES (:lastname, :firstname, :email, :address, :admin)");
        $statement->bindValue('lastname', $users['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('firstname', $users['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $users['email'], \PDO::PARAM_STR);
        $statement->bindValue('address', $users['address'], \PDO::PARAM_STR);
        $statement->bindValue('admin', array_key_exists('admin', $users), \PDO::PARAM_BOOL);

        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }

    public function selectUserData(string $firstname, string $email)
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM " . static::TABLE . " WHERE firstname=:firstname AND email=:email"
        );
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}
