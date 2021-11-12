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
}
