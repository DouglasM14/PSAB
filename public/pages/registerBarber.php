<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";
require_once "../../src/php/imageConstructor.php";

// verifyLogin('adm');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['nameBarber']) ? $_POST['nameBarber'] : null;
    $email = isset($_POST['emailBarber']) ? $_POST['emailBarber'] : null;
    $pass = isset($_POST['passwordBarber']) ? $_POST['passwordBarber'] : null;
    $photo = imageConstructor($_FILES['photoBarber']);

    $barber = new Barber($_SESSION['idBarber']);

    $barber->registerBarber($name, $email, $pass, $photo);
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
        <h1>PSAB - Registrar Barbeiro</h1>
    </header>

    <main>
        <section>
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="nameBarber">Nome: </label>
                    <input type="text" name="nameBarber">
                </div>

                <div>
                    <label for="emailBarber">Email: </label>
                    <input type="text" name="emailBarber">
                </div>

                <!-- <div>
                    <label for="emailBarber">Agenda: </label>
                    <input type="text" name="emailBarber" id="">
                </div> -->

                <div>
                    <label for="passwordBarber">Senha: </label>
                    <input type="password" name="passwordBarber" id="password">
                    <span class="toggle-password" onmouseleave="togglePassword('password', '.toggle-password')" onmouseenter="togglePassword('password', '.toggle-password')">👁️</span>
                </div>

                <div>
                    <label for="password">Repita a senha: </label>
                    <input type="password" name="password2" id="password2">
                    <span class="toggle-password2" onclick="togglePassword('password2', '.toggle-password2')">👁️</span>
                </div>

                <div>
                    <label for="photoBarber">Foto: </label>
                    <input type="file" name="photoBarber">
                </div>

                <input type="submit" value="Cadastrar barbeiro">
            </form>
        </section>

        <section>
            <a href="admAccount.php">Voltar</a>
        </section>
    </main>

    <Footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis 2024</p>
    </Footer>

    <script src="../assets/js/showPass.js"></script>
</body>

</html>