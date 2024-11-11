<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['nameBarber'];
    $email = $_POST['emailBarber'];
    $pass = $_POST['passwordBarber'];
    $photo = $_POST['photoBarber'];

    $barber = new Barber($_SESSION['idBarber']);

    $register = $barber->registerBarber($name, $email, $pass);

    // echo "<pre>";
    // print_r($register);
    // echo "</pre>";

    // if ($register) {
    //     header("Location: BarberAccount.php");
    // } else {
    //     echo "Erro ao inserir dados.";
    // }
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
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                <div>
                    <label for="nameBarber">Nome: </label>
                    <input type="text" name="nameBarber" id="">
                </div>

                <div>
                    <label for="emailBarber">Email: </label>
                    <input type="text" name="emailBarber" id="">
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
                    <input type="file" name="photoBarber" id="">
                </div>

                <input type="submit" value="Se cadastrar">
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