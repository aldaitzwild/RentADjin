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
        $genies = $this->genieManager->selectAll();
        $specialties = $this->specialtyManager->selectAll();

        $errorsGenie = "";
        $errorsSpecialty = "";
        $errorsUser = "";

        if (isset($_SESSION['errorsGenie'])) {
            $errorsGenie = $_SESSION['errorsGenie'];
            unset($_SESSION['errorsGenie']);
        }


        if (isset($_SESSION['errorsSpecialty'])) {
            $errorsSpecialty = $_SESSION['errorsSpecialty'];
            unset($_SESSION['errorsSpecialty']);
        }

        if (isset($_SESSION['errorsUser'])) {
            $errorsUser = $_SESSION['errorsUser'];
            unset($_SESSION['errorsUser']);
        }

        return $this->twig->render(
            'Admin/admin.html.twig',
            [
                'users' => $users,
                'genies' => $genies,
                'specialties' => $specialties,
                'errorsGenie' => $errorsGenie,
                'errorsSpecialty' => $errorsSpecialty,
                'errorsUser' => $errorsUser
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
