/**
 * Función encargada de comprobar si todos los campos del formulario son correctos
 * esta función devuelve false en caso de que algun campo falle
 */
export let validacion = () =>{
    var nombre = document.getElementById("nombre").value;
    var apellidos = document.getElementById("apellidos").value;
    var email = document.getElementById("email").value;
    var telefono = document.getElementById("telefono").value;
    var dni = document.getElementById("dni").value;
    var esvalido = true;



    if( nombre == null || nombre.length == 0 || /^\s+$/.test(nombre) ) {
        document.getElementById("nombre").classList.add('is-invalid');
    } else {
        document.getElementById("nombre").classList.remove('is-invalid')
    }

    if( apellidos == null || apellidos.length == 0 || /^\s+$/.test(apellidos) ) {
        document.getElementById("apellidos").classList.add('is-invalid');
        esvalido = false;
    } else {
        document.getElementById("apellidos").classList.remove('is-invalid');
    } 

    if(!(/^((?!\.)[\w-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])/.test(email))) {
        document.getElementById("email").classList.add('is-invalid');
        esvalido = false;
    } else {
        document.getElementById("email").classList.remove('is-invalid');
    }

    if( telefono == null || telefono.length == 0 ||  !(/^\d{9}$/.test(telefono))){
        document.getElementById("telefono").classList.add('is-invalid');
        esvalido = false;
    } else {
        document.getElementById("telefono").classList.remove('is-invalid');
    }
    
    if(!(/(^[0-9]{8})([-]?)([A-Za-z]{1})/.test(dni) )) {
        document.getElementById("dni").classList.add('is-invalid');
        esvalido = false;
    } else {
        document.getElementById("dni").classList.remove('is-invalid');
    }
    return esvalido;
}