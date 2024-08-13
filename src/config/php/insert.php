<?php

$nameClient = $_POST["nameClient"];
$emailClient = $_POST["emailClient"];
$passwordClient = $_POST["passwordClient"];

try{
    include "conection.php";

    $sql = $conn->prepare("SELECT nameClient FROM tb_client WHERE emailClient = ' $emailClient ' LIMIT 1");
    $sql->execute();

    $row = $sql->rowCount();

    if($row == 1){
        echo "usuário existente";
        echo "<p>
        <a href=\"..\..\..\public\login.php\">voltar a área de login</a>
        </p>";
    }else{
        echo "cadastre-se";
    }
    
}catch(PDOException $e){
    echo "Falha ao inserir os dados", $e -> getMessage();
}