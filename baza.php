<link rel="stylesheet" href="style.css">
<?php
include 'connect.php';

$table = $database->query('SELECT * FROM tab') ?: die('Nie udało się pobrać zawartości tabeli. Spróbuj ponownie później.');

$json = json_encode($table->fetchAll(PDO::FETCH_ASSOC));
?>

<table border>
    <tbody></tbody>
</table>

<script>
    const tbody = document.querySelector("tbody");
    const data = <?= $json ?>;

    data.forEach((row, index) => {
        tbody.insertAdjacentHTML("beforeend",
            `<tr>
                <td class="row-number">${index + 1}</td>
                <td><input value="${row.id}" class="id" disabled></td>
                <td><input value="${row.login}" name="1" data-action="edit"></td>
                <td><input value="${row.pass}" name="2" data-action="edit"></td>
                <td><button data-action="duplicate">duplikuj</button></td>
                <td><button data-action="delete">x</button></td>
                <td><button data-action="clear">wyczyść</button></td>
            </tr>`
        );
    });

    tbody.addEventListener('input', handleEvent);
    tbody.addEventListener('click', handleEvent);

    function handleEvent({ target }) {
        const name = target.name;
        const value = target.value;
        const row = target.parentElement.parentElement;
        const id = row.querySelector(".id").value;
        const action = target.dataset.action;

        const request = fetch(`odp.php?name=${name}&value=${value}&id=${id}&action=${action}`);

        switch (action) {
            case 'duplicate':
                request
                    .then(response => response.json())
                    .then(data => {
                        tbody.insertAdjacentHTML("beforeend",
                            `<tr>
                                <td class="row-number">${tbody.children.length + 1}</td>
                                <td><input value="${data[0][0]}" class="id" disabled></td>
                                <td><input value="${data[0][1]}" name="1" data-action="edit"></td>
                                <td><input value="${data[0][2]}" name="2" data-action="edit"></td>
                                <td><button data-action="duplicate">duplikuj</button></td>
                                <td><button data-action="delete">x</button></td>
                                <td><button data-action="clear">wyczyść</button></td>
                            </tr>`
                        );
                    });
                break;
            case 'delete':
                let current = row;
                while (current = current.nextElementSibling) {
                    current.querySelector(".row-number").textContent--;
                }
                row.remove();
                break;
            case 'clear':
                row.getElementsByTagName('input')[1].value = '';
                row.getElementsByTagName('input')[2].value = '';
                break;
        }
    }
</script>