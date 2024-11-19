<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

verifyLogin('adm');

if (isset($_GET["a"])) {
    $_SESSION['idBarber'] = $_GET["a"];
    $barber = new Barber($_GET["a"], 'barber');
} else {
    $barber = new Barber($_SESSION["idBarber"], 'barber');
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST["nameBarber"];
    $email = $_POST["emailBarber"];
    $pass = $_POST["passwordBarber"];

    $resultMsg = $barber->updateBarber($name, $email, $pass);

    echo "<pre>";
    print_r($resultMsg);
    echo "</pre>";

    $_SESSION['msg'] = $resultMsg;
    header("location: admAccount.php");
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

    <body>
        <header>
            <h1>PSAB - Editar Barbeiro</h1>
        </header>

        <main>
            <section>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                    <div>
                        <label for="nameBarber">Nome:</label>
                        <input name="nameBarber" value="<?php echo $barber->getNameBarber() ?>" type="text">
                    </div>

                    <div>
                        <label for="emailBarber">Email:</label>
                        <input name="emailBarber" value="<?php echo $barber->getEmailBarber() ?>" type="text">
                    </div>

                    <div>
                        <label for="passwordBarber">senha:</label>
                        <input name="passwordBarber" value="<?php echo $barber->getPasswordBarber() ?>" type="text">
                    </div>

                    <div>
                        <label for="">Preço:</label>
                        <!-- <input name="photoBarber" value="<?php // echo $barber->getImageBarber() ?>" type="file"> -->
                    </div>

                    <div>
                        <button type="submit">Editar</button>
                    </div>
                </form>
            </section>

            <section>
                <p>
                    <a href="barberAccount.php">Voltar</a>
                </p>
            </section>
        </main>

        <footer>
            <p>Site desenvolvido por Nexiun Technologies</p>
            <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
        </footer>
    </body>

</html>