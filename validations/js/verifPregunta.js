document.getElementById("titulo").oninput = function validaTitulo() {
    let titulo = this.value.trim();
    let errorTitulo = "";
    // Validación para el título
    if (/^\s+$/.test(titulo) || titulo == null || titulo.length == 0) {
        errorTitulo = "El campo no puede estar vacío";
    } else if (titulo.length < 5) {
        errorTitulo = "El título debe tener al menos 5 caracteres";
    }
    // Mostrar error si lo hay
    document.getElementById("errorTitulo").innerHTML = errorTitulo;
    verificarForm();
};
document.getElementById("descripcion").oninput = function validaDescripcion() {
    let descripcion = this.value.trim();
    let errorDescripcion = "";
    // Validación para la descripción
    if (/^\s+$/.test(descripcion) || descripcion == null || descripcion.length == 0) {
        errorDescripcion = "El campo no puede estar vacío";
    } else if (descripcion.length < 10) {
        errorDescripcion = "La descripción debe tener al menos 10 caracteres";
    }
    // Mostrar error si lo hay
    document.getElementById("errorDescripcion").innerHTML = errorDescripcion;
    verificarForm();
};
// Función para verificar si el formulario está correcto
function verificarForm() {
    const errores = [
        document.getElementById("errorTitulo").innerHTML,
        document.getElementById("errorDescripcion").innerHTML
    ];
    const campos = [
        document.getElementById("titulo").value.trim(),
        document.getElementById("descripcion").value.trim()
    ];
    // Verificar si hay errores
    const hayErrores = errores.some(error => error !== "");
    const camposVacios = campos.some(campo => campo === "" || campo === false);
    // Habilitar o deshabilitar el botón de acuerdo a los errores
    document.getElementById("boton").disabled = hayErrores || camposVacios;
}
