<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    protected Environment $twig;

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => (ENV === 'dev'),
            ]
        );
        $this->twig->addExtension(new DebugExtension());
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
