<?php

namespace App\Model;

class BookingManager extends AbstractManager
{
    public const TABLE = 'bookings';

    public function __construct()
    {
        parent::__construct();
    }

    public function selectAllFromOneUser(int $id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM bookings WHERE user_id = :user_id;");

        $statement->bindValue("user_id", $id, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectAllForOneGenie(int $id)
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

        $statement->bindValue("user_id", 1, \PDO::PARAM_INT);
        $statement->bindValue("genie_id", $booking["genieId"], \PDO::PARAM_INT);
        $statement->bindValue("check_in", $booking["checkin"], \PDO::PARAM_STR);
        $statement->bindValue("checkout", $booking["checkout"], \PDO::PARAM_STR);

        $statement->execute();
    }

    public function selectOneByUserAndGenie(int $userId, int $genieId)
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM bookings WHERE user_id = :user_id AND genie_id = :genie_id;"
        );

        $statement->bindValue("user_id", $userId, \PDO::PARAM_INT);
        $statement->bindValue("genie_id", $genieId, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch();
    }

    public function overlaps(int $genieId, string $checkin, string $checkout): int
    {
        $statement = $this->pdo->prepare(
            "SELECT COUNT(*) as nbOfOverlaps
            FROM bookings
            WHERE genie_id = :genie_id
            AND DATE(check_in) <= :checkout
            AND DATE(checkout) >= :checkin;"
        );

        $statement->bindValue("genie_id", $genieId, \PDO::PARAM_INT);
        $statement->bindValue("checkout", $checkout, \PDO::PARAM_STR);
        $statement->bindValue("checkin", $checkin, \PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch()['nbOfOverlaps'];
    }
}
