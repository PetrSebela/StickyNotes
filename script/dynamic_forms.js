const form_actions =
{
    Update: 'Update',
    Remove: 'Remove',
    Create: 'Create'
}

function send_form(form, action)
{
    let textarea = form.querySelector("div");
    let input = document.createElement("input")
    
    switch(action)
    {
        case form_actions.Update:
            form.setAttribute("action","note_action/update_note.php");
            break;

        case form_actions.Remove:
            form.setAttribute("action","note_action/remove_note.php");
            break;

        case form_actions.Create:
            form.setAttribute("action","note_action/add_note.php");
        break;

        default:
            break;
    }
    
    input.type = "hidden"
    input.name = "text"
    input.value = textarea.innerHTML;
    form.appendChild(input);
    form.submit();
}