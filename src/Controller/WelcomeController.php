<?php

namespace App\Controller;

use App\Model\SpecialtyManager;

class WelcomeController extends AbstractController
{
    private SpecialtyManager $specialtyManager;

    public function __construct()
    {
        parent:: __construct();
        $this -> specialtyManager = new SpecialtyManager();
    }

    public function index()
    {
        $specialties = $this->specialtyManager->selectAll();

        return $this->twig->render('Home/welcome.html.twig', ['specialties' => $specialties]);
    }
}
