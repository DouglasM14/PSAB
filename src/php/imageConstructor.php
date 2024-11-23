<?php
require_once "../../src/classes/Barber.php";

function imageConstructor($image)
{
    try {
        if (isset($image) && $image['error'] == 0) {
            $photo = $image;

            $extension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));
            $photo['name'] = 'barber';

            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                return false;
            }

            $newName = uniqid(pathinfo($photo['name'], PATHINFO_FILENAME));
            $newName = str_replace('.' . $extension, '', $newName);

            $serverPath = __DIR__ . '/../../db/uploadBarber/';
            $fullPath = $serverPath . $newName . "." . $extension;

            $isMoved = move_uploaded_file($photo['tmp_name'], $fullPath);

            if ($isMoved) {
                return $newName . '.' . $extension;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch (Exception $e) {
        return "Erro ao cadastrar Barbeiro: " . $e->getMessage();
    }
}
