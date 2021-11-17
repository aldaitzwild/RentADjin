<?php

namespace App\Model;

use App\Model\AbstractManager;

class GenieManager extends AbstractManager
{
    public const TABLE = 'genies';

    public function insert(array $genies): void
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
        g.lamp_img,
        g.description
        FROM genies AS g
        JOIN specialties AS s ON s.id = g.specialty_id
        WHERE g.id =:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch();
    }

    public function selectAllGenies(): array
    {
        $query = 'SELECT genies.description, genies.id, genies.name, genies.genie_img,
        genies.costPerDay,
        specialties.name AS speName
        FROM genies JOIN specialties ON specialties.id = genies.specialty_id';
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function update(int $id, array $genieInfo): void
    {

        $genieImg = "";
        $lampImg = "";
        $placeholderGenieImg = "";
        $placeholderLampImg = "";

        if (isset($genieInfo["genie_img"])) {
            $genieImg = ", genie_img=";
            $placeholderGenieImg = ":genie_img";
        }
        if (isset($genieInfo["lamp_img"])) {
            $lampImg = ", lamp_img=";
            $placeholderLampImg = ":lamp_img";
        }


        $query = ("UPDATE " . self::TABLE .
            " SET name=:name,
            material=:material,
            nb_wishes=:nb_wishes,
            specialty_id=:specialty_id,
            costPerDay=:costPerDay" .
            $genieImg . $placeholderGenieImg .
            $lampImg . $placeholderLampImg . "
            WHERE id=:id;");

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('name', $genieInfo['name'], \PDO::PARAM_STR);
        $statement->bindValue('material', $genieInfo['material'], \PDO::PARAM_STR);
        $statement->bindValue('nb_wishes', $genieInfo['nb_wishes'], \PDO::PARAM_INT);
        $statement->bindValue('specialty_id', $genieInfo['specialty_id'], \PDO::PARAM_INT);
        $statement->bindValue('costPerDay', $genieInfo['costPerDay'], \PDO::PARAM_INT);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        if (isset($genieInfo["genie_img"])) {
            $statement->bindValue('genie_img', $genieInfo['genie_img'], \PDO::PARAM_STR);
        }
        if (isset($genieInfo["lamp_img"])) {
            $statement->bindValue('lamp_img', $genieInfo['lamp_img'], \PDO::PARAM_STR);
        }

        $statement->execute();
    }
}
