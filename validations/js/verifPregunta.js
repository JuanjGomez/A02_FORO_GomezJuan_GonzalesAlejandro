document.getElementById("titulo").oninput = function validaTitulo() {
    let titulo = this.value.trim()
    let errorTitulo = ""
    if(/^\s+$/.test(titulo) || titulo == null || titulo.length == 0){
        errorTitulo = "El campo no puede estar vacío"
    } else if(titulo.length < 5){
        errorTitulo = "El título debe tener al menos 5 caracteres"
    }
    document.getElementById("errorTitulo").innerHTML = errorTitulo
    verificarForm()
} 
document.getElementById("descripcion").oninput = function validaDescripcion() {
    let descripcion = this.value.trim()
    let errorDescripcion = ""
    if(/^\s+$/.test(descripcion) || descripcion == null || descripcion.length == 0){
        errorDescripcion = "El campo no puede estar vacío"
    } else if(descripcion.length < 10){
        errorDescripcion = "La descripción debe tener al menos 10 caracteres"
    }
    document.getElementById("errorDescripcion").innerHTML = errorDescripcion
    verificarForm()
}
function verificarForm() {
    const errores = [
        document.getElementById("errorTitulo").innerHTML,
        document.getElementById("errorDescripcion").innerHTML
    ];
    const campos = [
        document.getElementById("titulo").value.trim(),
        document.getElementById("descripcion").value.trim()
    ];
    const hayErrores = errores.some(error => error !== "")
    const camposVacios = campos.some(campo => campo === "" || campo === false)
    document.getElementById("boton").disabled = hayErrores || camposVacios
}