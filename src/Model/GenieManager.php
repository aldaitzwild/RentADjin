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
}
