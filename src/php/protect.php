<?php
if (!isset($_SESSION)) {
    session_start();
}

function verifyLogin($typeUser)
{
    if ($_SESSION['typeUser'] != $typeUser) {
        header('location: ../../public/index2.php');
        die();
    }
}
