<link rel="stylesheet" href="style.css">
<?php
include 'connect.php';

$table = $database->query('SELECT * FROM tab') ?: die('Nie udało się pobrać zawartości tabeli. Spróbuj ponownie później.');

$json = json_encode($table->fetchAll(PDO::FETCH_ASSOC));
?>

<script>
    let count = 0;
    const data = <?= $json ?>;

    let html = '<table border><tbody>';
    data.forEach((row, index) => {
        html += (
            `<tr id="${row.id}">
                <td class="row-number">${index + 1}</td>
                <td><input value="${row.id}" disabled></td>
                <td><input value="${row.login}" name="1" data-action="edit"></td>
                <td><input value="${row.pass}" name="2" data-action="edit"></td>
                <td><button data-action="duplicate">duplikuj</button></td>
                <td><button data-action="delete">x</button></td>
                <td><button data-action="clear">wyczyść</button></td>
            </tr>`
        );
        count++;
    });
    html += '</tbody></table>';

    document.write(html);

    document.querySelector('table').addEventListener('input', handleEvent);
    document.querySelector('table').addEventListener('click', handleEvent);

    function handleEvent({ target }) {
        const name = target.name;
        const value = target.value;
        const id = target.parentElement.parentElement.id;
        const action = target.dataset.action;

        switch (action) {
            case 'duplicate':

                break;
            case 'delete':
                document.getElementById(id).remove();
                count--;
                break;
            case 'clear':
                document.getElementById(id).getElementsByTagName('input')[1].value = '';
                document.getElementById(id).getElementsByTagName('input')[2].value = '';
                break;
        }

        if (action != 'duplicate') {
            fetch(`odp.php?name=${name}&value=${value}&id=${id}&action=${action}`);
        } else {
            fetch(`odp.php?name=${name}&value=${value}&id=${id}&action=${action}`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('tbody').insertAdjacentHTML("beforeend", (
                        `<tr id="${data[0][0]}">
                            <td class="row-number">${count + 1}</td>
                            <td><input value="${data[0][0]}" disabled></td>
                            <td><input value="${data[0][1]}" name="1" data-action="edit"></td>
                            <td><input value="${data[0][2]}" name="2" data-action="edit"></td>
                            <td><button data-action="duplicate">duplikuj</button></td>
                            <td><button data-action="delete">x</button></td>
                            <td><button data-action="clear">wyczyść</button></td>
                        </tr>`
                    ));
                    count++;
                });
        }

        for (let i = 0; i < document.getElementsByClassName('row-number').length; i++) {
            document.getElementsByClassName('row-number')[i].innerText = i + 1;
        }
    }
</script>