<?php

namespace App\Model;

use App\Model\AbstractManager;

class GenieManager extends AbstractManager
{
    public const TABLE = 'genies';

    public function insert(array $genies): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        "(name, material, nb_wishes, specialty_id, costPerDay, genie_img, lamp_img) 
        VALUES (:name, :material, :nb_wishes,:specialty_id, :costPerDay, :genie_img, :lamp_img)");
        $statement->bindValue('name', $genies['name'], \PDO::PARAM_STR);
        $statement->bindValue('material', $genies['material'], \PDO::PARAM_STR);
        $statement->bindValue('nb_wishes', $genies['nb_wishes'], \PDO::PARAM_INT);
        $statement->bindValue('specialty_id', $genies['specialty_id'], \PDO::PARAM_INT);
        $statement->bindValue('costPerDay', $genies['costPerDay'], \PDO::PARAM_INT);
        $statement->bindValue('genie_img', $genies['genie_img'], \PDO::PARAM_STR);
        $statement->bindValue('lamp_img', $genies['lamp_img'], \PDO::PARAM_STR);

        $statement->execute();

        return(int)$this->pdo->lastInsertId();
    }

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
