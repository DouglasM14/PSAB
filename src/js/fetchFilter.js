function fetchFilter() {
    const day = document.getElementById('dayFilter').value;
    const month = document.getElementById('monthFilter').value;
    const barber = document.getElementById('barberFilter') ? document.getElementById('barberFilter').value : null;
    const client = document.getElementById('clientFilter') ? document.getElementById('clientFilter').value : null;
    const status = document.getElementById('statusFilter').value;

    const formData = new FormData();
    if (day) formData.append("dayFilter", day);
    if (month) formData.append("monthFilter", month);
    if (barber) formData.append("barberFilter", barber);
    if (client) formData.append("clientFilter", client);
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
                        ${row.photoBarber ? `<td><img src="../../db/uploadBarber/${row.photoBarber}" alt="Foto do barbeiro"></td>` : ''}
                        ${row.nameBarber ? `<td>${row.nameBarber}</td>` : ''}
                        ${row.nameClient ? `<td>${row.nameClient}</td>` : ''}
                        <td>${row.dateSchedule}</td>
                        <td>${row.timeSchedule}</td>
                        <td>${row.stateSchedule}</td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="6">Nenhum registro encontrado</td></tr>';
            }
        })
        .catch(error => console.error("Erro ao buscar dados:", error));
}

function cleanFilter() {
    document.getElementById('dayFilter').value = '';
    document.getElementById('monthFilter').value = '';
    document.getElementById('barberFilter') ? document.getElementById('barberFilter').value = '' : null;
    document.getElementById('clientFilter') ? document.getElementById('clientFilter').value = '' : null;
    document.getElementById('statusFilter').value = '';
    fetchFilter();
}

addEventListener('DOMContentLoaded', fetchFilter())