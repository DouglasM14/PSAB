<?php
require_once "../../src/php/protect.php";
require_once '../../src/classes/Barber.php';

verifyLogin('barber');

// Inicializa a lista de barbeiros
$barber = new Barber();
$barberList = $barber->barberList();

// Recupera o ID do barbeiro da sessão
$barberId = $_SESSION['idBarber'] ?? null;
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
        <h1>PSAB - Histórico do Barbeiro</h1>
    </header>

    <main>
        <section>
            <a href="barberAccount.php">Voltar</a>
        </section>

        <section>
            <h3>Filtrar Histórico</h3>
            <label for="dayFilter">Filtrar por Dia</label>
            <input name="dayFilter" type="date" id="dayFilter">
            <br>

            <label for="monthFilter">Filtrar por Mês</label>
            <input name="monthFilter" type="month" id="monthFilter">
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
                        <th>Nome do Cliente</th>
                        <th>Dia do Corte</th>
                        <th>Hora do Corte</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>
    <script src="../../src/js/fetchFilter.js"></script>
</body>

</html>