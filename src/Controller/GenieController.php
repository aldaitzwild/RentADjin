<?php

namespace App\Controller;

use App\Model\GenieManager;

class GenieController extends AbstractController
{

    private GenieManager $genieManager;
    public function __construct()
    {
        parent::__construct();
        $this->genieManager = new GenieManager();
    }

    // Returns all informations for a specific Genie
    public function showGenie($id): string
    {
        $genieInfo = $this->genieManager->selectAllInfoById($id);
        return $this->twig->render(
            'Genie/showGenie.html.twig',
            ['genieInfo' => $genieInfo]
        );
    }
}
