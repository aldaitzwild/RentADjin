<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Model\GenieManager;
use App\Model\SpecialtyManager;
use App\Controller\GenieController;

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
        session_start();
        $users = $this->userManager->selectAll();
        $genies = $this->genieManager->selectAll();
        $specialties = $this->specialtyManager->selectAll();

        $errorsGenie = "";

        if (isset($_SESSION['errorsGenie'])) {
            $errorsGenie = $_SESSION['errorsGenie'];
            unset($_SESSION['errorsGenie']);
        }

        return $this->twig->render(
            'Admin/admin.html.twig',
            [
                'users' => $users,
                'genies' => $genies,
                'specialties' => $specialties,
                'errorsGenie' => $errorsGenie
            ]
        );
    }

    /**
     * Display page for for one genie
     *
     * @return string
     */
    public function showGenie($id): string
    {
        $genieInfo = $this->genieManager->selectAllInfoById($id);
        return $this->twig->render(
            'Admin/adminShowGenie.html.twig',
            ['genieInfo' => $genieInfo]
        );
    }


    public function showUpdateGenie($id): string
    {

        session_start();

        $genieInfo = $this->genieManager->selectAllInfoById($id);
        $specialties = $this->specialtyManager->selectAll();

        $errorsUpdate = '';

        if (isset($_SESSION['errorsUpdate'])) {
            $errorsUpdate = $_SESSION['errorsUpdate'];
            unset($_SESSION['errorsUpdate']);
        }



        return $this->twig->render(
            'Admin/adminUpdateGenie.html.twig',
            ['genieInfo' => $genieInfo, 'specialties' => $specialties, 'errorsUpdate' => $errorsUpdate]
        );
    }
}
