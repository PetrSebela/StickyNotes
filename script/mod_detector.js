class FormData {
    constructor(form) {
        this.form_element = form
        this.valueCompare = [] 
        let valueElements = form.querySelectorAll("input");         
        
        for (let i = 0; i < valueElements.length; i++) {
            this.valueCompare.push(valueElements[i].value);
        }
        
        
        this.innerHtmlCompare = [] 
        let htmlElements = form.querySelectorAll(".textarea");

        for (let i = 0; i < htmlElements.length; i++) {
            this.innerHtmlCompare.push(htmlElements[i].innerHTML);
        }
    }

    differs(){
        let valueElements = this.form_element.querySelectorAll("input");
        for (let i = 0; i < valueElements.length; i++) {
            console.log
            if(this.valueCompare[i] != valueElements[i].value)
            {
                return true
            }
        }
                
        let htmlElements = this.form_element.querySelectorAll(".textarea");
        for (let i = 0; i < htmlElements.length; i++) {
            if(this.innerHtmlCompare[i] != htmlElements[i].innerHTML)
            {
                return true
            }
        }
        return false
    }
}

function check_content_change(form) {

    if (form.differs()) {
        form.form_element.querySelectorAll(".textarea").forEach(element => {
            console.log(element);
            let input = document.createElement("input")
            input.type = "hidden"
            input.name = element.getAttribute("name");
            input.value = element.innerHTML;
            form.form_element.appendChild(input);
        });
        
        send_form(form.form_element, form_actions.Update)
    }
}

let forms = []
window.onload = () => 
{
    var updatable_notes = document.querySelectorAll("form.editable"); 
    updatable_notes.forEach(form => {
        let form_instance = new FormData(form);
        forms.push(form_instance);

        form.addEventListener("focusout", () => {
            check_content_change(form_instance);
        });
    });
}