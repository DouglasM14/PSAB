<?php
include_once "../src/config/php/conection.php";

if (isset($_POST['emailClient']) || isset($_POST['passwordClient'])) {
    if (strlen($_POST['emailClient'])  == 0 || strlen($_POST['passwordClient']) == 0) {
        echo "<script>alert('Preencha os campos corretamente')</script>";

    } else {

        $emailClient = $_POST['emailClient'];
        $senhaClient = $_POST['passwordClient'];

        $stmt = $conn->prepare("SELECT * FROM tb_client WHERE emailClient = '$emailClient' AND passwordClient = '$senhaClient' LIMIT 1");
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1) {

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['idClient'] = $resultado['idClient'];
            $_SESSION['nameClient'] = $resultado['nameClient'];

            header('Location: clientAccount.php');
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