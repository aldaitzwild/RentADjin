<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $user = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $userManager = new UserManager();
            $userManager = $userManager->insert($user);
            header('Location:/'); //A compléter pour redirection vers la page Admin
        }

        return $this->twig->render('Admin/add.html.twig'); //Route déjà ajoutée par Manue
    }

    public function list(): string
    {
        $userManager = new UserManager();
        $users = $userManager->selectAll('firstname', 'lastname');

        return $this->twig->render('Admin/list.html.twig', ['users' => $users]);
    }
}
