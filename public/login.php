<?php 

include "../src/config/php/conection.php";

if(isset($_POST['emailClient']) || isset($_POST['passwordClient'])){
    //a verificação de campos aqui, poderia ser feita com um or
    if(strlen($_POST['emailClient'])  == 0){
        echo "<script>alert('Preencha o campo email')</script>";
    }else if(strlen($_POST['passwordClient']) == 0){
        echo "<script>alert('Preencha o campo senha')</script>";
    }else{
        //não achei um jeito bom de prevenir o SQL injection com PDO. Deixei o jeito em mysqli em baixo(serve pra senha tbm)
        // $email = $mysqli->real_escape_string($_POST['emailClient']);

        $email = $_POST['emailClient'];
        $senha = $_POST['passwordClient'];

        $sql = $conn->prepare("SELECT * FROM tb_client WHERE emailClient = '$email' AND passwordClient = '$senha' ");
        $sql->execute();

        //falta a verificação de erro, q mata o códido. Deixei o jeito em mysqli em baixo
        //$sql_query = $mysqli->query($sql_code) or die('erro: ' . mysqli->error);

        $quantidade = $sql->rowCount();

        if($quantidade == 1){
            //fecthAll não está funcionando
            $cliente = $sql->fetch(PDO::FETCH_ASSOC);

            if(!isset($_SESSION)){
                session_start();
            }

            $_SESSION['idClient'] = $cliente['idClient'];
            $_SESSION['nameClient'] = $cliente['nameClient'];

            echo $_SESSION['idClient'], $_SESSION['nameClient'];
            
            header('Location: clientAccount.php');
            //O header envia para outra página com uma request HTTP

        }else{
            echo 'Falha ao logar! Email ou senha incorretos';
        }
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAB</title>
</head>

<body>
    <header>
        <h1>PSAB - login</h1>
    </header>

    <main>
        <section>
            <form action="" method="post">
                <div>
                    <label for="emailClient">Email: </label>
                    <input type="text" name="emailClient" id="" value="">
                </div>

                <div>
                    <label for="passwordClient">Senha: </label>
                    <input type="password" name="passwordClient" id="">
                    <p><a href="">Esqueceu sua senha?</a></p>
                </div>

                <input type="submit" value="Entrar">
            </form>

            <p>Não tem conta? <a href="register.php">Cadastra-se.</a></p>
        </section>

        <section>
            <a href="index2.php">Voltar</a>
        </section>
    </main>

    <Footer>
        <p>Site desenvolvido por Douglas & Eduardo</p>
        <p>Etec de Heliopolis 2024</p>
    </Footer>
</body>

</html>