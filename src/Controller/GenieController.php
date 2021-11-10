<?php

namespace App\Controller;

use App\Model\GenieManager;
use App\Model\SpecialtyManager;

class GenieController extends AbstractController
{
    private GenieManager $genieManager;

    public function __construct()
    {
        parent::__construct();
        $this->genieManager = new GenieManager();
    }

    public function add(): void
    {
        session_start();

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
        session_start();

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

    public function manageFile(array $file, string $uploadDir): string
    {
        $extensionFile = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileNameNew = uniqid("", true) . '.' . $extensionFile;
        $fileDestination = $uploadDir . $fileNameNew;

        move_uploaded_file($file['tmp_name'], $fileDestination);

        return "/" . $fileDestination;
    }

    public function testFile(array $file, int $maxFileSize, array $extensionOk): array
    {
        $extensionFile = pathinfo($file['name'], PATHINFO_EXTENSION);
        $errors = [];

        if (filesize($file['tmp_name']) > $maxFileSize) {
            $errors['fileSize'] = 'Votre image doit faire moins de 2MO !';
        }
        if (!in_array($extensionFile, $extensionOk)) {
            $errors['extension'] = 'Veuillez selectionner une image avec une extension valide(jpg, jpeg ou png)';
        }
        return $errors;
    }
}
