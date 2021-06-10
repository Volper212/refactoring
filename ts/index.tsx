const tbody = document.querySelector("tbody");

function appendRow([id, ...columns]) {
    const inputs = columns.map((value) => (
        <input
            value={value}
            oninput={() => {
                post("edit", [id, getValues()]);
            }}
        />
    ));

    const row = (
        <tr>
            <td className="row-number" />
            <td>
                <input disabled value={id} />
            </td>
            {inputs.map((element) => <td>{element}</td>)}
            <td>
                <button
                    className="duplicate"
                    onclick={() => {
                        post("duplicate", [id]).then((id) => {
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
                        post("delete", [id]);
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
                        post("clear", [id]);
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

fetchJson("select").then((data) => {
    data.forEach(appendRow);
});

function fetchJson(action, options = null) {
    return fetch(`api/${action}`, options).then((response) => response.json());
}

function post(action, data) {
    return fetchJson(action, {
        method: "POST",
        body: JSON.stringify(data),
    });
}

function createElement(name, attributes, ...children) {
    const element = document.createElement(name);
    Object.assign(element, attributes);
    element.append(...children.flat());
    return element;
}
