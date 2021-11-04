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
        parent:: __construct();
        $this -> genieManager = new GenieManager();
        $this -> specialtyManager = new SpecialtyManager();
    }

    public function add(): string
    {
        $specialties = $this->specialtyManager->selectNameId();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $genie = array_map('trim', $_POST);
            $genie = array_map('htmlentities', $genie);

            $errors = $this-> testInput($genie);

            $uploadDir = '../public/assets/images';
            $extensionOk = ['jpg','jpeg','png'];
            $maxFileSize = 2000000;

            if (empty($errors)) {
                if (file_exists($_FILES['genie_img']['tmp_name']) && file_exists($_FILES['lamp_img']['tmp_name'])) {
                    $genie['genie_img'] = $this->testFile($_FILES['genie_img'], $maxFileSize, $extensionOk);
                    $genie['lamp_img'] = $this->testFile($_FILES['lamp_img'], $maxFileSize, $extensionOk);

                    $genie['genie_img'] = $this->manageFile($_FILES['genie_img'], $uploadDir);
                    $genie['lamp_img'] = $this->manageFile($_FILES['lamp_img'], $uploadDir);

                    $this->genieManager->insert($genie);
                    header('Location:/genies/add');
                }
            } else {
                return $this->twig->render(
                    'Admin/addGenie.html.twig',
                    ['specialties' => $specialties, 'errors' => $errors]
                );
            }
        }
        return $this->twig->render('Admin/addGenie.html.twig', ['specialties' => $specialties]);
    }

    public function testInput(array $inputs): array
    {
        $errors = [];
        foreach ($inputs as $input) {
            if (empty($input)) {
                $errors['empty'] = 'Tous les champs sont requis';
                return $errors;
            }
        }

        if ($inputs['nb_wishes'] < 1) {
            $errors['nb_wishes'] = 'Le génie doit avoir au moins un voeux';
        }

        if ($inputs['costPerDay'] < 1) {
            $errors['costPerDay'] = 'Le prix doit être supérieur à 1€';
        }
        return $errors;
    }

    public function manageFile(array $file, string $uploadDir): string
    {
        $extensionFile = pathinfo($file['name'], PATHINFO_EXTENSION);
        $name = explode('.', $file['name']);
        $fileNameNew = uniqid($name[0], true) . '.' . $extensionFile;
        $fileDestination = $uploadDir . $fileNameNew;

        move_uploaded_file($file['tmp_name'], $fileDestination);

         return $fileDestination;
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
