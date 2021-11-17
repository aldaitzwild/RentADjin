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

    public function selectUser()
    {
        $errorsMessage = 'Vos identifiants sont incorrects !';


        if (!empty($_POST)) {
            $firstname = $_POST['firstname'];
            $email = $_POST['email'];
            $data = $this->userManager->selectUserData($firstname, $email);
            if ($data != false) {
                $_SESSION['user'] = $data;

                header('Location: ' . $_SERVER['HTTP_REFERER']);
                return;
            }
        }
        $_SESSION['errorsMessage'] = $errorsMessage;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
