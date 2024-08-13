<?php

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['idClient'])){
    die("Você não pode acessar acessar esta página.<p>
    <a href=\"..\..\..\public\index2.php\">Voltar ao Menu Inicial</a>
    </p>");
}
