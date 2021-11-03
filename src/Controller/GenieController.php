<?php

namespace App\Controller;

use App\Model\GenieManager;

class GenieController extends AbstractController
{
    // Returns all informations for a specific Genie
    public function show(int $id): string
    {
        $genieManager = new GenieManager();
        $genie = $genieManager->selectAllInfoById($id);

        return $this->twig->render('Genie/show.html.twig', ['genie' => $genie]);
    }
}
