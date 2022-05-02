class AlertBox {
    constructor({ head, message = null, code = null, age=3000 }) {
        this.head = head;
        this.message = message == null ? "" : message;
        this.code = code == null ? "" : code;
        this.age = age;
        this.bg_class = null;
        this.doc = document.getElementById("alert_holder");
    }

    error() {
        this.bg_class = "bg-danger";
        this.html();
    }
    success(){
        this.bg_class = "bg-success";

        this.html();
    }
    html() {
        var prantDiv = document.createElement("div");
        var chiledspan = document.createElement("span");
        var chiledp = document.createElement("p");
        prantDiv.classList.add("alert_box", this.bg_class);
        chiledp.innerHTML = ` ${this.message}`;
        chiledspan.innerHTML = `${this.code} ${this.head}`;
        // chiledspan.appendChild(this.icon)
        prantDiv.appendChild(chiledspan);
        prantDiv.appendChild(chiledp);
        this.doc.appendChild(prantDiv);
        setTimeout(() => {
            this.doc.removeChild(prantDiv);
        }, this.age);
    }
}

class PreLoader {
    constructor(position) {
        this.position = position;
        this.loader_container = document.createElement("div");
        var loader_wrapper = document.createElement("div");
        var loader = document.createElement("div");
        var loader_inner = document.createElement("div");

        this.loader_container.classList.add("lds-container");
        loader_wrapper.classList.add("loader-wrapper");
        loader.classList.add("loader");
        loader_inner.classList.add("loader", "loader-inner");

        this.loader_container.appendChild(loader_wrapper);
        loader_wrapper.appendChild(loader);
        loader.appendChild(loader_inner);
    }

    start() {
        this.position.appendChild(this.loader_container);
    }

    stop() {
        this.position.removeChild(this.loader_container);
    }
}

