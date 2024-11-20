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
                        <div id="daysOff" onload="generateInputsDaysOff()">
                            <h3>Alterar dias de trabalho:</h3>

                        </div>

                        <div id="hoursList"></div>

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
        function generateInputsDaysOff() {
            const hoursList = document.getElementById('hoursList')
            hoursList.innerHTML = ''

            let date = new Date(day + 'T00:00:00');
        }

        function cu() {
            fetch('', {
                method: 'GET',

            })
        }

        // <?php
        // // Dados simulados
        // $barbers = [
        //     1 => ["dates" => ["2024-11-27", "2024-11-28"]],
        //     2 => ["dates" => ["2024-11-20", "2024-11-21"]],
        //     3 => ["dates" => []]
        // ];

        // // ID do barbeiro enviado pela requisição
        // $barberId = isset($_GET['barberId']) ? (int)$_GET['barberId'] : 0;

        // // Retorna os dados do barbeiro correspondente
        // if (isset($barbers[$barberId])) {
        //     echo json_encode($barbers[$barberId]);
        // } else {
        //     echo json_encode(["dates" => []]);
        // }
        // ?>


        // const barberIdSelect = document.getElementById('barberId');
        // const unavailabilityDiv = document.getElementById('unavailability');

        // // Função para buscar dados do barbeiro
        // function fetchBarberData(barberId) {
        //     fetch(`getBarberData.php?barberId=${barberId}`)
        //         .then(response => {
        //             if (!response.ok) {
        //                 throw new Error('Erro ao buscar dados');
        //             }
        //             return response.json();
        //         })
        //         .then(data => {
        //             displayUnavailability(data.dates);
        //         })
        //         .catch(error => {
        //             console.error('Erro:', error);
        //         });
        // }

        // // Função para exibir as datas como checkboxes
        // function displayUnavailability(dates) {
        //     unavailabilityDiv.innerHTML = ''; // Limpa o conteúdo anterior
        //     if (dates.length > 0) {
        //         dates.forEach(date => {
        //             const checkbox = document.createElement('input');
        //             checkbox.type = 'checkbox';
        //             checkbox.name = 'unavailable_dates[]';
        //             checkbox.value = date;

        //             const label = document.createElement('label');
        //             label.textContent = date;

        //             label.prepend(checkbox);
        //             unavailabilityDiv.appendChild(label);
        //             unavailabilityDiv.appendChild(document.createElement('br'));
        //         });
        //     } else {
        //         unavailabilityDiv.innerHTML = '<p>Sem indisponibilidades para este barbeiro.</p>';
        //     }
        // }

        // // Evento para detectar mudanças no dropdown
        // barberIdSelect.addEventListener('change', () => {
        //     const selectedBarberId = barberIdSelect.value;
        //     fetchBarberData(selectedBarberId);
        // });

        // // Busca inicial (para o barbeiro 1)
        // fetchBarberData(1);
    </script>
</body>

</html>