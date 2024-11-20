document.getElementById("username").onblur = function validaUser() {
    let username = this.value.trim()
    let errorUser = ""
    if (username.length == 0 || username == null || /^\s+$/.test(username)) {
        errorUser = "El campo no puede estar vacio."
    } else if(username.length < 2){
        errorUser = "El campo debe tener al menos 2 caracteres."
    } else if(!letras(username)){
        errorUser = "El campo solo puede contener letras."
    }
    function letras(username) {
        let regex = /^[a-zA-Z]+$/;
        return regex.test(username);
    }
    document.getElementById("errorUser").innerHTML = errorUser
    validaForm()
}
document.getElementById("pwd").onblur = function validaPwd() {
    let pwd = this.value.trim()
    let errorPwd = ""
    if(pwd.length == 0 || pwd == null || /^\s+$/.test(pwd)){
        errorPwd = "El campo no puede estar vacio."
    } else if(pwd.length < 6){
        errorPwd = "El campo debe tener al menos 6 caracteres."
    } else if(!verifPwd(pwd)){
        errorPwd = "La contraseña debe tener al menos una mayúscula, una minúscula y un número"
    }
    function verifPwd(pwd) {
        let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/;
        return regex.test(pwd);
    }
    document.getElementById("errorPwd").innerHTML = errorPwd
    validaForm()
}
function validaForm(){
    const errores = [
        document.getElementById("errorUser").innerHTML,
        document.getElementById("errorPwd").innerHTML
    ];
    const campos = [
        document.getElementById("username").value.trim(),
        document.getElementById("pwd").value.trim()
    ];
    const hayErrores = errores.some(error => error !== "")
    const camposVacios = campos.some(campo => campo === "" || campo === false)
    document.getElementById("boton").disabled = hayErrores || camposVacios
}