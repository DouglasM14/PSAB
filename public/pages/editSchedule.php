<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

verifyLogin('barber');

$barber = new Barber($_SESSION['idUser']);

$barberSchedule = json_decode($barber->getSchedule());

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    # code...
}

echo "<pre>";
print_r($barberSchedule);
echo "</pre>";

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
        <h1>PSAB - Perfil do Barbeiro</h1>
    </header>

    <main>
        <section>
            <p>
                <a href="barberAccount.php">Voltar</a>
            </p>

            <section>
                <h2>Editar a agenda</h2>

                <div>
                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                        <div id="daysList" onload="generateInputsDaysOff()">
                            <h3>Alterar dias de trabalho:</h3>
                            <div id="daysOff"></div>

                        </div>


                    </form>
                </div>
            </section>
        </section>

    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>

    <script>
        const daysListDiv = document.getElementById('daysList');
        const daysOffDiv = document.getElementById('daysOff');
        const barber = <?= $barber->getIdBarber() ?>

        function displayUnavailability(dates) {
            if (dates.length > 0) {
                dates.forEach(date => {
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'unavailableDates';
                    checkbox.value = date;

                    const label = document.createElement('label');
                    label.textContent = date;

                    label.prepend(checkbox);
                    daysOffDiv.appendChild(label);
                    daysOffDiv.appendChild(document.createElement('br'));
                });
            }
        }

        // Evento para detectar mudanças no dropdown
        // daysListDiv.addEventListener('change', () => {
        //     const selectedBarberId = daysListDiv.value;
        //     fetchBarber(selectedBarberId);
        // });

        function fetchBarber(barber) {
            fetch(`../../src/php/getSchedule.php?b=${barber}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao buscar dados');
                    }
                    return response.json();
                })
                .then(data => {
                    displayUnavailability(data.dates);
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
        }
        fetchBarber(barber);
    </script>
</body>

</html>