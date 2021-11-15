<?php

namespace App\Controller;

use App\Model\SpecialtyManager;

class SpecialtyController extends AbstractController
{

    private SpecialtyManager $specialtyManager;

    public function __construct()
    {
        parent::__construct();
        $this->specialtyManager = new SpecialtyManager();
    }

    public function add(): void
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $specialty = array_map('trim', $_POST);
            $specialty = array_map('htmlentities', $specialty);

            $errors = $this->testInput($specialty);

            $uploadDir = 'assets/images/';
            $extensionOk = ['jpg', 'jpeg', 'png', 'svg'];
            $maxFileSize = 2000000;

            if (file_exists($_FILES['specialty_img']['tmp_name'])) {
                $errors["files"]["specialty"] = $this->testFile($_FILES['specialty_img'], $maxFileSize, $extensionOk);
            } else {
                $errors["files"]["empty"] = "Veuillez renseigner une image pour la spécialité.";
            }

            if (empty($errors['input']) && empty($errors["files"]['specialty'])) {
                $specialty['specialty_img'] = $this->manageFile($_FILES['specialty_img'], $uploadDir);

                $this->specialtyManager->insert($specialty);
            }

            $_SESSION['errorsSpecialty'] = $errors;
            header('Location:/admin');
        }
    }
}
