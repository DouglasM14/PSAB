<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Client.php";
require_once '../../src/classes/Barber.php';

verifyLogin('client');

// Inicializa a lista de barbeiros
$barber = new Barber();
$barberList = $barber->barberList();

// Recupera o ID do barbeiro da sessão
$barberId = $_SESSION['idBarber'] ?? null;

// Realiza o SELECT padrão
$client = new Client($_SESSION['idUser']);
$result = $client->viewHistoric(); // Supondo que essa função execute o SELECT fornecido

?>
<!DOCTYPE html>
<html lang="en">

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

        img {
            height: 150px;
        }
    </style>
</head>

<body>
    <header>
        <h1>PSAB - Histórico do Cliente</h1>
    </header>

    <main>
        <section>
            <h3>Filtrar Histórico</h3>
            <label for="dayFilter">Filtrar por Dia</label>
            <input name="dayFilter" type="date" id="dayFilter">
            <br>
            <label for="monthFilter">Filtrar por Mês</label>
            <input name="monthFilter" type="month" id="monthFilter">
            <br>
            <label for="barberFilter">Filtrar por Barbeiro</label>
            <select name="barberFilter" id="barberFilter">
                <option value=""></option>
                <?php foreach ($barberList as $b): ?>
                    <option value="<?= htmlspecialchars($b['idBarber']) ?>"><?= htmlspecialchars($b['nameBarber']) ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="statusFilter">Filtrar por Status</label>
            <select name="statusFilter" id="statusFilter">
                <option value=""></option>
                <option value="on">Ativo</option>
                <option value="end">Concluído</option>
                <option value="cancel">Cancelado</option>
                <option value="absent">Ausente</option>
            </select>
            <br>
            <button onclick="fetchFilter()">Buscar</button>
            <button onclick="cleanFilter()">Limpar Filtros</button>
            <br>
        </section>

        <section>
            <h3>Histórico</h3>
            <table>
                <thead>
                    <tr>
                        <th>Foto do Barbeiro</th>
                        <th>Nome do Barbeiro</th>
                        <th>Dia do Corte</th>
                        <th>Hora do Corte</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                </tbody>
            </table>
        </section>

        <section>
            <a href="clientAccount.php">Voltar</a>
        </section>
    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>

    <script>
        function fetchFilter() {
            const day = document.getElementById('dayFilter').value;
            const month = document.getElementById('monthFilter').value;
            const barber = document.getElementById('barberFilter').value;
            const status = document.getElementById('statusFilter').value;

            const formData = new FormData();
            if (day) formData.append("dayFilter", day);
            if (month) formData.append("monthFilter", month);
            if (barber) formData.append("barberFilter", barber);
            if (status) formData.append("statusFilter", status);

            fetch('../../src/php/filterHistoric.php', {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('tableBody');
                    tbody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(row => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                            <td><img src="../../db/uploadBarber/${row.photoBarber}"></td>
                            <td>${row.nameBarber}</td>
                            <td>${row.dateSchedule}</td>
                            <td>${row.timeSchedule}</td>
                            <td>${row.stateSchedule}</td>
                        `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        
                        tbody.innerHTML = '<tr><td colspan="5">Nenhum registro encontrado</td></tr>';
                    }
                })
                .catch(error => console.error("Erro ao buscar dados:", error));
        }

        function cleanFilter() {
            document.getElementById('dayFilter').value = '';
            document.getElementById('monthFilter').value = '';
            document.getElementById('barberFilter').value = '';
            document.getElementById('statusFilter').value = '';
            fetchFilter();
        }

        addEventListener('DOMContentLoaded', fetchFilter())
    </script>
</body>

</html>