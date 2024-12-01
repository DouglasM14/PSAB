<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

verifyLogin('barber');

$barber = new Barber($_SESSION['idUser']);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAB</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
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
        </section>

        <section>
            <h2>Editar a agenda</h2>
            <label for="daysHours">Escolha se deseja desativar dia ou hora</label>
            <br>
            <label for="days">
                <input type="radio" name="daysHours" id="days" onclick="generateInputsDaysHours('days')"> Dia Inteiro
            </label>
            <br>
            <label for="hours">
                <input type="radio" name="daysHours" id="hours" onclick="generateInputsDaysHours('hours')"> Horário Específico
            </label>
            <br>
            <div id="inputContainer"></div>
            <br>
            <button onclick="postBarberDayOff('desativate')">Desativar</button>
            <button onclick="postBarberDayOff('ativate')">Ativar</button>
        </section>

        <section>
            <h3>Horários desativados</h3>
            <table>
                <thead>

                    <th>Dia</th>
                    <th>Hora</th>
                </thead>

                <tbody id="tbody"></tbody>
            </table>
        </section>

    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>

    <script>
        function generateInputsDaysHours(option) {
            const inputContainer = document.getElementById('inputContainer');
            inputContainer.innerHTML = ''; // Limpa os inputs anteriores

            // Cria o input de data
            const inputDate = document.createElement('input');
            inputDate.type = 'date';
            inputDate.name = 'date';
            inputDate.id = 'inputDate';
            inputContainer.appendChild(inputDate);

            if (option === 'hours') {
                // Cria o input de hora apenas para a opção 'hours'
                const inputTime = document.createElement('input');
                inputTime.type = 'time';
                inputTime.name = 'time';
                inputTime.id = 'inputTime';
                inputContainer.appendChild(inputTime);
            }
        }


        async function postBarberDayOff(action) {
            try {
                const inputDate = document.getElementById('inputDate');
                const inputTime = document.getElementById('inputTime');

                if (!inputDate || !inputDate.value) {
                    alert('Por favor, selecione uma data.');
                    return;
                }

                const formData = new FormData();
                formData.append('date', inputDate.value);

                if (inputTime && inputTime.value) {
                    formData.append('time', inputTime.value);
                }

                if (action === 'ativate') formData.append('option', "ativate")
                if (action === 'desativate') formData.append('option', "desativate")


                const response = await fetch("../../src/php/getUnavibility.php?", {
                    method: "POST",
                    body: formData,
                });

                if (!response.ok) {
                    throw new Error('Erro ao enviar os dados. Tente novamente.');
                }

                const data = await response.json();

                await getBarberDayOff()
            } catch (error) {
                console.error(error);
            }
        }

        async function getBarberDayOff() {
            try {
                const response = await fetch("../../src/php/getUnavibility.php");

                if (!response.ok) {
                    throw new Error("Erro ao pegar os dados.");
                }

                const data = await response.json();
                const daysOff = JSON.parse(data)

                const tbody = document.getElementById('tbody');
                tbody.innerHTML = '';

                if (daysOff.length > 0) {
                    daysOff.forEach(element => {
                        if (element.date && element.times && element.times.length > 0) {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                        <td>${element.date}</td>
                        <td>${element.times.join(', ')}</td>
                    `;
                            tbody.appendChild(tr);
                        }
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="2">Nenhum horário desmarcado</td></tr>';
                }
            } catch (error) {
                console.error(error);
            }
        }

        addEventListener("DOMContentLoaded", getBarberDayOff())
    </script>
</body>

</html>