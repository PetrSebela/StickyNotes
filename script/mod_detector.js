function check_content_change(note_id, textarea, form) {
    if (note_content[note_id] != textarea.innerHTML) {
        let input = document.createElement("input")
        input.type = "hidden"
        input.name = "note_text"
        input.value = textarea.innerHTML;
        form.appendChild(input);
        
        if(!textarea.innerHTML){
            send_form(form,form_actions.Remove)
        }
        else{
            send_form(form,form_actions.Update)
        }
    }
}
window.onload = () => 
{
    var updatable_notes = document.querySelectorAll("form.editable"); 
    note_content = {}
    console.log(updatable_notes)

    updatable_notes.forEach(form => {
        let node_id = form.querySelector(".note_id").value;
        let textarea = form.querySelector(".textarea");
        
        note_content[node_id] = textarea.innerHTML;
        
        textarea.addEventListener("focusout", () => {
            check_content_change(node_id, textarea, form);
        });
    });
}