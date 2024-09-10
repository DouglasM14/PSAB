<?php
if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['idUser'])){
    die("Você não está logado.
    <p>
    <a href=\"index2.php\">Logar</a>
    </p>");
}
