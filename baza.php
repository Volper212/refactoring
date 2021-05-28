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
                <td><input value="${row.login}" name="login"></td>
                <td><input value="${row.pass}" name="password"></td>
                <td><button data-action="duplicate">duplikuj</button></td>
                <td><button data-action="delete">x</button></td>
                <td><button data-action="clear">wyczyść</button></td>
            </tr>`
        );
    });

    tbody.addEventListener('input', ({ target }) => {
        const row = target.parentElement.parentElement;
        const id = row.querySelector(".id").value;
        const { name, value } = target;

        fetch(`edit.php?name=${name}&value=${value}&id=${id}`);
    });

    tbody.addEventListener('click', ({ target }) => {
        const { action } = target.dataset;
        if (action == null)
            return; 
        const row = target.parentElement.parentElement;
        const id = row.querySelector(".id").value;

        const request = fetch(`${action}.php?id=${id}`);

        switch (action) {
            case 'duplicate':
                request
                    .then(response => response.json())
                    .then(id => {
                        const clone = row.cloneNode(true);
                        clone.querySelector(".row-number").textContent = tbody.children.length + 1;
                        clone.querySelector(".id").value = id;
                        tbody.append(clone);
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
                for (const input of row.querySelectorAll("input:not(:disabled)")) {
                    input.value = '';
                }
                break;
        }
    });
</script>