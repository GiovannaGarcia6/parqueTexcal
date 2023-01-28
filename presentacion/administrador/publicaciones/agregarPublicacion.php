<?php
session_start(); //Se inicia la sesión.
//Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
if (isset($_SESSION['usuario'])) {
    //Se obtiene el id del usuario
    $id = htmlentities($_GET['id']);
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
    <title>Nuevo Publicación</title>
    <!-- links de estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/estilos_AgregarPublicacion.css">
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
            <a href="./publicaciones.php?id=<?php echo $id; ?>">Volver</a>
        </aside>
    </div>
    <!-- Div que contiene el formulario de registro de tarea -->
    <div class="row">
        <section id="section" class="col-12 col-sm-12 col-md-12">
            <div class="col-11 col-sm-8 col-md-4 formulario">
                <!-- Formulario de registro de tarea con el action y el método para registrar -->
                <form action="../../../logica/gestionPublicacion/agregarPublicacion.php" method="post" enctype="multipart/form-data">
                    <h2 style="text-align: center">NUEVA PUBLICACIÓN</h2>
                    <!--Se verifica que exista la sesión llamada status, está ayuda a saber el estado del resultado 
                        que se retorno de la base de datos-->
                    <?php if (isset($_SESSION['status'])) {
                        //Se verifica lo que contienen la sesión, 
                        //en el que si son mensajes de éxito  se deberá crear un alert de bootstrap tipo alert-success
                        if ($_SESSION['status'] == 'Publicacion agregada con éxito.') {
                    ?>
                            <!-- Alerta de éxito -->
                            <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>
                            </div><br>
                        <?php   } else { ?>
                            <!-- Si el mensaje que contiene la sesión es porque ocurrión un problema y se debe mostrar
                            un mensaje de alerta de tipo alert-danger -->
                            <!-- Alerta de error -->
                            <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>
                            </div> <br>
                            <!-- Se refresca la página 2 segundos después para eliminar el mensaje.  -->
                    <?php   }
                        header("refresh:1; url = ./agregarPublicacion.php?id=" . $id);
                        unset($_SESSION['status']);
                    } ?><!--Se elimina la variable de sesión-->

                    <!--Input de tipo hidden que contiene el valor del id del admin-->
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <!--Selector de servicios-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-users icono"></i></span>
                        <select class="form-select" name="servicio" aria-label="Username" required>
                            <option value="">Seleccione un servicio</option>
                            <?php
                            //Archivo que contiene las funciones de las publicaciones
                            require $_SERVER['DOCUMENT_ROOT'] . '/sistema web/logica/gestionPublicacion/publicacionAdmin.php';
                            //Se llama a la función que permite mostrar a los servicios registrados en la base de datos
                            mostrarServicio("False", 0);
                            ?>
                        </select>
                    </div>
                    <!--Titulo de la publicación-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""> <i class="fa-solid fa-file-lines icono"></i></span>
                        <input type="text" autocomplete="off" class="form-control" name="titulo" placeholder="Título de la publicación" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <!--Descripción de la publicación-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""><i class="fa-solid fa-align-left icono"></i></span>
                        <textarea class="form-control" placeholder="Descripción de la publicación" name="publicacion" style="height: 100px"></textarea>
                    </div>
                    <!--Selector del tipo de archivo-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text"><i class="fa-solid fa-photo-film icono"></i></span>
                        <select class="form-select" name="tipoPublicacion" aria-label="Username" onchange="habilitar(this);" required>
                            <option value="Video">Video</option>
                            <option value="Imagen">Imagen</option>
                        </select>
                    </div>
                    <!--Input para subir la imagen-->
                    <div id="imagen" class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""> <i class="fa-solid fa-link icono"></i></span>
                        <input type="file" class="form-control" name="imagen" aria-label="Username" aria-describedby="addon-wrapping">
                    </div>
                    <!--Input para el enlace del video-->
                    <div id="video" class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""> <i class="fa-solid fa-link icono"></i></span>
                        <input type="text" autocomplete="off" class="form-control" name="video" placeholder="Enlace del video de Youtube" aria-label="Username" aria-describedby="addon-wrapping">
                    </div>
                    <!--Botón para realizar el registro de la publicación-->
                    <button class="btnRegistrar btn-lg" type="submit">Registrar</button>
                </form>
            </div>
        </section>
    </div>
    <!-- Footer de la página en la que contiene el logo y los datos de la empresa-->
    <div class="row">
        <footer>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 footer1"> </div>
            </div>
            <!--Logo-->
            <div class="row footerRow">
                <div class="col-xs-12 col-sm-12 col-md-3 datos1">
                    <div class="logo">
                        <div class="card-body">
                            <center><img src="../../media/imagenes/logo.png" alt="" class="logoFooter"></center>
                        </div>
                    </div>
                </div>
                <!--Información de la ubicación del parque-->
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
    <!--Este script permite ocultar por primera vez ocultar el input para subir la imagen,
        ya que al principio esta activa la opción del video-->
    <script>
        var inputImagen = document.getElementById('imagen');
        var inputVideo = document.getElementById('video');
        inputVideo.style.display = ''; //Mostrar
        inputImagen.style.display = 'none'; //Ocultar
    </script>
    <!--Una vez cambie el estado del selector procedera a utilizar este script que determinara que inputs habilitar-->
    <script src="../../../logica/js/habilitarInputs.js"></script>
    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>