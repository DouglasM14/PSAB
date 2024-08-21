<?php 
include "../src/config/php/conection.php";
include_once "../src/config/php/protect.php";

print_r($_POST)

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
        <h1>PSAB - Página de Agendamento</h1>
    </header>

    <main>
        <section>
            <form action="#" method="post">
                <div>
                    <label for="">Escolha o Barbeiro: </label>
                    <select name="barber" id="" multiple size="3">
                        <option value="1">Tico</option>
                        <option value="2">Barbeiro 1</option>
                        <option value="3">Barbeiro 2</option>
                    </select>
                </div>
                <div>
                    <label for="">Escolha a hora</label>
                    <input type="time" name="time">
                </div>
                <div>
                    <label for="">Escolha o dia.</label>
                    <input type="date" name="date">
                </div>

                <button type="submit">Marcar Horário</button>
            </form>
        </section>
    </main>

    <Footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis 2024</p>
    </Footer>
</body>

</html>