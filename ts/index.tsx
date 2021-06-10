const tbody = document.querySelector("tbody");

function appendRow([id, ...columns]) {
    const inputs = columns.map((value) => (
        <input
            value={value}
            oninput={() => {
                callApi("edit", id, getValues());
            }}
        />
    ));

    const row = (
        <tr>
            <td className="row-number" />
            <td>
                <input disabled value={id} />
            </td>
            {inputs.map((element) => (
                <td>{element}</td>
            ))}
            <td>
                <button
                    className="duplicate"
                    onclick={() => {
                        callApi("duplicate", id).then((id) => {
                            appendRow([id, ...getValues()]);
                        });
                    }}
                >
                    duplikuj
                </button>
            </td>
            <td>
                <button
                    className="delete"
                    onclick={() => {
                        callApi("delete", id);
                        row.remove();
                    }}
                >
                    x
                </button>
            </td>
            <td>
                <button
                    className="clear"
                    onclick={() => {
                        callApi("clear", id);
                        for (const input of inputs) {
                            input.value = "";
                        }
                    }}
                >
                    wyczyść
                </button>
            </td>
        </tr>
    );

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
