<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Model\GenieManager;
use App\Model\SpecialtyManager;

class AdminController extends AbstractController
{
    private UserManager $userManager;
    private GenieManager $genieManager;
    private SpecialtyManager $specialtyManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
        $this->genieManager = new GenieManager();
        $this->specialtyManager = new SpecialtyManager();
    }

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(): string
    {
        $users = $this->userManager->selectAll();

        return $this->twig->render('Admin/admin.html.twig', ['users' => $users]);
    }

    /**
     * Display page for for one genie
     *
     * @return string
     */
    public function showGenie($id): string
    {
        $genieInfo = $this->genieManager->selectAllInfoById($id);
        $specialties = $this->specialtyManager->selectAll();

        return $this->twig->render(
            'Admin/adminGenie.html.twig',
            ['genieInfo' => $genieInfo, 'specialties' => $specialties]
        );
    }
}
