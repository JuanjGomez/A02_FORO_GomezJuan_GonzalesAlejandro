document.getElementById("boton").oninput = function validaRespuesta() {
    let respuesta = this.value.trim()
    let errorRespuesta = document.getElementById("errorRespuesta")
    
    if(respuesta.length === 0 || respuesta === null || /^\s+$/.test(respuesta)){
        errorRespuesta.innerHTML = "El campo no puede estar vacío"
    } else if(respuesta.length >= 500){
        errorRespuesta.innerHTML = "El campo no puede tener más de 500 caracteres"
    } else {
        errorRespuesta.innerHTML = ""
    }
    document.getElementById("errorRespuesta").innerHTML = errorRespuesta
    validaForm()
}
function validaForm(){
    const errores = [
        document.getElementById("errorRespuesta")
    ];
    const campos = [
        document.getElementById("respuesta").value.trim()
    ];
    const hayErrores = errores.some(error => error.innerHTML!== "")
    const camposVacios = campos.some(campos => campos === null || campos.length === 0)
    document.getElementById("boton").disabled = hayErrores || camposVacios
}