<link rel="stylesheet" href="style.css">
<?php
include 'connect.php';

$table = $database->query('SELECT * FROM tab') ?: die('Nie udało się pobrać zawartości tabeli. Spróbuj ponownie później.');

$json = json_encode($table->fetchAll(PDO::FETCH_NUM));
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

    function appendRow([id, login, password]) {
        const row = template.content.firstElementChild.cloneNode(true);
        row.querySelector(".id").value = id;
        row.querySelector("[name=login]").value = login;
        row.querySelector("[name=password]").value = password;

        row.addEventListener("input", ({ target: { name, value } }) => {
            fetch(`edit.php?name=${name}&value=${encodeURIComponent(value)}&id=${id}`);
        });

        row.addEventListener("click", ({ target: { dataset: { action } } }) => {
            if (action == null)
                return;
            const request = fetch(`${action}.php?id=${id}`);

            switch (action) {
                case 'duplicate':
                    request
                        .then(response => response.text())
                        .then(id => {
                            appendRow([id, login, password]);
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

        tbody.append(row);
    }

    data.forEach(appendRow);
</script>