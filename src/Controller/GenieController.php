<?php

namespace App\Controller;

use App\Model\GenieManager;
use App\Model\SpecialtyManager;

class GenieController extends AbstractController
{
    private GenieManager $genieManager;
    private SpecialtyManager $specialtyManager;

    public function __construct()
    {
        parent::__construct();
        $this->genieManager = new GenieManager();
        $this->specialtyManager = new SpecialtyManager();
    }

    // Returns all informations for a specific Genie
    public function showGenie($id): string
    {
        $genieInfo = $this->genieManager->selectAllInfoById($id);

        $userInfo = '';
        $errorsBooking = '';

        if (isset($_SESSION['user'])) {
            $userInfo = $_SESSION['user'];
        }

        if (isset($_SESSION['errorsBooking'])) {
            $errorsBooking = $_SESSION['errorsBooking'];
            unset($_SESSION['errorsBooking']);
        }

        return $this->twig->render(
            'Genie/showGenie.html.twig',
            [
                'genieInfo' => $genieInfo,
                'userInfo' => $userInfo,
                'errorsBooking' => $errorsBooking
            ]
        );
    }

    public function add(): void
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $genie = array_map('trim', $_POST);
            $genie = array_map('htmlentities', $genie);

            $errors = $this->testInput($genie);

            $uploadDir = 'assets/images/';
            $extensionOk = ['jpg', 'jpeg', 'png'];
            $maxFileSize = 2000000;

            if (file_exists($_FILES['genie_img']['tmp_name']) || file_exists($_FILES['lamp_img']['tmp_name'])) {
                $errors["files"]["genie"] = $this->testFile($_FILES['genie_img'], $maxFileSize, $extensionOk);
                $errors["files"]["lamp"] = $this->testFile($_FILES['lamp_img'], $maxFileSize, $extensionOk);
            } else {
                $errors["files"]["empty"] = "Veuillez renseigner une image pour le genie et sa lampe.";
            }

            if (empty($errors['input']) && empty($errors["files"]['genie']) && empty($errors["files"]['genie'])) {
                $genie['genie_img'] = $this->manageFile($_FILES['genie_img'], $uploadDir);
                $genie['lamp_img'] = $this->manageFile($_FILES['lamp_img'], $uploadDir);

                $this->genieManager->insert($genie);
            }

            $_SESSION['errorsGenie'] = $errors;
            header('Location:/admin');
        }
    }


    public function update(int $id): void
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $genie = array_map('trim', $_POST);
            $genie = array_map('htmlentities', $genie);

            $errors = $this->testInput($genie);

            $uploadDir = 'assets/images/';
            $extensionOk = ['jpg', 'jpeg', 'png'];
            $maxFileSize = 2000000;

            if (empty($errors['input'])) {
                if (file_exists($_FILES['genie_img']['tmp_name'])) {
                    $errors["files"]["genie"] = $this->testFile($_FILES['genie_img'], $maxFileSize, $extensionOk);
                    if (empty($errors["files"]['genie'])) {
                        $genie['genie_img'] = $this->manageFile($_FILES['genie_img'], $uploadDir);
                    }
                }

                if (file_exists($_FILES['lamp_img']['tmp_name'])) {
                    $errors["files"]["lamp"] = $this->testFile($_FILES['lamp_img'], $maxFileSize, $extensionOk);
                    if (empty($errors["files"]['lamp'])) {
                        $genie['lamp_img'] = $this->manageFile($_FILES['lamp_img'], $uploadDir);
                    }
                }

                if (empty($errors["files"]['genie']) && empty($errors["files"]['lamp'])) {
                    $this->genieManager->update($id, $genie);
                    header("Location:/admin/genie?id=$id");
                    return;
                }
            }
            $_SESSION['errorsUpdate'] = $errors;
            header("Location:/admin/genie/update?id=$id");
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

        if ($inputs['nb_wishes'] < 1) {
            $errors['input']['nb_wishes'] = 'Le génie doit avoir au moins un voeux';
        }

        if ($inputs['costPerDay'] < 1) {
            $errors['input']['costPerDay'] = 'Le prix doit être supérieur à 1€';
        }
        return $errors;
    }

    public function showAllGenies()
    {
        $specialties = $this->specialtyManager->selectAll();
        $genies = $this->genieManager->selectAllGenies();
        $errorsMessage = '';

        if (isset($_SESSION['errorsMessage'])) {
            $errorsMessage = $_SESSION['errorsMessage'];
            unset($_SESSION['errorsMessage']);
        }

        return $this->twig->render(
            'Genies/showAllGenies.html.twig',
            [
                'genies' => $genies,
                'specialties' => $specialties,
                'errorsMessage' => $errorsMessage
            ]
        );
    }
}
