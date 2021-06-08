const tbody = document.querySelector("tbody");
const template = tbody.querySelector("template");

function fetchJson(action, options = null) {
    return fetch(`api/${action}`, options).then((response) => response.json());
}

function post(action, data) {
    return fetchJson(action, {
        method: "POST",
        body: JSON.stringify(data),
    });
}

function appendRow(columns) {
    const row = template.content.firstElementChild.cloneNode(true) as HTMLElement;
    const inputs = Array.from(row.getElementsByTagName("input"));
    const editableInputs = inputs.filter((input) => !input.disabled);
    const id = columns[0];

    const getValues = () => editableInputs.map((input) => input.value);

    inputs.forEach((input, index) => {
        input.value = columns[index];
        input.addEventListener("input", () => {
            post("edit", [id, getValues()]);
        });
    });

    function listenToButton(name, handler) {
        row.querySelector(`[name=${name}]`).addEventListener("click", () => {
            const request = post(name, [id]);
            handler(request);
        });
    }

    listenToButton("duplicate", (request) => {
        request.then((id) => {
            appendRow([id, ...getValues()]);
        });
    });

    listenToButton("delete", () => {
        row.remove();
    });

    listenToButton("clear", () => {
        for (const input of editableInputs) {
            input.value = "";
        }
    });

    tbody.append(row);
}

fetchJson("select").then((data) => {
    data.forEach(appendRow);
});
