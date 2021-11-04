<?php

namespace App\Model;

class GenieManager extends AbstractManager
{
    public const TABLE = 'genies';
    public function selectAllInfoById(int $id)
    {
        // prepared request
        $query = "SELECT * FROM genies JOIN specialties ON specialties.id = genies.specialty_id WHERE genies.id=:id;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        $genie = $statement->fetch();
        return $genie;
    }
}
