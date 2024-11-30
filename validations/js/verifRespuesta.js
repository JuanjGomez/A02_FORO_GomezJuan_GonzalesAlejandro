document.getElementById("respuesta").oninput = function validaRespuesta() {
    let respuesta = this.value.trim();
    let errorRespuesta = document.getElementById("errorRespuesta");
    // Validación para respuesta vacía o muy larga
    if (respuesta.length === 0 || respuesta === null || /^\s+$/.test(respuesta)) {
        errorRespuesta.innerHTML = "El campo no puede estar vacío";
    } else if (respuesta.length > 500) {
        errorRespuesta.innerHTML = "El campo no puede tener más de 500 caracteres";
    } else {
        errorRespuesta.innerHTML = ""; // Limpiar el error si todo está bien
    }
    // Verificar si el formulario es válido o no
    validaForm();
}
function validaForm() {
    const errorRespuesta = document.getElementById("errorRespuesta").innerHTML; // Obtenemos el mensaje de error
    const respuesta = document.getElementById("respuesta").value.trim(); // Obtenemos el valor del campo respuesta
    // Verificar si hay errores o campos vacíos
    const hayErrores = errorRespuesta !== ""; // Si hay algún error en respuesta
    const camposVacios = respuesta === ""; // Si la respuesta está vacía
    // Si hay errores o campos vacíos, deshabilitar el botón
    document.getElementById("boton").disabled = hayErrores || camposVacios;
}