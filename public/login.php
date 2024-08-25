<?php
require_once "../src/config/php/conection.php";

if (isset($_POST['emailClient']) || isset($_POST['passwordClient'])) {
    if (strlen($_POST['emailClient'])  == 0 || strlen($_POST['passwordClient']) == 0) {
        echo "<script>alert('Preencha os campos corretamente')</script>";

    } else {
        //não achei um jeito bom de prevenir o SQL injection com PDO. Deixei o jeito em mysqli em baixo(serve pra senha tbm)
        // $email = $mysqli->real_escape_string($_POST['emailClient']);

        $emailClient = $_POST['emailClient'];
        $passwordClient = $_POST['passwordClient'];

        $stmt = $conn->prepare("SELECT * FROM tb_client WHERE emailClient = '$emailClient' AND passwordClient = '$passwordClient' LIMIT 1");// or die("Error: ");
        $stmt->execute();
        //flata ad o erro com PDOExecption
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if ($stmt->rowCount() == 1) {

        //falta a verificação de erro, q mata o códido. Deixei o jeito em mysqli em baixo
        //$sql_query = $mysqli->query($sql_code) or die('erro: ' . mysqli->error);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1) {


            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['idClient'] = $result['idClient'];
            $_SESSION['nameClient'] = $result['nameClient'];

            echo $_SESSION['idClient'], $_SESSION['nameClient'];

            // header('Location: clientAccount.php');
        } else {
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
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
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
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis 2024</p>
    </Footer>
</body>

</html>