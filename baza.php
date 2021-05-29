<link rel="stylesheet" href="style.css">
<?php
include 'connect.php';

$table = $database->query('SELECT * FROM tab') ?: die('Nie udało się pobrać zawartości tabeli. Spróbuj ponownie później.');

$json = json_encode($table->fetchAll(PDO::FETCH_ASSOC));
?>

<table border>
    <tbody>
        <template>
            <tr>
                <td class="row-number"></td>
                <td><input class="id" disabled></td>
                <td><input name="login"></td>
                <td><input name="password"></td>
                <td><button data-action="duplicate">duplikuj</button></td>
                <td><button data-action="delete">x</button></td>
                <td><button data-action="clear">wyczyść</button></td>
            </tr>
        </template>
    </tbody>
</table>

<script>
    const tbody = document.querySelector("tbody");
    const template = tbody.querySelector("template");
    const data = <?= $json ?>;

    for (const { id, login, pass } of data) {
        const row = template.content.cloneNode(true);
        row.querySelector(".id").value = id;
        row.querySelector("[name=login]").value = login;
        row.querySelector("[name=password]").value = pass;
        tbody.append(row);
    }

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
                        clone.querySelector(".id").value = id;
                        tbody.append(clone);
                    });
                break;
            case 'delete':
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