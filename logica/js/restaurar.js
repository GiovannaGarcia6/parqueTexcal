//El botón es controlado, apartir de que se cargue el archivo a respaldar, el botón se activará
$("#sql").change(function() {
    $(".btnRegistrar").prop("disabled", this.files.length == 0);
});
//Evento: modalRestauracion
//Descripción: Este evento es para mostrar el modal con la confirmación para realizar la restauración de la base de datos

//Constante que obtiene el modal del documento por el id.         
const modalRestauracion = document.getElementById('modalRestauracion')
modalRestauracion.addEventListener('show.bs.modal', event => {

    //Se crean constantes 
    //button devuelve el elemento relacionado con el elemento que activó el evento del mouse.
    const button = event.relatedTarget

    //Id del administrador
    const id = document.getElementById('id').value;
    //Nombre del servidor
    const servidor = document.getElementById('server').value;
    //Usuario
    const usuario = document.getElementById('username').value;
    //Contraseña
    const password = document.getElementById('password').value;
    //Nombre de la base de datos
    const bd = document.getElementById('dbname').value;
    //Archivo sql de la base de datos a restaurar
    var archivo = $('#sql').prop('files')[0];
    
    //Se utiliza form data para obtener los datos del formulario ademas de poder enviar el archivo sql
    var form_data = new FormData();
    form_data.append("id", id);
    form_data.append("servidor", servidor);
    form_data.append("usuario", usuario);
    form_data.append("password", password);
    form_data.append("bd", bd);
    form_data.append("archivo", archivo);

    //Cuando el botón sea activado por el click realizará el envío de los datos por ajax y así retornar un valor
    // el cual se verificará para mostrar el mensaje correspondiente
    document.getElementById("btnAceptar").onclick = function(event) {
        $.ajax({
            url: "../../../logica/baseDeDatos/restaurar.php",
            type: "POST",
            dataType: 'script',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(respuesta) {

                //Se limpian los datos del formulario
                $("#modalRestauracion").modal('hide');
                $('#server').val('');
                $('#username').val('');
                $('#password').val('');
                $('#dbname').val('');
                $('#sql').val('');
                $("#btnRegistrar").prop("disabled", true);

                //Dependiendo de la respuesta obtenida se mostrará un mensaje
                if (respuesta == 1) {
                    //Se muestra el mensaje de restauración exitosa
                    $("#exito").show();
                    setTimeout(function() {
                        $("#exito").slideUp(500);
                    }, 3000);
                } else {
                    if (respuesta == 2) {
                        //Se muestra el mensaje de los datos obligatorios
                        $("#datosVacios").show();
                        setTimeout(function() {
                            $("#datosVacios").slideUp(500);
                        }, 3000);
                    } else {
                        if (respuesta == 3) {
                            //Se muestra el mensaje de el tipo de archivo aceptado
                            $("#archivoError").show();
                            setTimeout(function() {
                                $("#archivoError").slideUp(500);
                            }, 3000);
                        } else {
                            if (respuesta == 4) {
                                //Se muestra el mensaje de los datos incorrectos
                                $("#datosIncorrectos").show();
                                setTimeout(function() {
                                    $("#datosIncorrectos").slideUp(500);
                                }, 3000);
                            } else {
                                //Se muestra el mensaje de un error en la restauración
                                $("#error").show();
                                setTimeout(function() {
                                    $("#error").slideUp(500);
                                }, 3000);
                            }
                        }
                    }
                }
            }
        });
    }
});