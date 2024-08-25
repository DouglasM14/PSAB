<?php

$nameClient = $_POST["nameClient"];
$emailClient = $_POST["emailClient"];
$passwordClient = $_POST["passwordClient"];


try{
    require_once "conection.php";

    $sql = $conn->prepare("SELECT nameClient FROM tb_client WHERE emailClient = '$emailClient' LIMIT 1");
    $sql->execute();

    $row = $sql->rowCount();

    if($row == 1){
        echo "usuário existente";
        echo "<p>
        <a href=\"..\..\..\public\login.php\">voltar a área de login</a>
        </p>";

    }else{
        $query = $conn->prepare("INSERT INTO tb_client (nameClient, emailClient, passwordClient) VALUES (:nameClient, :emailClient, :passwordClient)");
        $query->bindValue('nameClient', $nameClient);
        $query->bindValue('emailClient', $emailClient);
        $query->bindValue('passwordClient', $passwordClient);
        $query->execute();

        echo "tudo nos conformes";
    }
    
}catch(PDOException $e){
    echo "Falha ao inserir os dados", $e -> getMessage();
}