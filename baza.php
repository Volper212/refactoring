<link rel="stylesheet" href="./style.css">
<?php
include './connect.php';

$a = $sql->query('SELECT * FROM tab') ?: die('Nie udało się pobrać rekordów');

$json = json_encode($a->fetchAll(PDO::FETCH_ASSOC));

?>

<script>
    let j = 0;
    let one = 1;
    let idk = 1;
    const stuff = <?php print json_encode($json); ?>;
    let arr = new Array();
    arr = JSON.parse(stuff);

    console.log(arr[0].pass);

    let html = '<table border><tbody>';
    for (let i = 0; i < arr.length; i++) {
        html += (
            `<tr id="${arr[j].id}">
                <td class="numW">${j + 1}</td>
                <td><input value="${arr[j].id}" disabled></td>
                <td><input value="${arr[j].login}" name="${idk}" data-action="edit"></td>
                <td><input value="${arr[j].pass}" name="${idk + 1}" data-action="edit"></td>
                <td><button data-action="dup">duplikuj</button></td>
                <td><button data-action="del">x</button></td>
                <td><button data-action="clear">wyczyść</button></td>
            </tr>`
        );
        j++;
        one += 2;
        idk += 2;
    }
    html += '</tbody></table>';


    document.write(html);


    document.querySelector('table').addEventListener('input', klik);
    document.querySelector('table').addEventListener('click', klik);

    function klik(e) {
        console.log(e.srcElement);
        const getName = e.srcElement.getAttribute('name');
        const getVal = e.srcElement.value;
        const getId = e.srcElement.parentElement.parentElement.getAttribute('id');
        console.log(getId);
        const getAct = e.srcElement.getAttribute('data-action');

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
                    console.log(v);

                });
        }

        for (let i = 0; i < document.getElementsByClassName('numW').length; i++) {
            document.getElementsByClassName('numW')[i].innerText = i + 1;
        }
    }
</script>