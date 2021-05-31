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
                <td><input disabled></td>
                <td><input></td>
                <td><input></td>
                <td><button name="duplicate">duplikuj</button></td>
                <td><button name="delete">x</button></td>
                <td><button name="clear">wyczyść</button></td>
            </tr>
        </template>
    </tbody>
</table>

<script>
    const tbody = document.querySelector("tbody");
    const template = tbody.querySelector("template");
    const data = <?= $json ?>;

    function appendRow(columns) {
        const row = template.content.firstElementChild.cloneNode(true);
        const inputs = Array.from(row.getElementsByTagName("input"));
        const editableInputs = inputs.filter(input => !input.disabled);
        const id = columns[0];

        inputs.forEach((input, index) => {
            input.value = columns[index];
            input.addEventListener("input", () => {
                fetch(`edit.php?index=${index}&value=${encodeURIComponent(input.value)}&id=${id}`);
            });
        });

        row.querySelector("[name=duplicate]").addEventListener("click", () => {
            fetch(`duplicate.php?id=${id}`)
                .then(response => response.text())
                .then(id => {
                    appendRow([id, ...editableInputs.map(input => input.value)]);
                });
        });

        row.querySelector("[name=delete]").addEventListener("click", () => {
            fetch(`delete.php?id=${id}`);
            row.remove();
        });

        row.querySelector("[name=clear]").addEventListener("click", () => {
            fetch(`clear.php?id=${id}`);
            for (const input of editableInputs) {
                input.value = '';
            }
        });

        tbody.append(row);
    }

    data.forEach(appendRow);
</script>