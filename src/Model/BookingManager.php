<?php

namespace App\Model;

class BookingManager extends AbstractManager
{
    public const TABLE = 'bookings';

    public function __construct()
    {
        parent::__construct();
    }

    public function selectBookingFromOneUser(int $id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM bookings WHERE user_id = :user_id;");

        $statement->bindValue("user_id", $id, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectBookingForOneGenie(int $id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM bookings WHERE genie_id = :genie_id;");

        $statement->bindValue("genie_id", $id, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function insert(array $booking)
    {
        $query = ("INSERT INTO bookings (user_id, genie_id, check_in, checkout)
        VALUES (:user_id, :genie_id, :check_in, :checkout);");

        $statement = $this->pdo->prepare($query);

        $statement->bindValue("user_id", $booking["user_id"], \PDO::PARAM_INT);
        $statement->bindValue("genie_id", $booking["genie_id"], \PDO::PARAM_INT);
        $statement->bindValue("check_in", $booking["check_in"], \PDO::PARAM_STR);
        $statement->bindValue("checkout", $booking["checkout"], \PDO::PARAM_STR);

        $statement->execute();
    }
}
