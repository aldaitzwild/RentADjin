<?php

namespace App\Controller;

use App\Model\UserManager;

class AdminController extends AbstractController
{
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
        $userManager = new UserManager();
        $users = $userManager->selectAll();

        return $this->twig->render('Admin/admin.html.twig', ['users' => $users]);
    }
}
