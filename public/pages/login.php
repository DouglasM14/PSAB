<?php
require_once '../../src/classes/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = new User($email, $password);

    $result = $user->login();

    if (!$result) {
        echo '<p>Email ou senha incorretos.</p>';
    }

    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
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
                    <input type="text" name="email" id="">
                </div>

                <div>
                    <label for="password">Senha: </label>
                    <input type="password" name="password" id="password">
                    <span class="toggle-password" onclick="togglePassword('password', '.toggle-password')">👁️</span>

                    <p><a href="#">Esqueceu sua senha?</a></p>
                </div>

                <input type="submit" value="Entrar">
            </form>

            <p>Não tem conta? <a href="registerClient.php">Cadastra-se.</a></p>
        </section>

        <section>
            <a href="../index2.php">Voltar</a>
        </section>
    </main>

    <Footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </Footer>

    <script src="../assets/js/showPass.js"></script>
</body>

</html>