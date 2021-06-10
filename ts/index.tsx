const tbody = document.querySelector("tbody");

function appendRow([id, ...columns]) {
    const inputs = columns.map((value) => (
        <input value={value} oninput={update} />
    ));

    const row = (
        <tr>
            <td className="row-number" />
            <td>
                <input disabled value={id} />
            </td>
            {inputs.map((input) => (
                <td>{input}</td>
            ))}
            <td>
                <button className="duplicate" onclick={duplicate}>
                    duplikuj
                </button>
            </td>
            <td>
                <button className="delete" onclick={delete_}>
                    x
                </button>
            </td>
            <td>
                <button className="clear" onclick={clear}>
                    wyczyść
                </button>
            </td>
        </tr>
    );

    function update() {
        columns = inputs.map((input) => input.value);
        callApi("edit", id, columns);
    }

    function duplicate() {
        callApi("duplicate", id).then((id) => {
            appendRow([id, ...columns]);
        });
    }

    function delete_() {
        callApi("delete", id);
        row.remove();
    }

    function clear() {
        for (const input of inputs) {
            input.value = "";
        }
        update();
    }

    tbody.append(row);
}

callApi("select").then((data) => {
    data.forEach(appendRow);
});

function callApi(action, ...parameters) {
    const options =
        parameters.length === 0
            ? null
            : { method: "POST", body: JSON.stringify(parameters) };
    return fetch(`api/${action}`, options).then((response) => response.json());
}

function createElement(name, attributes, ...children) {
    const element = document.createElement(name);
    Object.assign(element, attributes);
    element.append(...children.flat());
    return element;
}
