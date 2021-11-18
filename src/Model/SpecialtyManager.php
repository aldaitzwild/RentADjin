<?php

namespace App\Model;

use App\Model\AbstractManager;

class SpecialtyManager extends AbstractManager
{
    public const TABLE = 'specialties';

    public function selectNameId(): array
    {
        $query = 'SELECT id, name FROM ' . static::TABLE;

        return $this->pdo->query($query)->fetchAll();
    }

    public function insert(array $specialtyInfo): void
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (name, img) VALUES (:name, :img);");

        $statement->bindValue(':name', $specialtyInfo['name'], \PDO::PARAM_STR);
        $statement->bindValue(':img', $specialtyInfo['specialty_img'], \PDO::PARAM_STR);

        $statement->execute();
    }

    public function nbOfSpecialties(): int
    {
        $statement = $this->pdo->query("SELECT COUNT(*) as nbOfSpecialties FROM " . self::TABLE);

        return $statement->fetch()["nbOfSpecialties"];
    }
}
