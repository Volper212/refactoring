const tbody = document.querySelector("tbody");

function appendRow([id, ...columns]) {
    const inputs = columns.map((value) => (
        <input value={value} oninput={edit} />
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

    function edit() {
        callApi("edit", id, getValues());
    }

    function duplicate() {
        callApi("duplicate", id).then((id) => {
            appendRow([id, ...getValues()]);
        });
    }

    function delete_() {
        callApi("delete", id);
        row.remove();
    }

    function clear() {
        callApi("clear", id);
        for (const input of inputs) {
            input.value = "";
        }
    }

    const getValues = () => inputs.map((input) => input.value);

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
