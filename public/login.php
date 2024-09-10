<?php
require_once '../db/database.php';
require_once '../src/classes/Client.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database;

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User($email, $password);
    $userType = $user->getUserType();

    if($userType == "barber") {
        $db->select('tb_barber', '*', "emailBarber = '$email' AND passwordBarber = '$password' LIMIT 1"); 
    } else {
        $db->select('tb_client', '*', "emailClient = '$email' AND passwordClient = '$password' LIMIT 1"); 
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