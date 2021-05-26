<link rel="stylesheet" href="style.css">
<?php
include 'connect.php';

$a = $sql->query('SELECT * FROM tab') ?: die('Nie udało się pobrać rekordów');

$json = json_encode($a->fetchAll(PDO::FETCH_ASSOC));
?>

<script>
    let j = 0;
    let idk = 1;
    const arr = <?= $json ?>;

    let html = '<table border><tbody>';
    arr.forEach((row, index) => {
        html += (
            `<tr id="${row.id}">
                <td class="numW">${index + 1}</td>
                <td><input value="${row.id}" disabled></td>
                <td><input value="${row.login}" name="${idk}" data-action="edit"></td>
                <td><input value="${row.pass}" name="${idk + 1}" data-action="edit"></td>
                <td><button data-action="dup">duplikuj</button></td>
                <td><button data-action="del">x</button></td>
                <td><button data-action="clear">wyczyść</button></td>
            </tr>`
        );
        j++;
        idk += 2;
    });
    html += '</tbody></table>';

    document.write(html);

    document.querySelector('table').addEventListener('input', klik);
    document.querySelector('table').addEventListener('click', klik);

    function klik(e) {
        const getName = e.target.name;
        const getVal = e.target.value;
        const getId = e.target.parentElement.parentElement.id;
        const getAct = e.target.dataset.action;

        switch (getAct) {
            case 'dup':

                break;
            case 'del':
                document.getElementById(getId).remove();
                j--;
                break;
            case 'clear':
                document.getElementById(getId).getElementsByTagName('input')[1].value = '';
                document.getElementById(getId).getElementsByTagName('input')[2].value = '';
                break;
        }

        if (getAct != 'dup') {
            fetch(`odp.php?name=${getName}&val=${getVal}&id=${getId}&action=${getAct}`);
        } else {
            fetch(`odp.php?name=${getName}&val=${getVal}&id=${getId}&action=${getAct}`)
                .then(odp => odp.json())
                .then(v => {
                    document.querySelector('tbody').insertAdjacentHTML("beforeend", (
                        `<tr id="${v[0][0]}">
                            <td class="numW">${j + 1}</td>
                            <td><input value="${v[0][0]}" disabled></td>
                            <td><input value="${v[0][1]}" name="${idk}" data-action="edit"></td>
                            <td><input value="${v[0][2]}" name="${idk + 1}" data-action="edit"></td>
                            <td><button data-action="dup">duplikuj</button></td>
                            <td><button data-action="del">x</button></td>
                            <td><button data-action="clear">wyczyść</button></td>
                        </tr>`
                    ));
                    j++;
                });
        }

        for (let i = 0; i < document.getElementsByClassName('numW').length; i++) {
            document.getElementsByClassName('numW')[i].innerText = i + 1;
        }
    }
</script>