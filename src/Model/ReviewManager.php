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
}
