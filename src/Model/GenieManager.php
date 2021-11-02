<?php

namespace App\Model;

use App\Model\AbstractManager;

class GenieManager extends AbstractManager
{
    public const TABLE = 'genies';


    /**
     * Get one row from database by ID JOIN with specialties table.
     *
     */
    public function selectAllInfoById(int $id): array
    {
        //Prepare request
        $query = "SELECT * FROM genies AS g JOIN specialties AS s ON s.id = g.specialties_id WHERE g.id =:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
