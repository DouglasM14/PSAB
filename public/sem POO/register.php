<?php
require_once "../db/database.php";

$db = new Database;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dados = [
        'nameClient' => $_POST["nameClient"],
        'emailClient' => $_POST["emailClient"],
        'passwordClient' => $_POST["passwordClient"]
    ];

    if ($db->insert('tb_client', $dados)) {
        echo "Dados inseridos com sucesso!";
    } else {
        echo "Erro ao inserir dados.";
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
        <h1>PSAB - Registrar</h1>
    </header>

    <main>
        <section>
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                <div>
                    <label for="nameClient">Nome: </label>
                    <input type="text" name="nameClient" id="">
                </div>

                <div>
                    <label for="emailClient">Email: </label>
                    <input type="text" name="emailClient" id="">
                </div>

                <div>
                    <label for="passwordClient">Senha: </label>
                    <input type="password" name="passwordClient" id="password">
                    <span class="toggle-password" onmouseleave="togglePassword('password', '.toggle-password')" onmouseenter="togglePassword('password', '.toggle-password')">👁️</span>
                </div>

                <div>
                    <label for="password">Repita a senha: </label>
                    <input type="password" name="password" id="password2">
                    <span class="toggle-password2" onclick="togglePassword('password2', '.toggle-password2')">👁️</span>
                </div>

                <input type="submit" value="Se cadastrar">
            </form>

            <p>Já tem uma conta? <a href="login.php">Entre.</a></p>
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