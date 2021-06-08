const tbody = document.querySelector("tbody");

function appendRow([id, ...columns]) {
    const row = (
        <tr>
            <td className="row-number" />
            <td>
                <input disabled value={id} />
            </td>
        </tr>
    );

    const inputs = columns.map((value) => (
        <input
            value={value}
            oninput={() => {
                post("edit", [id, getValues()]);
            }}
        />
    ));

    const buttons = [
        <button
            className="duplicate"
            onclick={() => {
                post("duplicate", [id]).then((id) => {
                    appendRow([id, ...getValues()]);
                });
            }}
        >
            duplikuj
        </button>,
        <button
            className="delete"
            onclick={() => {
                post("delete", [id]);
                row.remove();
            }}
        >
            x
        </button>,
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
        </button>,
    ];

    const append = (elements) => row.append(...elements.map(wrapInTd));
    append(inputs);
    append(buttons);

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

const wrapInTd = (element) => <td>{element}</td>;

function createElement(name, attributes, ...children) {
    const element = document.createElement(name);
    Object.assign(element, attributes);
    element.append(...children.flat());
    return element;
}
