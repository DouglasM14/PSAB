<?php
require_once "../../src/classes/Barber.php";

function imageConstructor($image)
{
    if (isset($image) && $image['error'] == false) {
        $photo = $image;

        $serverPath = __DIR__ . '/../../db/uploadBarber/';

        $webPath = '/db/uploadBarber/';

        $newName = uniqid(pathinfo($photo['name'], PATHINFO_FILENAME));

        $newName = str_replace('.jpg', '', $newName);

        $extension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));

        if ($extension != "jpg" && $extension != "png") {
            throw new Exception('Tipo de arquivo não aceito');
        }
        $fullPath = $serverPath . $newName . "." . $extension;

        $webPath .= $newName . "." . $extension;

        $isRight = move_uploaded_file($photo['tmp_name'], $fullPath);
        if ($isRight) {
            return $webPath;
        } else {
            throw new Exception('Um erro inesperado ocorreu');
        }
    } else {
        $photo = null;
        throw new Exception('Imagem não enviada ou inválida');
    }
}