class FormClass {
    constructor(element) {
        this.element = element;
        this.validation_man = {
            alpha_num: {
                regex: /^[a-zA-Z0-9-_]+(([',. -][a-zA-Z ])?[a-zA-Z0-9-_]*)*$/,
                err_msg: "Please provide valid Hostname",
            },
            name: {
                regex : /^[a-zA-Z\- ]+$/,
                err_msg : "Enter a valid name"
            },
            username: {
                regex : /^[a-zA-Z0-9]+$/,
                err_msg : "Enter a valid name"
            },
            password: {
                regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/,
                err_msg : "Strictly follow the rules given below"
            },
            serial_key: {
                regex: /^([a-zA-Z0-9]){16}$/,
                err_msg: "Enter a valid serial key. It must be 16 characters",
            },
            email: {
                regex : /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/,
                err_msg : "Enter a valid Email"
            },
            opassword: {
                regex : /^(?=.{8,})/,
                err_msg : "Enter a valid old password"
            }
        };

    }datatype
    validate() {
        let validation_man = this.validation_man;
        this.element.forEach(function (element) {
            element.addEventListener("keyup", function (e) {
                var datatype = String(this.getAttribute("aria-datatype"));
                var isRequired = this.getAttribute("aria-required");
                var info_msg = isRequired ? "*Requierd" : "Optional";
                if (this.value.trim() == "") {
                    this.classList.add("input-invalid");
                    this.previousElementSibling.classList.add("error-text");
                    this.nextElementSibling.classList.add("error-text");
                    this.nextElementSibling.innerHTML = info_msg;
                    
                }
                 else if (
                    !validation_man[datatype]['regex'].test(this.value.trim())
                ) {
                    this.classList.add("input-invalid");
                    this.previousElementSibling.classList.add("error-text");
                    this.nextElementSibling.classList.add("error-text");

                    this.nextElementSibling.innerHTML =
                        validation_man[datatype]["err_msg"];
                } 
                else {
                    this.classList.remove("input-invalid");
                    this.previousElementSibling.classList.remove("error-text");
                    this.nextElementSibling.classList.remove("error-text");
                    this.nextElementSibling.innerHTML = info_msg;
                }
                if(datatype == "password"){
                    var lower = document.querySelector('[role="lowercase-char"]')
                    var upper = document.querySelector('[role="uppercase-char"]')
                    var numeric = document.querySelector('[role="numeric-char"]')
                    var special = document.querySelector('[role="special-char"]')
                    var max = document.querySelector('[role="max-char"]')

                    if(this.value.trim() == "" || ! /^(?=.*[a-z])/.test(this.value.trim())){
                        if (!lower.classList.contains('error-text')) {
                            if (lower.classList.contains('success-text')) {
                                lower.classList.remove('success-text')
                            }
                            lower.classList.add('error-text')
                        }
                    }else{
                        if (!lower.classList.contains('success-text')) {
                            if (lower.classList.contains('error-text')) {
                                lower.classList.remove('error-text')
                            }
                            lower.classList.add('success-text')
                        }
                    }

                    if(this.value.trim() == "" || ! /^(?=.*[A-Z])/.test(this.value.trim())){
                        if (!upper.classList.contains('error-text')) {
                            if (upper.classList.contains('success-text')) {
                                upper.classList.remove('success-text')
                            }
                            upper.classList.add('error-text')
                        }
                    }else{
                        if (!upper.classList.contains('success-text')) {
                            if (upper.classList.contains('error-text')) {
                                upper.classList.remove('error-text')
                            }
                            upper.classList.add('success-text')
                        }
                    }

                    if(this.value.trim() == "" || ! /^(?=.*[0-9])/.test(this.value.trim())){
                        if (!numeric.classList.contains('error-text')) {
                            if (numeric.classList.contains('success-text')) {
                                numeric.classList.remove('success-text')
                            }
                            numeric.classList.add('error-text')
                        }
                    }else{
                        if (!numeric.classList.contains('success-text')) {
                            if (numeric.classList.contains('error-text')) {
                                numeric.classList.remove('error-text')
                            }
                            numeric.classList.add('success-text')
                        }
                    }

                    if(this.value.trim() == "" || ! /^(?=.*[!@#\$%\^&\*])/.test(this.value.trim())){
                        if (!special.classList.contains('error-text')) {
                            if (special.classList.contains('success-text')) {
                                special.classList.remove('success-text')
                            }
                            special.classList.add('error-text')
                        }
                    }else{
                        if (!special.classList.contains('success-text')) {
                            if (special.classList.contains('error-text')) {
                                special.classList.remove('error-text')
                            }
                            special.classList.add('success-text')
                        }
                    }
                    if(this.value.trim() == "" || ! /^(?=.*[!@#\$%\^&\*])/.test(this.value.trim())){
                        if (!special.classList.contains('error-text')) {
                            if (special.classList.contains('success-text')) {
                                special.classList.remove('success-text')
                            }
                            special.classList.add('error-text')
                        }
                    }else{
                        if (!special.classList.contains('success-text')) {
                            if (special.classList.contains('error-text')) {
                                special.classList.remove('error-text')
                            }
                            special.classList.add('success-text')
                        }
                    }

                    if(this.value.trim() == "" || ! /^(?=.{8,})/.test(this.value.trim())){
                        if (!max.classList.contains('error-text')) {
                            if (max.classList.contains('success-text')) {
                                max.classList.remove('success-text')
                            }
                            max.classList.add('error-text')
                        }
                    }else{
                        if (!max.classList.contains('success-text')) {
                            if (max.classList.contains('error-text')) {
                                max.classList.remove('error-text')
                            }
                            max.classList.add('success-text')
                        }
                    }
                }
            });
        });
    }

    submit(formData, action, method, parentEle,thisEle,redirect) {
        for (var key of formData.keys()) {
            var curr_ele = document.getElementById(key)
            if (curr_ele != null) {
                var datatype = curr_ele.getAttribute("aria-datatype");
                var isRequired = curr_ele.getAttribute("aria-required");
                var info_msg = isRequired ? "*Requierd" : "Optional";

                if (formData.get(key).trim() == "" && isRequired) {
                    curr_ele.classList.add("input-invalid");
                    curr_ele.previousElementSibling.classList.add("error-text");
                    curr_ele.nextElementSibling.classList.add("error-text");
                    curr_ele.nextElementSibling.innerHTML = info_msg;
                    curr_ele.focus();

                    return;
                }else if(datatype != null){
                    if (
                        !this.validation_man[datatype]['regex'].test(
                            formData.get(key).trim()
                        )
                    ) {
                        curr_ele.classList.add("input-invalid");
                        curr_ele.previousElementSibling.classList.add("error-text");
                        curr_ele.nextElementSibling.classList.add("error-text");
                        curr_ele.nextElementSibling.innerHTML =
                        this.validation_man[datatype]["err_msg"];
                        curr_ele.focus();
                        return;
                    }
                }
                
                
            }
        }

        this.send(formData, action, method, parentEle,thisEle,redirect);
    }
    send(formData, action, method, parentEle,thisEle,redirect) {
        var preloader = new PreLoader(parentEle);
        $.ajax({
            url: action,
            type: method,
            data: formData,
            beforeSend: function () {
                preloader.start();
            },
            success: function (result) {
                preloader.stop();
                var alertBox = new AlertBox({
                    head: result.head,
                    message: result.message,
                    age: 3000,
                });
                alertBox.success();
                thisEle.get(0).reset()
                if(redirect){
                    setTimeout(() => {
                        window.history.back()
                    }, 2000);
                }

            },
            error: function (e) {
                if(e.status == 422){
                    for (const key in e.responseJSON.errors) {
                        var alertBox = new AlertBox({
                            head: e.responseJSON.message,
                            message: e.responseJSON.errors[key][0],
                            age: 3000,
                        });
                        alertBox.error();
                    }
                }else if(e.status == 409){
                    var alertBox = new AlertBox({head: e.responseJSON.head,message:e.responseJSON.message});
                    alertBox.error();
                }
                else{
                    var alertBox = new AlertBox({
                        code: e.status,
                        head: e.statusText,
                        age: 3000,
                    });
                    alertBox.error();
                }
                

                preloader.stop();
            },
            cache: false,
            contentType: false,
            processData: false,
        });
        return;
    }
}

class Ajax{
    fetch(url,doc){

        var preloader = new PreLoader(doc);
        $.ajax({
            url: url,
            type: "GET",
            beforeSend: function () {
                preloader.start()
            },
            success: function (result) {
                // preloader.stop()
                $(doc).html(result)
                
            },
            error: function (e) {
                var alertBox = new AlertBox({head:e.responseJSON.head,message:e.responseJSON.message,code:e.responseJSON.code,age:3000});
                var html = `<div class="mt-4"><h1 class="h4 text-dark text-center">${e.responseJSON.head}</h1><div><p class="text-center text-dark">${e.responseJSON.message}</p>`
                alertBox.error()
                $(doc).html(html)
                // preloader.stop()
                

            },
            cache: false,
            contentType: false,
            processData: false,
        });
       return 
    }

    action(url){
        $.ajax({
            url: url,
            type: "GET",
            beforeSend: function () {

            },
            success: function (result) {
                var alertBox = new AlertBox({head:result.head,message:result.message,age:3000});
                alertBox.success()
            },
            error: function (e) {
                var alertBox = new AlertBox({head:e.responseJSON.head,message:e.responseJSON.message,code:e.responseJSON.code,age:3000});
                alertBox.error()

            },
            cache: false,
            contentType: false,
            processData: false,
        });
       return 
    }
}