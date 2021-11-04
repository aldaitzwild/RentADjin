<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    private UserManager $userManager;
    public function __construct()
    {
        parent:: __construct();
        $this -> userManager = new UserManager();
    }

    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $user = array_map('trim', $_POST);

            $this -> userManager->insert($user);
            header('Location:admin'); //A compléter pour redirection vers la page Admin
        }
        return $this->twig->render('Admin/addUser.html.twig'); //Route déjà ajoutée par Manue
    }
}
