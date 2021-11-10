<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    private UserManager $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }

    public function add(): void
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $user = array_map('trim', $_POST);
            $user = array_map('htmlentities', $user);

            $errors = $this->testInput($user);

            if (empty($errors['input'])) {
                $this->userManager->insert($user);
            }

            $_SESSION['errorsUser'] = $errors;
            header('Location:/admin');
        }
    }

    public function testInput(array $inputs): array
    {
        $errors = [];
        $errors['input'] = [];
        foreach ($inputs as $input) {
            if (empty($input)) {
                $errors['input']['empty'] = 'Tous les champs sont requis';
            }
        }

        return $errors;
    }
}
