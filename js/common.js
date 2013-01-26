function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validate(form){
    var errors = {};
    clearErrors(form);
    for(var el in form.elements){
        if(form.elements[el].attributes != undefined){
            var type = form.elements[el].getAttribute("type");
            var id = form.elements[el].getAttribute("id");
            var maxlength = form.elements[el].getAttribute("maxlength");
            var required = form.elements[el].getAttribute("required");
            var value = form.elements[el].value;
            var errorEl = {};
            if(type == 'email' && !validateEmail(value)){
                errorEl.email = 'Please enter an email address.';
            }
            if(maxlength != undefined && value.length > maxlength){
                errorEl.maxlength = 'Please enter no more than {0} characters.'.replace('{0}', maxlength);
            }
            if(required != undefined && !value.length){
                errorEl.required = 'Please fill out this field.';
            }
            if(size(errorEl)){
                errors[id] = errorEl;
            }
        }
    }
    if(size(errors)){
        writeErrors(errors);
    }else{
        form.submit()
    }
    return false;
}
function size(a){
    var count = 0;

    for (i in a) {
        if (a.hasOwnProperty(i)) {
            count++;
        }
    }
    return count;
}
function writeErrors(data){
    for(var el in data){
        var ul = document.createElement("ul");
        ul.className = 'text-error';
        for(var er in data[el]){
            var li = document.createElement("li");
            li.innerHTML = data[el][er];
            ul.appendChild(li);
        }
        var input = document.getElementById(el);
        input.parentNode.insertBefore(ul,input.nextSibling);
    }
}
function clearErrors(form){
    for(var el in form.childNodes){
        if(form.childNodes[el].className == 'text-error'){
            form.removeChild(form.childNodes[el]);
        }
    }
}
