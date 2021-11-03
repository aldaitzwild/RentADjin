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
    public function selectAllInfoById(int $id)
    {
        //Prepare request
        $query = "SELECT g.name AS genieName,
        s.name AS specialtyName,
        g.id AS genieId, s.id AS specialtyId,
        s.img,
        g.material,
        g.nb_wishes,
        g.specialty_id,
        g.costPerDay,
        g.genie_img,
        g.lamp_img
        FROM genies AS g
        JOIN specialties AS s ON s.id = g.specialty_id
        WHERE g.id =:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch();
    }
}
