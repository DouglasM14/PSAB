<?php

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['idClient'])){
    die("Você não está logado.
    <p>
    <a href=\"..\..\..\public\login.php\">Logar</a>
    </p>");
}
