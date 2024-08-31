<?php
include_once "../src/config/php/conection.php";

if (isset($_POST['email']) || isset($_POST['password'])) {
    if (strlen($_POST['email'])  == 0 || strlen($_POST['password']) == 0) {
        echo "<script>alert('Preencha os campos corretamente')</script>";
    } else {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $idUser = "id";
        $nameUser = "name";

        if (strpos($email, "@karraro.com")) {
            $query = "SELECT idBarber, nameBarber FROM tb_barber WHERE emailBarber = '$email' AND passwordBarber = '$password' UNION SELECT idAdm, nameAdm FROM tb_adm WHERE emailAdm = '$email' AND passwordAdm = '$password' LIMIT 1";

            $idUser .= 'Barber';
            $nameUser .= 'Barber';
            $userPage = "barberAccount.php";
        } else {
            $query = "SELECT * FROM tb_client WHERE emailClient = '$email' AND passwordClient = '$password' LIMIT 1";

            $idUser .= 'Client';
            $nameUser .= 'Client';
            $userPage = "clientAccount.php";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1) {

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['idUser'] = $resultado[$idUser];
            $_SESSION['nameUser'] = $resultado[$nameUser];

            header('Location:' . $userPage);
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
                    <label for="email">Email: </label>
                    <input type="text" name="email" id="" value="">
                </div>

                <div>
                    <label for="password">Senha: </label>
                    <input type="password" name="password" id="password">
                    <span class="toggle-password" onclick="togglePassword('password', '.toggle-password')">👁️</span>

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

    <script src="assets/js/showPass.js"></script>
</body>

</html>