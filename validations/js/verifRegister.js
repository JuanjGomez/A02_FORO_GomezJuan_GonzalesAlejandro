document.getElementById("username").onblur = function validaUsername() {
    let username = this.value.trim()
    let errorUser = ""
    if(/^\s+$/.test(username) || username == null || username.length == 0){
        errorUser = "El campo no puede estar vacío"
    } else if(username.length < 2){
        errorUser = "El campo debe tener al menos 2 caracteres"
    }
    document.getElementById("errorUser").innerHTML = errorUser
    verificarForm()
}
document.getElementById("nombreReal").onblur = function validaNombreReal() {
    let nombreReal = this.value.trim()
    let errorReal = ""
    if(/^\s+$/.test(nombreReal) || nombreReal == null || nombreReal.length == 0){
        errorReal = "El campo no puede estar vacío"
    } else if(nombreReal.length < 2){
        errorReal = "El campo debe tener al menos 2 caracteres"
    } else if(!letras(nombreReal)){
        errorReal = "El campo solo puede contener letras"
    }
    function letras(nombreReal){
        let regex = /^[a-zA-Z]+$/
        return regex.test(nombreReal)
    }
    document.getElementById("errorReal").innerHTML = errorReal
    verificarForm()
}
document.getElementById("email").onblur = function validaEmail() {
    let email = this.value.trim()
    let errorEmail = ""
    if(/^\s+$/.test(email) || email == null || email.length == 0){
        errorEmail = "El campo no puede estar vacío"
    } else if(!verifEmail(email)){
        errorEmail = "El email no tiene un formato válido"
    }
    function verifEmail(email){
        let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        return regex.test(email)
    }
    document.getElementById("errorEmail").innerHTML = errorEmail
    verificarForm()
}
document.getElementById("pwd").onblur = function validaPwd() {
    let pwd = this.value.trim()
    let errorPwd = ""
    if(/^\s+$/.test(pwd) || pwd == null || pwd.length == 0){
        errorPwd = "El campo no puede estar vacío"
    } else if(pwd.length < 6){
        errorPwd = "El campo debe tener al menos 6 caracteres"
    } else if(!verifPwd(pwd)){
        errorPwd = "La contraseña debe tener al menos una mayúscula, una minúscula y un número"
    }
    function verifPwd(pwd){
        let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}/
        return regex.test(pwd)
    }
    document.getElementById("errorPwd").innerHTML = errorPwd
    verificarForm()
}
document.getElementById("pwd2").onblur = function validaIgualdadPwd(){
    let pwd = document.getElementById("pwd").value.trim()
    let pwd2 = this.value.trim()
    let errorPwd2 = ""
    if(pwd!= pwd2){
        errorPwd2 = "Las contraseñas no coinciden"
    }
    document.getElementById("errorPwd2").innerHTML = errorPwd2
    verificarForm()
}
document.getElementById('rol').onmouseleave = function validaRol(){
    let rol = this.value.trim()
    let errorRol = ""
    if(rol == ""){
        errorRol = "El campo no puede estar vacío"
    }
    document.getElementById("errorRol").innerHTML = errorRol
    verificarForm()
}
function verificarForm(){
    const errores = [
        document.getElementById("errorUser").innerHTML,
        document.getElementById("errorReal").innerHTML,
        document.getElementById("errorEmail").innerHTML,
        document.getElementById("errorPwd").innerHTML,
        document.getElementById("errorPwd2").innerHTML,
        document.getElementById("errorRol").innerHTML
    ];
    const campos = [
        document.getElementById("username").value.trim(),
        document.getElementById("nombreReal").value.trim(),
        document.getElementById("email").value.trim(),
        document.getElementById("pwd").value.trim(),
        document.getElementById("pwd2").value.trim(),
        document.getElementById("rol").value.trim()
    ];
    const hayErrores = errores.some(error => error !== "")
    const camposVacios = campos.some(campo => campo === "" || campo === false)
    document.getElementById("boton").disabled = hayErrores || camposVacios
    
    const formulario = document.getElementById("indicaciones")
    if(!hayErrores && !camposVacios){
        formulario.innerHTML = "";
    }
}