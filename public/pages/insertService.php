<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Services.php";

verifyLogin('adm');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $expPrice = $_POST['expPrice'];

    $service = new Services();

    $serviceMsg = $service->insertService($name, $desc, $price, $expPrice);

    $_SESSION['msg'] = $serviceMsg;
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
    <header>
        <h1>PSAB - Cadastrar Serviços</h1>
    </header>

    <main>
        <section>
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                <div>
                    <label for="">Nome: </label>
                    <input type="text" name="name">
                </div>

                <div>
                    <label for="">Descrição do Serviço: </label>
                    <input type="text" name="desc">
                </div>

                <div>
                    <label for="">Preço: </label>
                    <input type="number" name="price">
                </div>

                <div>
                    <label for="">Preço fim de semana: </label>
                    <input type="number" name="expPrice">
                </div>

                <input type="submit" value="Cadastrar Serviço">
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
</body>

</html>