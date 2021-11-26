<?php

namespace App\Model;

use App\Model\AbstractManager;

class ReviewManager extends AbstractManager
{
    public const TABLE = 'reviews';

    /**
     * Insert new review in database
     */
    public function insert(array $reviews): void
    {
        $statement = $this->pdo->prepare("INSERT INTO " .
            self::TABLE . " (user_id,genie_id,rating, review) VALUES (:user_id,:genie_id,:rating,:review)");
        $statement->bindValue('user_id', $reviews['userId'], \PDO::PARAM_INT);
        $statement->bindValue('genie_id', $reviews['genie'], \PDO::PARAM_INT);
        $statement->bindValue('rating', $reviews['rating'], \PDO::PARAM_INT);
        $statement->bindValue('review', $reviews['review'], \PDO::PARAM_STR);

        $statement->execute();
    }

    public function selectAllReviewByGenie(int $id): array
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM reviews JOIN users ON users.id = reviews.user_id WHERE genie_id = :genie_id;"
        );
        $statement->bindValue('genie_id', $id, \PDO::PARAM_INT);

        $statement->execute();
        return $statement->fetchAll();
    }

    public function avgRatingForOneGenie(int $id): int
    {
        $statement = $this->pdo->prepare(
            "SELECT AVG(rating) as average FROM reviews WHERE genie_id = :genie_id;"
        );
        $statement->bindValue('genie_id', $id, \PDO::PARAM_INT);

        $statement->execute();
        $average = $statement->fetch()['average'];

        return $average === null ? 0 : ceil($average);
    }
}
