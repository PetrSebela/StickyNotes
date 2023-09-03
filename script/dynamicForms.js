const formResolve =
{
    Update: 'Update',
    Remove: 'Remove',
    Create: 'Create'
}

function sendForm(form, resolve)
{
    // set resolve
    let resolveElement = document.createElement("input")
    resolveElement.type = "hidden"
    resolveElement.name = "resolve"
    resolveElement.value = resolve;
    form.appendChild(resolveElement);

    // process text area input
    let textarea = form.querySelector("div");
    let input = document.createElement("input")
    input.type = "hidden"
    input.name = "text"
    input.value = textarea.innerHTML;
    form.appendChild(input);
    form.submit();
}