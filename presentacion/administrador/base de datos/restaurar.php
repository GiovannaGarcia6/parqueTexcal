<?php
session_start(); //Se inicia la sesión.
//Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
if (isset($_SESSION['usuario'])) {
    //Se obtiene el id del usuario
    $id = $_GET['id'];
} else {
    //En caso de que no se encuentre la variable de sesión se redirige al inicio de sesión.
    header("Location: ../../login/login.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Codificación de caracteres utilizada en el documento -->
    <meta charset="utf-8">
    <!-- viewport para el diseño responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Título de la página que se visualiza en la pestaña desde el navegador -->
    <title>Restauración</title>
    <!-- links de estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/estilos_Respaldo.css">
</head>
<!-- Body con la clase grid-container que alinea el contenido -->

<body class="grid-container">
    <!-- Div que contiene el renglón con el logo y nombre del sistema -->
    <div class="row">
        <nav class="col-xs-12 col-sm-12 col-md-12">
            <a href="#" class="enlace"><img src="../../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a>
        </nav>
    </div>
    <!-- Div que contiene la opción de regresar a la sección anterior enviando las variables
            Necesarias para que se muestren los datos correspondientes -->
    <div class="row">
        <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
            <a href="./baseDeDatos.php?id=<?php echo $id; ?>">Volver</a>
        </aside>
    </div>
    <div class="row">
        <section id="section" class="col-xs-12 col-sm-12 col-md-12">

            <div class="col-10 col-sm-8 col-md-4 formulario">

                <h2 style="text-align: center">RESTAURACIÓN DE LA BASE DE DATOS</h2>
                <br>

                <div class="alert alert-danger text-center" id="error" style="display:none;">
                    <strong>Ocurrió un error al restaurar la base de datos.</strong>
                </div>
                <div class="alert alert-success text-center" id="exito" style="display:none;">
                    <strong>La base de datos ha sido restaurada.</strong>
                </div>
                <div class="alert alert-danger text-center" id="datosVacios" style="display:none;">
                    <strong>Todos los datos son obligatorios, excepto la contraseña. Vuelve a intentarlo. </strong>
                </div>
                <div class="alert alert-danger text-center" id="archivoError" style="display:none;">
                    <strong>La extensión del archivo la base de datos debe ser .sql </strong>
                </div>
                <div class="alert alert-danger text-center" id="datosIncorrectos" style="display:none;">
                    <strong>Los datos son incorrectos. Vuelve a intentarlo. </strong>
                </div>
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">



                <div class="form-group row">
                    <label class="col-sm-5 col-md-4 col-form-label label"><i class="fa-solid fa-server icono"></i> Servidor</label>
                    <div class="col-sm-12 col-md-8 col-12 input">
                        <input type="text" class="form-control" id="server" name="server" placeholder="Ejemplo: 'localhost'" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-5 col-md-4 col-form-label label"><i class="fa-solid fa-user icono"></i> Usuario</label>
                    <div class="col-sm-12 col-md-8 input">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Ejemplo: 'root'" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-5 col-md-4 col-form-label label"><i class="fa-solid fa-lock icono"></i> Contraseña</label>
                    <div class="col-sm-12 col-md-8 input">
                        <input type="password" class="form-control" id="password" name="password" placeholder="*******">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-5 col-md-4 col-form-label label"><i class="fa-solid fa-database icono"></i> Base de datos</label>
                    <div class="col-sm-12 col-md-8 input">
                        <input type="text" class="form-control" id="dbname" name="dbname" placeholder="Nombre de la base de datos a restaurar" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-5 col-md-4 col-form-label label"><i class="fa-solid fa-file icono"></i> Archivo</label>
                    <div class="col-sm-12 col-md-8 input">
                        <input type="file" class="sql form-control" id="sql" name="sql" placeholder="Base de datos que deseas restaurar" required>
                    </div>
                </div>
                <button type="button" id="btnRegistrar" class="btnRegistrar btn-lg" disabled="disabled" data-bs-toggle='modal' data-bs-target='#modalRestauracion'>Restaurar</button>
            </div>
        </section>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalRestauracion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera del modal-->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Confirmación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Cuerpo del modal-->
                <div class="modal-body">
                    ¿Estás seguro de restaurar la base de datos?
                    <br>
                    Los cambios efectuados no son reversibles.
                </div>
                <!-- Pie del modal-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnAceptar" class="btn btn-danger">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!--<form Footer de la página en la que contiene el logo y los datos de la empresa-->
    <div class="row">
        <footer>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 footer1"> </div>
            </div>
            <div class="row footerRow">
                <div class="col-xs-12 col-sm-12 col-md-3 datos1">
                    <div class="logo">
                        <div class="card-body">
                            <center><img src="../../media/imagenes/logo.png" alt="" class="logoFooter"></center>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 datos2">
                    <div class="card-body ">
                        <p class="card-text" style="color:white; font-size:18px">© Derechos Reservados, Parque Estatal "El Texcal" 2022</p>
                        <p class="card-text" style="color:Yellow; font-size:20px;">DIRECCIÓN</p>
                        <p class="card-text" style="color:white; font-size:18px;">Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. 62573</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
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

            const id = document.getElementById('id').value;
            const servidor = document.getElementById('server').value;
            const usuario = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const bd = document.getElementById('dbname').value;
            var archivo = $('#sql').prop('files')[0];
            var form_data = new FormData();
            form_data.append("id", id);
            form_data.append("servidor", servidor);
            form_data.append("usuario", usuario);
            form_data.append("password", password);
            form_data.append("bd", bd);
            form_data.append("archivo", archivo);
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
                        $("#modalRestauracion").modal('hide');
                        $('#server').val('');
                        $('#username').val('');
                        $('#password').val('');
                        $('#dbname').val('');
                        $('#sql').val('');
                        $("#btnRegistrar").prop("disabled", true);

                        //Dependiendo de la respuesta obtenida se mostrará un mensaje
                        if (respuesta == 1) {
                            $("#exito").show();

                            setTimeout(function() {
                                $("#exito").slideUp(500);
                            }, 3000);
                        } else {
                            if (respuesta == 2) {
                                $("#datosVacios").show();

                                setTimeout(function() {
                                    $("#datosVacios").slideUp(500);
                                }, 3000);
                            } else {
                                if (respuesta == 3) {
                                    $("#archivoError").show();

                                    setTimeout(function() {
                                        $("#archivoError").slideUp(500);
                                    }, 3000);
                                } else {
                                    if (respuesta == 4) {
                                        $("#datosIncorrectos").show();

                                        setTimeout(function() {
                                            $("#datosIncorrectos").slideUp(500);
                                        }, 3000);
                                    } else {
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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>